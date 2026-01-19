# Claude – Project Instructions

These instructions apply to this Symfony project. Claude should follow them whenever suggesting code.

## General style

- All code comments must be written in English.
- Follow PSR-12 and Symfony coding standards.
- Use clear and descriptive names for classes, methods, variables, and services.
- Prefer explicit types everywhere (PHP 8.3+): avoid `mixed` and untyped arrays when possible.

## Architecture & Symfony conventions

- Prefer constructor dependency injection for all services and avoid static calls.
- When generating Symfony code, always create or use services instead of standalone functions.
- Whenever possible, use existing Symfony components and subsystems instead of custom ad-hoc code  
  (for example: Form, Validator, Security, HttpFoundation, HttpClient, EventDispatcher, Messenger, Serializer, Workflow).
- Always create dedicated DTOs for API input and output. Do not expose Doctrine entities directly in controllers or API responses.
- Use repositories (or dedicated query services) for all database queries. Do not put query logic in controllers.
- Keep configuration out of the code: use environment variables and Symfony configuration files  
  (`config/*.php` or `config/packages/*.yaml`) instead of hard-coded values.
- Avoid duplicated logic: extract shared behavior into reusable services, traits, or helpers.

## Constants & strings

- Always use constants (or enums) for labels, roles, statuses, and repeated string values.
- Keep user-facing labels centralized and avoid hard-coded magic strings in the code.

## Validation, errors & robustness

- Always validate incoming data using the Symfony Validator component (constraints on DTOs or forms/command objects).
- In controllers and services, handle errors explicitly: do not use empty or silent catch blocks.
- When catching exceptions, either log them (using the Symfony logger) or transform them into meaningful domain/application exceptions.

## External integrations

- When interacting with external APIs or services, encapsulate the logic in dedicated client services.
- Do not call external APIs directly from controllers; always use injected services instead.

## Assets (JavaScript & CSS)

- JavaScript and CSS must always be written in separate files, never inline inside Twig or PHP files.
- Follow Symfony Asset Mapper conventions for managing assets:
  - Place source assets in the appropriate `assets/` directory.
  - Use ES modules and entry points instead of inline `<script>` or `<style>` blocks.
  - Reference assets via Symfony helpers (for example asset mapper / asset functions in Twig), not with hard-coded URLs.

## Testing & documentation

- Whenever non-trivial logic is added, also generate or update unit tests (for example PHPUnit tests for services, DTO mappers, and domain logic).
- Document all public methods with PHPDoc blocks that describe the purpose, parameters, and return types.

## Testing

### Test Suites

- **Unit tests**: Fast tests without external dependencies (database, network)
  - Location: `tests/Entity/`, `tests/Service/`, `tests/Repository/`, `tests/Command/`
  - Run with: `vendor/bin/phpunit --testsuite Unit`

- **Integration tests**: Tests that require database connection
  - Location: `tests/Integration/`
  - Run with: `vendor/bin/phpunit --testsuite Integration`
  - Require test database setup first: `bin/setup-test-db`

### Test Database

- Uses PostgreSQL database `keycandle_test`
- Configuration in `.env.test`
- Setup script: `bin/setup-test-db` (creates database and runs migrations)

### Writing Integration Tests

- Extend `DatabaseTestCase` for tests that need database access
- Extend `FixtureTestCase` for tests that need pre-populated data
- Use `$this->persistAndFlush()` to save entities
- Use `$this->clearEntityManager()` to ensure fresh reads from database
- Each test runs in a transaction that is rolled back after the test

### Running Tests

```bash
# Run all tests
vendor/bin/phpunit

# Run only unit tests (fast)
vendor/bin/phpunit --testsuite Unit

# Run only integration tests
vendor/bin/phpunit --testsuite Integration

# Run only functional tests (auth, API controllers)
vendor/bin/phpunit --testsuite Functional

# Run authentication tests only
vendor/bin/phpunit tests/Controller/Functional/AuthControllerFunctionalTest.php
vendor/bin/phpunit tests/Controller/Functional/LoginFunctionalTest.php
vendor/bin/phpunit tests/Controller/Functional/RegistrationFunctionalTest.php
vendor/bin/phpunit tests/Controller/Functional/PasswordResetFunctionalTest.php

# Run with coverage (requires XDEBUG_MODE=coverage)
XDEBUG_MODE=coverage vendor/bin/phpunit --coverage-html var/coverage
```
# Claude – Symfony Project Instructions

