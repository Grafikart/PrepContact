// ***********************************************
// This example commands.js shows you how to
// create various custom commands and overwrite
// existing commands.
//
// For more comprehensive examples of custom
// commands please read more here:
// https://on.cypress.io/custom-commands
// ***********************************************
//
//
// -- This is a parent command --
// Cypress.Commands.add("login", (email, password) => { ... })
//
//
// -- This is a child command --
// Cypress.Commands.add("drag", { prevSubject: 'element'}, (subject, options) => { ... })
//
//
// -- This is a dual command --
// Cypress.Commands.add("dismiss", { prevSubject: 'optional'}, (subject, options) => { ... })
//
//
// -- This is will overwrite an existing command --
// Cypress.Commands.overwrite("visit", (originalFn, url, options) => { ... })

Cypress.Commands.add('label', (text) => {
  return cy.contains('label', text).click().focused({log: false})
})

Cypress.Commands.add('shouldBeInvalid', {prevSubject: 'element'}, (subject, options) => {
  const input = subject[0]
  const message = 'Le champs #' + input.getAttribute('id') + ' doit être invalide'
  return expect(input.validity.valid === false || input.classList.contains('is-invalid'), message).to.be.true
})

Cypress.Commands.add('cleanMail', () => {
  cy.request('DELETE', 'http://localhost:1080/email/all').should((response) => {
    expect(response.status).to.eq(200)
  })
})

Cypress.Commands.add('resetDB', (group) => {
  let cmd = 'php bin/console doctrine:fixtures:load --no-interaction --env=ui'
  if (group) {
    cmd += ' --group=' + group
  }
  cy.exec(cmd)
})

Cypress.Commands.add('expectMail', (text) => {
  cy.request('http://localhost:1080/email').should((response) => {
    expect(response.body).to.length(1)
    const mail = response.body[response.body.length - 1]
    expect(mail.text || mail.html).to.contains(text)
  })
})
