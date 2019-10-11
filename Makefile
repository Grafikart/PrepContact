.PHONY: test
test:
	npx forever start ./node_modules/.bin/maildev
	php bin/console server:start
	npx cypress run --record --key 3dfc2c25-2c15-4632-8028-9b48561e08b0
	php bin/console server:stop
	npx forever stopall
