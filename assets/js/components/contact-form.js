import ContactForm from './ContactForm.svelte'

export default class ContactFormElement extends HTMLElement {

  constructor () {
    super()
    const url = this.getAttribute('url')
    new ContactForm({
      target: this,
      props: {
        url
      }
    })
  }

}
