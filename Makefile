.PHONY: help build up down restart shell sf cc logs db

# Couleurs
GREEN  := \033[0;32m
YELLOW := \033[0;33m
RESET  := \033[0m

help: ## Affiche cette aide
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "$(GREEN)%-15s$(RESET) %s\n", $$1, $$2}'

build: ## Build les images Docker
	docker compose build --no-cache

up: ## Démarre les conteneurs
	docker compose up -d

down: ## Arrête les conteneurs
	docker compose down

restart: ## Redémarre les conteneurs
	docker compose restart

shell: ## Ouvre un shell dans le conteneur PHP
	docker compose exec php bash

sf: ## Exécute une commande Symfony  → make sf c="cache:clear"
	docker compose exec php php bin/console $(c)

cc: ## Vide le cache Symfony
	docker compose exec php php bin/console cache:clear

migrate: ## Lance les migrations Doctrine
	docker compose exec php php bin/console doctrine:migrations:migrate --no-interaction

migration: ## Génère une migration Doctrine
	docker compose exec php php bin/console make:migration

fixtures: ## Charge les fixtures
	docker compose exec php php bin/console doctrine:fixtures:load --no-interaction

logs: ## Affiche les logs en temps réel
	docker compose logs -f

db: ## Ouvre un shell MariaDB
	docker compose exec db mariadb -u benevoles -pbenevoles benevoles

composer: ## Exécute composer → make composer c="require vendor/package"
	docker compose exec php composer $(c)

cs-check: ## Vérifie le style de code (sans modifier)
	docker compose exec php tools/php-cs-fixer/vendor/bin/php-cs-fixer check --diff --no-interaction

cs-fix: ## Corrige automatiquement le style de code
	docker compose exec php tools/php-cs-fixer/vendor/bin/php-cs-fixer fix --no-interaction

phpstan: ## Lance l'analyse statique PHPStan
	docker compose exec php vendor/bin/phpstan analyse --no-progress

test: ## Lance les tests PHPUnit
	docker compose exec php php bin/phpunit
