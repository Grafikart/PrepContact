declare namespace Cypress {

  interface Chainable<Subject = any> {

    label (text: string): Chainable

    shouldBeInvalid ()

    cleanMail ()

    resetDB (group?: string)

    expectMail (text: string)


  }

}