These instructions apply to **any Symfony project**. Claude should follow them whenever suggesting code, architecture, configuration, tests, or tooling.

---

## Table of Contents

1. [General Style](#1-general-style)
2. [Architecture & Symfony Conventions](#2-architecture--symfony-conventions)
3. [HTTP, Controllers & APIs](#3-http-controllers--apis)
4. [Persistence (Doctrine/DBAL) & Data Access](#4-persistence-doctrinedbal--data-access)
5. [Configuration & Environment](#5-configuration--environment)
6. [Constants, Enums, Translations](#6-constants-enums-translations)
7. [Validation, Errors & Robustness](#7-validation-errors--robustness)
8. [Messaging, Events & Background Jobs](#8-messaging-events--background-jobs)
9. [Security](#9-security)
10. [External Integrations](#10-external-integrations)
11. [Frontend Assets (JS/CSS/Twig)](#11-frontend-assets-jscsstwig)
12. [Internationalization (i18n)](#12-internationalization-i18n)
13. [Testing](#13-testing)
14. [Code Quality & Tooling](#14-code-quality--tooling)
15. [Documentation](#15-documentation)
16. [Common Hazards & Traps](#16-common-hazards--traps)

---

## 1. General Style

- **Language**: All code comments must be written in **English**.
- **Strict Types**: Always use `declare(strict_types=1);`.
- **Standards**: Follow **PSR-12** and Symfony coding standards.
- **Naming**: Use clear and descriptive names for classes, methods, variables, services, and events.
- **Explicit Types (PHP 8.3+)**:
  - Prefer typed properties and return types everywhere.
  - Avoid `mixed` unless unavoidable.
  - Avoid untyped arrays when possible; prefer typed DTOs/collections/value objects.

---

## 2. Architecture & Symfony Conventions

### 2.1 Layering

Keep the codebase modular and testable. A common structure:

- `src/Domain/`
  - Domain model: entities/aggregates, value objects, domain events, domain services, domain exceptions, enums.
- `src/Application/`
  - Use cases: commands/queries + handlers, application services, DTOs, ports (interfaces) to infrastructure.
- `src/Infrastructure/`
  - Doctrine repositories, persistence implementations, external clients, cache, message transport, filesystem.
- `src/UI/Http/` (or `src/Interface/Http/`)
  - Controllers, request/response mapping, voters, normalizers, exception listeners, view models.

**Rules**
- Controllers are thin: validate + authorize + call a use case + map response.
- Domain must not depend on Symfony or Doctrine.
- Infrastructure can depend on Symfony/Doctrine; not the reverse.

### 2.2 Dependency Injection

- Prefer **constructor injection** for services.
- Avoid injecting `ContainerInterface` and avoid service-locator patterns.
- Avoid static calls and static state.
- Prefer small, cohesive services. Split responsibilities early.

### 2.3 Prefer Symfony Components

Use framework subsystems instead of ad-hoc solutions when applicable:
- Validator, Serializer, Messenger, HttpClient, Security, EventDispatcher, Workflow, RateLimiter, Cache, Lock, Mailer, Notifier.

---

## 3. HTTP, Controllers & APIs

### 3.1 Controller Responsibilities

Controllers should:
- Parse input (Request DTO / Form)
- Validate input (Validator/Form)
- Authorize (Security/Voters)
- Call application use cases
- Return response (DTO/View Model -> JSON/Twig)

Controllers should **not**:
- Contain business logic
- Run database queries directly
- Call external services directly

### 3.2 DTOs & Mapping

- Always create dedicated **Request DTOs** and **Response DTOs/View Models**.
- **Never** expose Doctrine entities directly in API responses.
- Prefer explicit mappers (e.g., `XxxRequestMapper`, `XxxViewMapper`).

### 3.3 API Error Format

- Centralize exception-to-HTTP mapping (listener/subscriber).
- Prefer consistent API error responses (recommend **RFC7807 Problem Details** style).
- Never swallow errors; log unexpected exceptions with context.

---

## 4. Persistence (Doctrine/DBAL) & Data Access

### 4.1 Query Boundaries

- Use **repositories** (or dedicated query services) for all database reads.
- Do not put query logic in controllers.

### 4.2 Doctrine Best Practices

- Avoid N+1 by using fetch joins or explicit select strategies where appropriate.
- Keep write operations transactional at the application/service layer when needed.
- Use Doctrine Migrations for all schema changes and commit them.

### 4.3 UTC Constraint (Recommended Default)

- Store timestamps in **UTC** in the database.
- Convert to user timezone only at the presentation layer (Twig/UI/frontends).
- Avoid ambiguous datetime parsing; prefer ISO 8601 with timezone (`Z` or `+00:00`).
- Prefer `DateTimeImmutable` over mutable `DateTime`.

---

## 5. Configuration & Environment

### 5.1 Configuration Rules

- Keep configuration out of code:
  - use `.env`, `.env.local`, `.env.test` and `config/packages/*`.
- Use `%env()%` in configuration, not deep inside services.
- Use Symfony **Secrets** for production secrets when applicable.

### 5.2 Environment Isolation

- Keep prod/staging/test isolated:
  - Separate databases, queues, storage buckets, API keys.
- Never run destructive commands against non-test DBs from test tooling.

---

## 6. Constants, Enums, Translations

- Use **Enums** for:
  - statuses/states
  - roles/permissions
  - event types
  - repeated string values
- Centralize user-facing labels:
  - use Symfony **Translation** files (`translations/`) for UI strings.
- Avoid hard-coded magic strings and repeated literals.

---

## 7. Validation, Errors & Robustness

### 7.1 Input Validation

- Always validate external input using Symfony **Validator**:
  - constraints on DTOs, Forms, or command objects.
- Validate at the boundary (controller/handler), not deep in services.
- Prefer custom constraints for cross-field or domain-specific checks.

### 7.2 Error Handling

- Never use empty catch blocks.
- When catching exceptions:
  - log them (Monolog) **and/or**
  - convert them into meaningful domain/application exceptions.

### 7.3 Verification Loop (Before Commit)

Always run a verification loop before committing changes:

```bash
composer validate
composer install

# Static analysis & style (if configured)
vendor/bin/phpstan analyse
vendor/bin/php-cs-fixer fix --dry-run --diff

# Tests
vendor/bin/phpunit
```

---

## 8. Messaging, Events & Background Jobs

### 8.1 Messenger

- Use Symfony **Messenger** for async/background tasks (emails, exports, webhooks, heavy computations).
- Handlers must be **idempotent** (retries happen).
- Use retry strategies with backoff, and log failures with sufficient context.

### 8.2 Domain Events

- Use domain events for business-significant transitions.
- Dispatch from the application layer (or via a domain event collector pattern).
- Avoid side effects inside domain entities.

---

## 9. Security

- Centralize authorization with **Voters** and access control rules.
- Never trust client-provided user identifiers; derive identity from the authenticated user.
- Use RateLimiter for endpoints vulnerable to abuse (login, password reset, public APIs).
- Use CSRF protection for browser forms; avoid CSRF for stateless APIs only when appropriate.

---

## 10. External Integrations

- Encapsulate external APIs in dedicated client services.
- Do not call external APIs from controllers.
- Use Symfony **HttpClient** and configure:
  - base_uri, timeouts, retries, and headers in `config/packages/*`.
- Handle non-2xx responses explicitly; map them to meaningful errors.
- Log with correlation identifiers (request id, entity id, etc.).

---

## 11. Frontend Assets (JS/CSS/Twig)

- JavaScript and CSS must be in separate files; never inline in Twig or PHP.
- Follow Symfony **Asset Mapper** conventions when applicable:
  - assets under `assets/`
  - ES modules + entrypoints
  - reference via Twig helpers (no hard-coded URLs)
- Keep Twig templates presentational:
  - no business logic; keep complex formatting in view models/normalizers.

---

## 12. Internationalization (i18n)

- Use Symfony Translation component for user-facing text.
- Keep translation keys stable and structured (`domain.section.key`).
- Add tooling (optional) to detect missing keys in CI.

---

## 13. Testing

### 13.1 4-Tier Testing Architecture

| Tier | Location | Purpose | Speed |
|------|----------|---------|-------|
| **Unit** | `tests/Unit/` | Pure PHP (domain + app logic) | ⚡ Fast |
| **Integration** | `tests/Integration/` | Real DB/Doctrine boundaries | 🐢 Slow |
| **Functional** | `tests/Functional/` | HTTP kernel request/response | 🔶 Medium |
| **E2E** | `tests/E2E/` | Full user workflows (browser) | 🐌 Very Slow |

### 13.2 Test Pyramid (Recommended)

- **Unit (70–80%)**: logic branches, invariants, value objects, mappers.
- **Integration (15–20%)**: persistence boundaries and transactions.
- **Functional (10–15%)**: routing, security, controller mapping, error format.
- **E2E (5–10%)**: critical happy paths only.

### 13.3 Standards

- Follow **Arrange → Act → Assert**.
- Unit tests: no network, no DB, no filesystem unless explicitly mocked.
- Use factories/builders for test data.
- Avoid flaky time-dependent tests:
  - inject a clock abstraction (or use Symfony Clock component) where needed.

### 13.4 Unique Data in Tests

- Use unique identifiers (timestamps/UUIDs) to avoid collisions between runs.
- Reset state between tests (transactions/fixtures) depending on suite.

### 13.5 Running Tests (Example)

```bash
# All tests
vendor/bin/phpunit

# Suites (if configured)
vendor/bin/phpunit --testsuite Unit
vendor/bin/phpunit --testsuite Integration
vendor/bin/phpunit --testsuite Functional
```

---

## 14. Code Quality & Tooling

- Prefer fixing issues over excluding them.
- Recommended tooling:
  - `phpstan` (or Psalm) for static analysis
  - `php-cs-fixer` for coding standards
  - Symfony PHPUnit Bridge (optional)
- Keep CI deterministic and fast; cache Composer dependencies.

---

## 15. Documentation

- Prefer strong typing + self-documenting code.
- Use PHPDoc only when it adds value:
  - complex behavior, generics, tricky invariants, `@throws` where relevant.
- Keep system docs in `docs/` and update them when behavior changes.

---

## 16. Common Hazards & Traps

### 16.1 Environment & Infra

| Hazard | Symptom | Resolution |
|--------|---------|------------|
| Wrong env vars loaded | config mismatch | use `.env.local`, `.env.test`, verify `APP_ENV` |
| Proxy headers | wrong scheme/host | configure trusted proxies + `X-Forwarded-*` |
| Stale cache | unexpected behavior | clear `var/cache/*` or use `cache:clear` |
| Docker host loopback | connection errors | use proper Docker networking / `host.docker.internal` |

### 16.2 Doctrine

| Hazard | Symptom | Resolution |
|--------|---------|------------|
| N+1 queries | slow endpoints | fetch joins / optimized read models |
| Lazy-loading in serialization | huge payloads | map to DTOs; avoid serializing entities |
| Transaction gaps | partial writes | wrap use case in a transaction |

### 16.3 Time & Dates

| Hazard | Symptom | Resolution |
|--------|---------|------------|
| Ambiguous datetime | incorrect ordering | use UTC + ISO 8601 with timezone |
| Mutable DateTime | hidden side effects | prefer immutable (`DateTimeImmutable`) |

### 16.4 Error Handling

| Hazard | Symptom | Resolution |
|--------|---------|------------|
| Silent catch blocks | missing failures | log + rethrow / convert to domain exception |
| Inconsistent API errors | client confusion | centralize exception mapping + consistent format |
