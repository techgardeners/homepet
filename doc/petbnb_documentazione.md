# PetBnB (ex DogBnB) — Documentazione struttura web app (Marketplace multi‑pet)
> Versione: 1.0  
> Lingua: IT  
> Obiettivo: documento di riferimento per struttura, pagine e funzionalità dell’applicazione web.

---

## Indice
1. [Visione prodotto](#1-visione-prodotto)  
2. [Servizi](#2-servizi)  
3. [Matching](#3-matching)  
4. [Meet & Greet](#4-meet--greet)  
5. [Trust & Safety](#5-trust--safety)  
6. [Pricing & Incentivi](#6-pricing--incentivi)  
7. [Pagamenti, escrow e payout](#7-pagamenti-escrow-e-payout)  
8. [Compliance & Tax](#8-compliance--tax)  
9. [MVP e roadmap](#9-mvp-e-roadmap)  
10. [Posizionamento](#10-posizionamento)  
11. [Naming & direzione brand](#11-naming--direzione-brand)  
12. [Mappa pagine + funzionalità](#12-mappa-pagine--funzionalità)  
13. [Backoffice Admin](#13-backoffice-admin)  
14. [Glossario stati e concetti](#14-glossario-stati-e-concetti)

---

## 1) Visione prodotto

### 1.1 Obiettivo
**PetBnB** (nome di lavoro; vedi [Naming](#11-naming--direzione-brand)) è un marketplace dove un **Owner** (proprietario) può trovare e prenotare un **Host** che ospita l’animale a casa propria, con flussi “tipo Airbnb”:
- profili (owner, host, pet)
- disponibilità
- richiesta/prenotazione
- pagamento protetto
- chat
- recensioni

### 1.2 Multi‑pet (cani + gatti, estendibile)
La piattaforma nasce **multi‑pet**:
- oggi: **cani** e **gatti**
- domani: possibilità di aggiungere ulteriori categorie (specie “other”) senza rifare l’architettura

**Tassonomia consigliata (future‑proof):**
- `specie`: dog | cat | other
- attributi condivisi: età, peso, temperamento, routine, compatibilità, note veterinarie
- attributi specifici:
  - cane: taglia, esperienza razza, gestione “cani difficili”, abbaio
  - gatto: gestione lettiera, indoor/outdoor, compatibilità con altri gatti

### 1.3 Pilastri
L’esperienza è progettata su 3 pilastri:
1) **Fiducia**: selezione host, verifiche, recensioni, badge  
2) **Sicurezza**: protezioni/garanzie + procedure incidenti + supporto  
3) **Conversione**: richiesta/offerte (fase 2), prezzi chiari, frizione minima

---

## 2) Servizi

Per aumentare casi d’uso e frequenza (repeat), l’app supporta più servizi:
- **Boarding**: notte/i a casa dell’host  
- **Day Care**: giornata a casa dell’host  
- **House Sitting**: host a casa dell’owner  
- **Walking**: passeggiata  
- **Drop‑in visits**: visite brevi per bisogni/gioco

Vantaggi:
- più scenari (weekend, lavoro, emergenze)
- più prenotazioni mensili (non solo vacanze)

---

## 3) Matching

### 3.1 Modalità A: Browse (Airbnb classica)
L’owner cerca host disponibili:
- location + date + servizio + specie
- filtri avanzati
- scheda host + recensioni
- contatto e prenotazione

### 3.2 Modalità B: Compare Quotes / Job listing (fase 2)
Modalità “richiesta → offerte”, utile per urgenze e conversione:
1) Owner crea una richiesta breve (date, pet, preferenze)
2) la piattaforma notifica host compatibili
3) gli host inviano **offerte**
4) owner confronta, propone **meet & greet**, poi prenota

Vantaggi:
- riduce frizione (owner non scrive a 10 host)
- incentiva concorrenza positiva tra host (qualità/prezzo)

---

## 4) Meet & Greet

Step consigliato (quasi standard) prima del pagamento definitivo:
- Chat → proposta incontro → se match, si procede con prenotazione/pagamento

**Implementazione:**
- pulsante “**Proponi Meet & Greet**” in chat e scheda host
- modalità: in presenza / video
- checklist compatibilità (pet/host/casa/regole)
- stato: `da_fare` | `fatto` | `non_idoneo`
- “pre‑approvazione” (opzionale): host segnala che accetterebbe la prenotazione

---

## 5) Trust & Safety

### 5.1 Selezione host “stretta” (differenziante)
Obiettivo: trasmettere affidabilità anche se la piattaforma è nuova.
- verifica identità (KYC light)
- profilo dettagliato + foto casa/spazi + regole
- approvazione manuale (fase 1)
- badge: `Verificato`, `Top host`, `First Aid`

### 5.2 Protezioni / assicurazione / garanzia veterinaria (roadmap o progressivo)
Concetto chiave: **“Paghi in piattaforma = hai protezioni”**
- workflow di claim con documenti (fattura + report vet)
- regole chiare su franchigie/limiti (anche se inizialmente più basse)

### 5.3 Supporto “always‑on” (progressivo)
MVP:
- supporto “extended hours” + escalation emergenze
- linee guida emergenza in‑app (vet, pronto soccorso, contatto owner)

### 5.4 Community guidelines + flagging + enforcement
- segnalazione rapida con categorie (maltrattamento, casa non sicura, truffa, ecc.)
- detector anti “off‑platform” (telefono/email ripetuti) + warning
- penalità progressive: shadow‑ban → sospensione → ban

---

## 6) Pricing & Incentivi

### 6.1 Fee trasparente
Mostrare chiaramente cosa include la fee piattaforma:
- pagamenti protetti
- supporto
- (eventuale) protezione/assicurazione

### 6.2 Commissione host progressiva (fase 2)
Leva anti‑disintermediazione e retention:
- “più lavori in piattaforma, meno commissione paghi”
- condizioni: rating minimo, tasso risposta, cancellazioni

### 6.3 Credito prima prenotazione + referral
- credito benvenuto owner
- referral owner/host
- coupon stagionali

---

## 7) Pagamenti, escrow e payout

Principio:
- owner paga prima
- la piattaforma trattiene (escrow/hold)
- payout host dopo check‑out (finestra contestazioni)

**Funzionalità:**
- metodi pagamento (inizialmente carta)
- hold fino a check‑in o fine soggiorno (scelta di policy)
- payout host post check‑out
- gestione rimborsi e dispute (admin + flow di supporto)

---

## 8) Compliance & Tax

Roadmap “da grandi”:
- modulo “tax details” (dati fiscali)
- blocco payout se mancano dati richiesti
- log e reportistica (se necessario)

---

## 9) MVP e roadmap

### 9.1 MVP (multi‑pet, trust‑first)
- signup/login + ruoli (owner/host/entrambi)
- profili owner/host + profilo pet (cane/gatto)
- ricerca + filtri base “anti‑incidenti”
- chat + richiesta prenotazione
- meet & greet (stato “da fare/fatto”)
- prenotazione + pagamento protetto (escrow) + payout post‑soggiorno
- recensioni + rating
- supporto base + segnalazioni
- anti off‑platform (warning + enforcement)
- backoffice admin per verifica host e gestione rimborsi/incidenti

### 9.2 Fase 2
- compare quotes (richiesta → offerte)
- livelli host + commissioni progressive
- garanzia vet / assicurazione evoluta
- extended care pricing + slot orari drop‑off/pick‑up
- app mobile

---

## 10) Posizionamento

“**Il tuo pet in una casa, non in un kennel**” con:
- host selezionati e verificati
- pagamenti protetti + supporto
- aggiornamenti foto/video (routine, report)

---

## 11) Naming & direzione brand

### 11.1 Direzione “familiarità + affidabilità”
- focus su concetto **Casa > kennel**
- microcopy rassicurante: “Host verificati”, “Protezione inclusa”, “Supporto”
- badge + checklist + policy chiare

### 11.2 Proposte naming (multi‑pet e future‑proof)
**Opzione A (diretta, familiare):**
- PetBnB
- HomePet / HomePet Stay
- CasaPet

**Opzione B (brandabile, trust‑first):**
- PawHouse / PawHouse Stay
- HomePaws
- SafePaws

**Opzione C (italiano, caldo):**
- Zampe a Casa
- La Casa delle Zampe
- ZampeFelici

---

## 12) Mappa pagine + funzionalità

> Nota: struttura organizzata per aree. Ogni pagina elenca **MVP** e (se utile) **Fase 2**.

### A) Pubblico / Marketing

#### 1. Home
**Scopo:** spiegare valore e portare a ricerca o richiesta.
- CTA: “Trova un host” / “Crea una richiesta”
- selettore specie: Cane / Gatto
- value props: host verificati, pagamenti protetti, supporto
- “Come funziona” in 3 step
- recensioni/testimonianze
- link a Trust & Safety, policy, FAQ

#### 2. Come funziona
- flusso Owner e Host separati
- Meet & Greet spiegato
- “Pagamento in piattaforma = protezioni”

#### 3. Pagine Servizi (boarding/day care/…)
- descrizione + casi d’uso
- FAQ specifiche
- CTA: cerca / crea richiesta

#### 4. Trust & Safety (hub)
- verifica host (processo + badge)
- protezioni/garanzie (anche “in roadmap”)
- linee guida e segnalazioni
- emergenze: procedure e contatti

#### 5. FAQ / Help Center
- FAQ Owner/Host
- policy cancellazioni/rimborsi
- pagamenti e sicurezza

---

### B) Autenticazione & Onboarding

#### 6. Signup / Login
- email + social (opzionale)
- scelta ruolo: Owner / Host / Entrambi
- verifica email/telefono

#### 7. Onboarding Owner (wizard)
- profilo base
- creazione 1° pet (cane/gatto): foto, esigenze, routine
- preferenze: fumo, giardino, altri animali, bambini, ecc.

#### 8. Onboarding Host (wizard)
- profilo + bio
- foto casa/spazi + regole
- servizi offerti + prezzi base + disponibilità
- compatibilità (specie/taglie/puppy/senior)
- KYC light + approvazione manuale (fase 1)
- badge (Verificato/First Aid/Top Host)

---

### C) Ricerca & Matching (Owner)

#### 9. Ricerca (listing)
**MVP:**
- input: località, date, servizio, specie
- filtri “utili”:
  - one client at a time
  - giardino recintato, no fumo
  - altri animali in casa (nessuno/cani/gatti)
  - bambini in casa (fasce)
  - puppy care / senior care
  - esperienza razza (cani) / gestione lettiera (gatti)
- sort: prezzo, rating, distanza, tasso risposta
- card: prezzo, badge, rating, disponibilità

#### 10. Scheda Host (dettaglio)
- bio + esperienza + badge
- foto casa/spazi + regole
- “cosa include” (report foto/video)
- recensioni
- calendario disponibilità
- CTA: invia richiesta / proponi meet & greet / prenota

#### 11. Crea Richiesta (Compare Quotes) — Fase 2
- richiesta breve: date, pet, preferenze, budget
- invio a host compatibili
- stato: aperta / in offerte / in meet&greet / chiusa

#### 12. Offerte ricevute — Fase 2
- lista offerte: prezzo, condizioni, note, badge
- confronto 2–3 offerte
- CTA: chat / meet&greet / prenota

---

### D) Chat, Meet & Greet, Prenotazione

#### 13. Inbox / Chat
**MVP:**
- chat owner↔host
- template rapidi (routine/allergie/cibo/lettiera)
- allegati (opzionale)
- anti off‑platform: warning su email/telefono ripetuti

#### 14. Meet & Greet (scheduler leggero)
- proposta incontro (in presenza / video)
- checklist compatibilità
- stato: da fare / fatto / non idoneo
- pre‑approvazione (opzionale)

#### 15. Richiesta Prenotazione (checkout step 1)
- riepilogo: date/orari/servizio/pet
- extra: extended care (semplificato o fase 2)
- totale trasparente: prezzo host + fee piattaforma
- policy cancellazione applicata

#### 16. Pagamento (checkout step 2)
- pagamento in piattaforma
- conferma + ricevuta
- stato: in attesa conferma host / confermata

#### 17. Dettaglio Prenotazione
- timeline: richiesta → conferma → check‑in → check‑out → payout → recensione
- pulsanti: chat, supporto, modifica orari (se consentito)
- report foto/aggiornamenti (semplice)

---

### E) Recensioni & Reputazione

#### 18. Lascia recensione (owner e host)
- rating + testo
- tag strutturati: puntualità, pulizia, comunicazione, gestione pet
- moderazione base + segnalazioni

#### 19. Profilo pubblico Host (reputazione)
- badge + metriche (tasso risposta, cancellazioni)
- livelli commissione (fase 2)

---

### F) Account (Owner / Host)

#### 20. Dashboard Owner
- prenotazioni attive/passate
- profili pet
- richieste (browse/compare quotes)
- preferiti (fase 2)
- metodi pagamento / fatture

#### 21. Dashboard Host
**MVP:**
- calendario disponibilità
- richieste/prenotazioni
- prezzi per servizio
- payout e storico guadagni
- regole casa + compatibilità
- stato verifica (KYC)

#### 22. Gestione Pet (Owner)
- multi‑pet
- campi specifici cane/gatto
- documenti (vaccini, note vet, alimentazione)

---

### G) Pagamenti, Payout, Fatture

#### 23. Wallet/Transazioni (Host)
- saldo in attesa (escrow)
- payout completati
- blocco payout se dati fiscali mancanti (roadmap)

#### 24. Impostazioni fiscali (Tax details) — Roadmap
- raccolta dati fiscali
- avvisi e blocco payout se incompleti

---

### H) Supporto, Incident Flow, Enforcement

#### 25. Supporto (in‑app)
- contatta supporto (ticket)
- emergenza: contatti e procedure
- help contestuale alla prenotazione

#### 26. Segnalazione / Flag
- report con categorie
- upload prove
- tracking stato segnalazione

#### 27. Incident / Claim flow
**MVP mini:**
- apertura incidente legato a prenotazione
- checklist documenti
- stati pratica + log comunicazioni

---

## 13) Backoffice Admin

### 28. Admin Dashboard
- gestione utenti (owner/host)
- verifica host (approva/rifiuta) + checklist
- moderazione recensioni e segnalazioni
- gestione prenotazioni e rimborsi (override manuale)
- enforcement anti off‑platform
- configurazione fee/policy/livelli host (fase 2)

---

## 14) Glossario stati e concetti

### Prenotazione (Booking)
- `draft` (pre‑checkout)
- `pending_host_confirmation`
- `confirmed`
- `checked_in`
- `checked_out`
- `completed` (payout + review window chiusa)
- `cancelled` (owner/host/admin)
- `disputed` (contestazione in corso)

### Meet & Greet
- `proposed`
- `scheduled`
- `done`
- `not_suitable`

### Enforcement (account)
- `warned`
- `shadow_banned`
- `suspended`
- `banned`

---
