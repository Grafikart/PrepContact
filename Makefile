.PHONY: test
test:
	npx forever start ./node_modules/.bin/maildev
	php bin/console server:start
	npx cypress run
	php bin/console server:stop
	npx forever stopall
