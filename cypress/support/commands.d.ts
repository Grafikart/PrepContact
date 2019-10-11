declare namespace Cypress {

  interface Chainable<Subject = any> {

    label (text: string): Chainable

    shouldBeInvalid ()

    cleanMail ()

    resetDB ()

    expectMail (text: string)


  }

}
