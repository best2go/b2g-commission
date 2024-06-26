$(DEBUG).SILENT: ;       # no need for @, DEBUG=yes make ... disable silence
.EXPORT_ALL_VARIABLES: ; # send all vars to shell
.NOTPARALLEL: ;          # wait for target to finish
.ONESHELL: ;             # when a target is built all lines of the recipe will be given to a single invocation
.SUFFIXES: ;             # skip suffix discovery
.DEFAULT_GOAL = all      # Run make "all" by default

PHP_MATRIX := 7.4 8.1 8.2 8.3
DOCKER := docker
COMPOSER_HOME := $(HOME)/.composer
DOCKER_RUN := $(DOCKER) run \
	--interactive --tty --rm \
	--user 1000:1000 \
	--env COMPOSER_HOME=/tmp \
	--volume $(COMPOSER_HOME):/tmp \
	--volume $(PWD):/app \
	--workdir /app

.PHONY: all
all: $(addprefix phpunit-,$(PHP_MATRIX))

.PHONY: 7.4 8.1 8.2 8.3
7.4: phpunit-7.4
8.1: phpunit-8.1
8.2: phpunit-8.2
8.3: phpunit-8.3

.PHONY: phpunit-%
phpunit-%: info-% update-%
	$(DOCKER_RUN) php:$*-cli-alpine vendor/bin/phpunit --colors=never --no-interaction $(CMD_ARGS)
	$(DOCKER_RUN) composer config --unset platform

.PHONY: info-%
info-%:
	echo "---------------------------\r\nPHP-$*\r\n"

.PHONY: update-%
update-%: platform-%
	$(DOCKER_RUN) composer update --no-ansi --no-interaction

.PHONY: platform-%
platform-%:
	$(DOCKER_RUN) composer config platform.php $*
