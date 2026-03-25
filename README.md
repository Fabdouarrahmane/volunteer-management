# 🤝 Plateforme de gestion des bénévoles

Projet M1 - ENSITECH 2025-2026

## Stack technique

| Service | Technologie |
|---------|-------------|
| Backend | Symfony 7 + PHP 8.3 |
| Frontend | Twig + Asset Mapper |
| Serveur web | Caddy 2 |
| Base de données | MariaDB 11 |
| Mails (dev) | Mailpit |

## Prérequis

- Docker + Docker Compose v2
- Make
- WSL2 Ubuntu (ou Linux)

## Installation

```bash
# 1. Cloner le dépôt
git clone <repo-url>
cd benevoles

# 2. Créer le projet Symfony
make build
make up
docker compose exec php composer create-project symfony/skeleton app
docker compose exec php composer require webapp --working-dir=app

# 3. Configurer l'environnement
cp app/.env app/.env.local
# Éditer app/.env.local avec les valeurs ci-dessous

# 4. Créer la base de données et lancer les migrations
make sf c="doctrine:database:create"
make migrate
```

## Variables d'environnement (.env.local)

```dotenv
DATABASE_URL="mysql://benevoles:benevoles@db:3306/benevoles?serverVersion=mariadb-11.0.0&charset=utf8mb4"
MAILER_DSN=smtp://mailpit:1025
APP_SECRET=change_me_please
```

## Commandes utiles

```bash
make up          # Démarrer
make down        # Arrêter
make shell       # Shell PHP
make sf c="..."  # Commande Symfony
make cc          # Vider le cache
make logs        # Voir les logs
make db          # Shell MariaDB
```

## URLs

| Service | URL |
|---------|-----|
| Application | http://localhost |
| Mailpit (mails) | http://localhost:8025 |
| MariaDB | localhost:3306 |