.ONESHELL:
SHELL := /bin/bash

include $(ENV_FILE)
export

docker_compose_run := docker exec -it ${COMPOSE_PROJECT_NAME}_php-fpm_1

help:
	@echo 'Usage: make [target] ...'
	@echo
	@echo 'targets:'
	@echo -e "$$(grep -hE '^\S+:.*##' $(MAKEFILE_LIST) | sed -e 's/:.*##\s*/:/' -e 's/^\(.\+\):\(.*\)/\\x1b[36m\1\\x1b[m:\2/' | column -c2 -t -s :)"

up: ## Starts the application containers
	@docker-compose up

down: ## Destroys the application containers by stopping and removing them
	@docker-compose down

restart: down up ## Performs a down and up

terminal-php-fpm: ## Opens an interactive terminal into the FPM Docker container
	@$(docker_compose_run) sh

terminal-db: ## Opens an interactive terminal into the FPM Docker container
	@docker exec -it ${COMPOSE_PROJECT_NAME}_db_1 sh

dependencies: ## Installs application dependencies
	@$(docker_compose_run) sh -c "composer install"

create-database: ## Creates an empty database
	@$(docker_compose_run) sh -c "bin/doctrine orm:schema-tool:drop --force"
	@$(docker_compose_run) sh -c "bin/doctrine orm:schema-tool:create"

update-database: ## Prints DDL statements to be executed to the screen
	@$(docker_compose_run) sh -c "bin/doctrine orm:schema-tool:update --force --dump-sql"

update-database-apply: ## Updates project database schema
	@$(docker_compose_run) sh -c "bin/doctrine orm:schema-tool:update --force"

unit-test: ## Runs unit tests
	@$(docker_compose_run) sh -c "vendor/bin/phpunit --testsuite unit"

integration-test: ## Runs e2e tests
	docker-compose up --detach
	docker exec -it ${COMPOSE_PROJECT_NAME}_php-fpm_1 sh -c "\
		bin/doctrine orm:schema-tool:drop --force; \
		bin/doctrine orm:schema-tool:create; \
		vendor/bin/phpunit --testsuite integration";
	status=$$?
#	docker-compose down
#	docker volume rm ${COMPOSE_PROJECT_NAME}_db-volume
	exit $${status}

static-analysis: ## Checks static code analysis rules
	@$(docker_compose_run) sh -c "vendor/bin/phpstan analyse -l 8 src tests"

coding-standards: ## Checks coding standards rules
	@$(docker_compose_run) sh -c "vendor/bin/php-cs-fixer fix --dry-run --diff -vvv"

coding-standards-apply: ## Applies coding standards rules fixes
	@$(docker_compose_run) sh -c "vendor/bin/php-cs-fixer fix --diff -vvv"

code-quality: coding-standards static-analysis

security-check: ## Checks security vulnerabilities on the dependencies
	@$(docker_compose_run) sh -c "bin/security-checker"

.DEFAULT_GOAL := help
