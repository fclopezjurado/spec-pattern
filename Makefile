.ONESHELL:
SHELL := /bin/bash
compose_project_name := e2e-test-$(shell openssl rand -base64 6)
docker_compose_run := docker exec -it spec-pattern_php-fpm_1

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

terminal: ## Opens an interactive terminal into the FPM Docker container
	@$(docker_compose_run) sh

dependencies: ## Installs application dependencies
	@$(docker_compose_run) sh -c "composer install"

create-database: ## Creates an empty database
	@$(docker_compose_run) sh -c "vendor/bin/doctrine orm:schema-tool:drop --force"
	@$(docker_compose_run) sh -c "vendor/bin/doctrine orm:schema-tool:create"

update-database: ## Prints DDL statements to be executed to the screen
	@$(docker_compose_run) sh -c "vendor/bin/doctrine orm:schema-tool:update --force --dump-sql"

update-database-apply: ## Updates project database schema
	@$(docker_compose_run) sh -c "vendor/bin/doctrine orm:schema-tool:update --force"

unit-test: ## Runs unit tests
	@$(docker_compose_run) sh -c "vendor/bin/phpunit --testsuite unit"

e2e-test: ## Runs e2e tests
	@export COMPOSE_PROJECT_NAME=$(compose_project_name) DB_EXPOSED_PORT=3366
	docker-compose up --detach
	$(SHELL) -c 'docker/mysql/health-check.sh; if [[ "$$?" -eq 1 ]]; then echo "Was not possible to establish connection with MySQL"; docker-compose down; exit 1; fi'
	docker-compose exec spec-pattern-fpm sh -c "vendor/bin/phpunit --testsuite e2e";
	status=$$?
	docker-compose down
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
