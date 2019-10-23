.PHONY: help
help: ## Affiche cette aide
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

.PHONY: install
install: node_modules vendor

.PHONY: test
test: node_modules vendor prepare ## Lance les tests pour l'intégration continue
	php bin/console doctrine:database:create --env=test --if-not-exists
	./bin/phpunit
	npx cypress run --record --key 3dfc2c25-2c15-4632-8028-9b48561e08b0
	make clean

.PHONY: tt
tt: node_modules vendor prepare ## Lance les tests individuellement
	npx cypress open
	make clean

.PHONY: prepare
prepare:
	npx forever start ./node_modules/.bin/maildev
	php bin/console doctrine:database:create  --env=ui --if-not-exists
	php bin/console doctrine:schema:create --env=ui
	php bin/console server:start 127.0.0.1:8888 --env=ui

.PHONY: clean
clean:
	php bin/console server:stop --env=ui
	npx forever stopall
	php bin/console doctrine:database:drop --env=ui --force

node_modules: package.json
	yarn

vendor: composer.json
	composer install -o
