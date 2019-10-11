.PHONY: test
test:
	npx maildev
	npx cypress run
