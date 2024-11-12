PHPCS = ./vendor/bin/phpcs
PHPCBF = ./vendor/bin/phpcbf
PHPCS_FILES = app/ tests/

cs-check:
	$(PHPCS) $(PHPCS_FILES)

cs-fix:
	$(PHPCBF) $(PHPCS_FILES)

cs-all: cs-check cs-fix


phpunit:
	phpunit

pre-push: cs-fix phpunit

pp: pre-push

help:
	@echo "Makefile commands:"
	@echo "  cs-check  - Run PHP CodeSniffer to check code standards without fixing"
	@echo "  cs-fix    - Run PHP CodeSniffer to fix code standards automatically"
	@echo "  cs-all    - Run both check and fix in sequence"
	@echo "  pp        - Run pre-push checks: codestile + tests"

