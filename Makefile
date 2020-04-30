COMPOSER ?= composer
PHPUNIT_OPTS =
SYMFONY = symfony


help: Makefile
	@echo
	@echo " Choose a command run in Turtle:"
	@echo
	@sed -n 's/^##//p' $< | column -t -s ':' |  sed -e 's/^/ /'
	@echo


config:
	cp .env.dist .env


composer: config
	$(COMPOSER) install


cc:
	rm -rf var/cache/*


clear: cc
	rm -rf var/logs/*


fix-diff:
	./vendor/bin/php-cs-fixer fix --diff --dry-run -v


test: cc composer
	bin/phpunit -c . $(PHPUNIT_OPTS) --log-junit build/phpunit.xml


lint: cc lint-yaml lint-twig lint-php phpcs php-cs lint-composer lint-eol
	@echo All good.


lint-eol:
	@echo "\n==> Validating unix style line endings of files:files"
	@! grep -lIUr --color '^M' config/ public/ src/ composer.json composer.lock || ( echo '[ERROR] Above files have CRLF line endings' && exit 1 )
	@echo All files have valid line endings


lint-composer:
	@echo "\n==> Validating composer.json and composer.lock:"
	$(COMPOSER) validate --strict


lint-yaml:
	@echo "\n==> Validating all yaml files:"
	./bin/console lint:yaml config
	@find config -type f -name \*.yaml | while read file; do echo -n "$$file"; php bin/console --no-debug --no-interaction --env=test lint:yaml "$$file" || exit 1; done


lint-twig:
	@echo "\n==> Validating all twig files:"
	@find templates -type f -name \*.twig | while read file; do echo -n "$$file"; php bin/console --no-debug --no-interaction --env=test lint:twig "$$file" || exit 1; done


lint-php:
	@echo "\n==> Validating all php files:"
	@find src tests -type f -name \*.php | while read file; do php -l "$$file" || exit 1; done


phpcs:
	./vendor/bin/phpcs


php-cs:
	./vendor/bin/php-cs-fixer fix --diff --dry-run -v


## coverage: Get Coverage Report
coverage: cc composer
	@echo "\n==> Get Coverage Report:"
	mkdir -p build/coverage
	bin/phpunit  --log-junit build/phpunit.xml


## fix: Fix Style Issues
fix:
	@echo "\n==> Fix Style Issues:"
	./vendor/bin/php-cs-fixer fix


## ci: Run CI Checks
ci: clear composer lint test
	@echo "All quality checks passed"


## run: Run Turtle
run:
	@echo "\n==> Run Turtle:"
	$(SYMFONY) serve


.PHONY: help
