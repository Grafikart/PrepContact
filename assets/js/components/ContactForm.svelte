<script>
  import FormInput from './FormInput.svelte'
  import FormButton from './FormButton.svelte'
  import FormCheckbox from './FormCheckbox.svelte'
  import {omit} from 'lodash-es'
  import {post} from '../utils/api'

  export let url
  export let errors = {}

  let rgpd = false
  let success = false
  let error = {}
  let loading = false
  let data = {
    name: '',
    email: '',
    phone: '',
    message: ''
  }

  async function onSubmit (e) {
    e.preventDefault()
    errors = {}
    if (rgpd === false) {
      errors.rgpd = 'Vous devez accepter les conditions d\'utilisation'
      return
    }
    loading = true
    try {
      await post(url, data)
      success = true
      data = {}
    } catch (e) {
      if (e.errors) {
        errors = e.errors
      } else {
        alert(e.message)
        console.error(e)
      }
    }
    loading = false
  }

  function clearError (name) {
    return function () {
      errors = omit(errors, name)
    }
  }
</script>

{#if success}
  <div class="alert alert-success">Votre email a bien été envoyé</div>
{/if}

<form method="post" on:submit={onSubmit}>
  <div class="row">
    <div class="col-md-6">
      <FormInput required error={errors.name} name="name" label="Votre nom" bind:value={data.name}/>
    </div>
    <div class="col-md-6">
      <FormInput required error={errors.email} name="email" label="Votre email" type="text" bind:value={data.email}/>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6">
      <FormInput required error={errors.phone} name="phone" label="Votre téléphone" type="phone"
                 bind:value={data.phone}/>
    </div>
  </div>
  <FormInput required error={errors.message} name="message" label="Votre message" type="textarea"
             bind:value={data.message}/>
  <FormCheckbox name="rgpd" bind:value={rgpd} error={errors.rgpd} on:change={clearError('rgpd')}>
    Dans le cadre de la réglementation sur la protection des données, j'accepte d'être contacté(e) par email et
    téléphone.
  </FormCheckbox>
  <FormButton disabled={loading}>Envoyer</FormButton>
</form>
