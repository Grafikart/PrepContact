.PHONY: test
test:
	forever start ./node_modules/.bin/maildev
	php bin/console server:start
	npx cypress run
	php bin/console server:stop
	forever stop ./node_modules/.bin/maildev
