const data = {
  name: 'John Doe',
  email: 'john@doe.fr',
  phone: '0600000000',
  message: 'Salut les gens comment ça vva ?',
  rgpd: true
}

context('Actions', () => {

  function fillForm (data) {
    cy.label('Votre nom').type(data.name)
    cy.label('Votre email').type(data.email)
    cy.label('Votre téléphone').type(data.phone)
    cy.label('Votre message').type(data.message)
    if (data.rgpd) {
      cy.label('protection des données')
    }
    cy.contains('button', 'Envoyer').click()
  }

  beforeEach(() => {
    cy.visit('/contact')
  })

  it('should validate phone', function () {
    fillForm({...data, phone: '00'})
    cy.label('Votre téléphone').shouldBeInvalid()
  })

  it('should force RGPD phone', function () {
    fillForm({...data, rgpd: false})
    cy.get('input[type="checkbox"][name*="rgpd"]').shouldBeInvalid()
  })

  it.only('should send and email', function () {
    fillForm(data)
    cy.contains('Votre email a bien été envoyé')
    cy.expectMail('Nom: John Doe')
  })

})
