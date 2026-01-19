<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Enum\AccountStatus;
use App\Entity\Enum\UserRole;
use App\Entity\User;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * Creates the initial admin user for the platform.
 */
class AdminUserFixture extends Fixture implements FixtureGroupInterface
{
    public const ADMIN_EMAIL = 'admin@homepet.local';
    public const ADMIN_PASSWORD = 'P3tH0m3@Adm1n!2026';
    public const ADMIN_REFERENCE = 'admin-user';

    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher,
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $admin = new User();
        $admin->setEmail(self::ADMIN_EMAIL);
        $admin->setFirstName('Admin');
        $admin->setLastName('HomePet');
        $admin->setPhone('+39 000 0000000');
        $admin->setStatus(AccountStatus::ACTIVE);
        $admin->setEmailVerifiedAt(new DateTimeImmutable('now', new \DateTimeZone('UTC')));

        // Set roles
        $admin->setRoles([
            UserRole::ADMIN->value,
            UserRole::OWNER->value,
            UserRole::HOST->value,
        ]);

        // Hash password
        $hashedPassword = $this->passwordHasher->hashPassword($admin, self::ADMIN_PASSWORD);
        $admin->setPassword($hashedPassword);

        $manager->persist($admin);
        $manager->flush();

        // Add reference for other fixtures
        $this->addReference(self::ADMIN_REFERENCE, $admin);
    }

    public static function getGroups(): array
    {
        return ['admin', 'base'];
    }
}
