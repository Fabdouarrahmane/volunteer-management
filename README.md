# 🤝 Plateforme de gestion des bénévoles

Projet de fin d'études **Master 2** — ENSITECH 2025-2026

Application web de gestion des bénévoles pour une association locale, permettant de coordonner les événements, les disponibilités, les affectations et la communication interne.

---

## Stack technique

| Couche | Technologie |
|---|---|
| Backend | Symfony 7 + PHP 8.3 |
| Frontend | Twig + Bootstrap 5 + Asset Mapper |
| Serveur web | Caddy 2 |
| Base de données | MariaDB 11 |
| Async / Notifications | Symfony Messenger (transport Doctrine) |
| Mails (dev) | Mailpit |
| Conteneurisation | Docker Compose + WSL2 Ubuntu |

## CI/CD

Pipeline GitHub Actions avec trois jobs sur chaque PR et push sur `main` :

- **PHP CS Fixer** — vérification du style de code (standard Symfony)
- **PHPStan** — analyse statique niveau 6
- **PHPUnit** — tests unitaires, fonctionnels et d'intégration (avec MariaDB)

---

## Prérequis

- Docker + Docker Compose v2
- Make
- WSL2 Ubuntu (ou Linux natif)

---

## Installation

```bash
# 1. Cloner le dépôt
git clone <repo-url>
cd volunteer-management

# 2. Builder et démarrer les conteneurs
make build
make up

# 3. Installer les dépendances PHP
docker compose exec php composer install

# 4. Configurer l'environnement local
cp .env .env.local
# Éditer .env.local si besoin (les valeurs par défaut fonctionnent avec Docker)

# 5. Créer la base de données et lancer les migrations
docker compose exec php php bin/console doctrine:database:create
make migrate

# 6. Créer un compte administrateur
docker compose exec php php bin/console security:hash-password
# → choisir App\Entity\Administrateur, copier le hash généré
make db
# Puis dans le shell MariaDB :
# INSERT INTO administrateur (nom, prenom, email, mot_de_passe)
# VALUES ('Nom', 'Prénom', 'admin@example.com', 'HASH_ICI');
```

---

## Variables d'environnement

Les valeurs par défaut dans `.env` fonctionnent directement avec Docker. Pour surcharger, créez un `.env.local` :

```dotenv
DATABASE_URL="mysql://benevoles:benevoles@db:3306/benevoles?serverVersion=mariadb-11.0.0&charset=utf8mb4"
MAILER_DSN=smtp://mailpit:1025
APP_SECRET=change_me_in_production
```

---

## Commandes Make

```bash
make up          # Démarrer les conteneurs
make down        # Arrêter les conteneurs
make restart     # Redémarrer les conteneurs
make build       # Builder les images Docker (--no-cache)

make php         # Ouvrir un shell dans le conteneur PHP
make sf c="..."  # Exécuter une commande Symfony  ex: make sf c="cache:clear"
make cc          # Vider le cache Symfony
make db          # Ouvrir un shell MariaDB

make migrate     # Lancer les migrations Doctrine
make migration   # Générer une nouvelle migration
make fixtures    # Charger les fixtures

make composer c="..."  # Exécuter Composer  ex: make composer c="require vendor/pkg"

make cs-check    # Vérifier le style de code (lecture seule)
make cs-fix      # Corriger automatiquement le style de code
make phpstan     # Lancer l'analyse statique PHPStan
make test        # Lancer les tests PHPUnit
```

---

## URLs

| Service | URL |
|---|---|
| Application | http://localhost |
| Mailpit (visualisation emails) | http://localhost:8025 |
| MariaDB (client externe) | localhost:**3307** |

> **Note :** MariaDB est exposé sur le port **3307** (et non 3306) pour éviter les conflits avec une installation locale éventuelle.

---

## Fonctionnalités

### Administrateur
- Tableau de bord avec indicateurs (bénévoles, événements à venir, affectations, messages)
- Gestion complète des événements (CRUD)
- Gestion des comptes bénévoles (CRUD)
- Gestion des affectations avec envoi automatique d'email de notification
- Consultation de la messagerie interne
- Modification de son profil

### Bénévole
- Consultation des événements à venir
- Saisie et gestion de ses disponibilités
- Consultation de ses affectations
- Messagerie interne (envoi et réception)
- Modification de son profil

---

## Structure du projet

```
volunteer-management/
├── .github/workflows/   # Pipeline CI GitHub Actions
├── config/              # Configuration Symfony (security, messenger, mailer…)
├── docker/              # Dockerfile PHP + Caddyfile
├── migrations/          # Migrations Doctrine
├── src/
│   ├── Controller/      # Controllers Symfony
│   ├── Entity/          # Entités Doctrine
│   ├── Form/            # Types de formulaires
│   ├── Repository/      # Repositories Doctrine
│   └── Service/         # Services (NotificationService…)
├── templates/           # Templates Twig
│   ├── admin/           # Vues espace admin
│   ├── benevole/        # Vues espace bénévole
│   ├── legal/           # Mentions légales, politique de confidentialité
│   ├── profil/          # Page profil (commun)
│   └── security/        # Login
├── tests/
│   ├── Unit/            # Tests unitaires
│   ├── Functional/      # Tests fonctionnels
│   ├── Integration/     # Tests d'intégration
│   └── EndToEnd/        # Tests E2E (exclus CI, nécessitent un navigateur)
├── tools/php-cs-fixer/  # PHP CS Fixer isolé (évite les conflits de dépendances)
├── docker-compose.yml
├── Makefile
└── .env
```

---

## Tests

```bash
# Lancer tous les tests (hors E2E)
make test

# Ou directement
docker compose exec php php bin/phpunit --testsuite Unit,Integration,Functional
```

Les tests EndToEnd sont exclus de la CI car ils nécessitent un navigateur. Ils peuvent être lancés localement :

```bash
docker compose exec php php bin/phpunit --testsuite EndToEnd
```

---

## Qualité de code

```bash
# Vérifier + corriger le style
make cs-fix

# Analyse statique (niveau 6)
make phpstan
```
