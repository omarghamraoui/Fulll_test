include ../.env
export $(shell sed 's/=.*//' ../.env)

USER_ID:=$(shell id -u)
GROUP_ID:=$(shell id -g)
export UID = $(USER_ID)
export GID = $(GROUP_ID)
DOCKER_COMPOSE = cd .. && docker-compose
DOCKER = cd .. && docker
USER_DOCKER = $(USER_ID):$(GROUP_ID)
DOCKER_PHP = $(DOCKER) exec -u $(USER_DOCKER) -it $(CONTAINER_NAME)_php-fpm sh -c


start: ## Start environnement docker.
start: ../docker-compose.yml
	UID=$(USER_ID) GID=$(GROUP_ID) $(DOCKER_COMPOSE) up -d --build

stop: ## Stop all containers
stop:
	$(DOCKER_COMPOSE) stop

behat: ## Run behat
behat:
	$(DOCKER_PHP) "vendor/bin/behat"

phpstan: ## Run phpstan
phpstan:
	$(DOCKER_PHP) "vendor/bin/phpstan analyse src"

phpcs: ## Run phpcs
phpcs:
	$(DOCKER_PHP) "vendor/bin/phpcs"


connect-php: ## Connect sh to container php
connect-php:
	$(DOCKER) exec -u $(USER_DOCKER) -it $(CONTAINER_NAME)_php-fpm sh