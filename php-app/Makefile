# Docker
DOCKER_COMPOSE = docker compose
DOCKER_RUN = docker run -it --rm --init -v "$(PWD)/app:/app" -w /app

# Containers
DOCK_PHP = $(DOCKER_COMPOSE) exec php

# Executables (Docker)
COMPOSER = $(DOCK_PHP) composer
SYMFONY  = $(DOCK_PHP) php bin/console

# Variables
UID = $(shell id -u)
GID = $(shell id -g)

# Config
.DEFAULT_GOAL = help
.PHONY        =

## —— Help 💡 ———————————————————————————————————————————————————————————————————
help: ## Outputs this help screen
	@grep -E '(^[a-zA-Z0-9_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}{printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'

## —— Docker 🐳 ————————————————————————————————————————————————————————————————
docker-build: ## Pull and build images
	@$(DOCKER_COMPOSE) build --pull

docker-up: ## Start docker in detached mode (no logs)
	@$(DOCKER_COMPOSE) up --detach

docker-start: docker-build docker-up ## Build and start the containers

docker-stop: ## Stop docker containers
	@$(DOCKER_COMPOSE) stop

docker-down: ## Remove docker containers
	@$(DOCKER_COMPOSE) down --remove-orphans

docker-logs: ## Show live logs
	@$(DOCKER_COMPOSE) logs --tail=0 --follow

## —— Development 🧙 ———————————————————————————————————————————————————————————
build: vendor migration routing asset ## Build application: vendor, migration, routing and asset

vendor: ## Install dependencies with composer (no options)
	@$(COMPOSER) install

database: ## Create a new database
	@$(SYMFONY) doctrine:database:drop --if-exists --force
	@$(SYMFONY) doctrine:database:create

migration: ## Run database migrations
	@$(SYMFONY) doctrine:migrations:migrate --allow-no-migration --no-interaction

fixtures: ## Load database fixtures
	@$(SYMFONY) doctrine:fixtures:load --no-interaction --append

routing: ## Dump routes for frontend
#	@$(SYMFONY) fos:js-routing:dump --format=json --target=public/js/fos_js_routes.json

asset: ## Build assets (css, js, fonts, images)
	@$(DOCKER_RUN) node:16-alpine /bin/sh -c "yarn install && yarn dev && chown -R $(UID):$(GID) public/build"

bash: ## Launch bash in PHP container
	@$(DOCK_PHP) bash

composer: ## Run composer, pass the parameter "c=" to run a given command, example: make composer c='req symfony/orm-pack'
	@$(eval c ?=)
	@$(COMPOSER) $(c)

symfony: ## List all Symfony commands or pass the parameter "c=" to run a given command, example: make symfony c='about'
	@$(eval c ?=)
	@$(SYMFONY) $(c)

## —— QA & Tests ✅ ———————————————————————————————————————————————————————————
PHPQA = $(DOCKER_RUN) jakzal/phpqa:php8.1

phpcs: ## Run PHP Code Sniffer (config in phpcs.xml)
	@$(PHPQA) phpcs src/

phpcbf: ## Run PHP Code Beautifier and Fixer (config in phpcs.xml)
	@$(PHPQA) phpcbf src/

php-cs-fixer: ## Run php-cs-fixer (config in .php-cs-fixer.dist.php), pass parameter "o=" to add options, ex: make php-cs-fixer o=--dry-run
	@$(eval o ?=)
	@$(PHPQA) php-cs-fixer fix --allow-risky=yes --diff $(o)

phpstan: ## Run phpstan (config in phpstan.neon.dist), you can pass the parameter "level=" (default 3)
	@$(eval level ?= 3)
	@$(PHPQA) phpstan analyse --level $(level) src/

phpmetrics: ## Run phpmetrics and report in var/phpmetrics/
	@$(PHPQA) phpmetrics --report-html=var/phpmetrics/ src/

lint-container: ## Ensure that arguments injected into services match type declarations
	@$(SYMFONY) lint:container

lint-yaml: ## Lint YAML files (config and translations)
	@$(SYMFONY) lint:yaml config translations

lint-twig: ## Lint Twig templates
	@$(SYMFONY) lint:twig templates

lint-xliff: ## Lint Xliff files (translations)
	@$(SYMFONY) lint:xliff translations

## —— Application 🚀 ———————————————————————————————————————————————————————————
commands: ## Display all commands in the application namespace
	@$(SYMFONY) list app

app-sync: ## Synchronize data with API
	@$(SYMFONY) app:sync

#domain-command: ## Description de la commande
#	@$(SYMFONY) app:domain:command
