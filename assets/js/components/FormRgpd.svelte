<script>
  import FormCheckbox from './FormCheckbox.svelte'

  export let name

  let checked = false
  let changed = false

  $:error = changed === true && checked === false ? 'Vous devez accepter les conditions d\'utilisation' : false

  function onChange () {
    if (changed === false) {
      changed = true
    }
  }

</script>

<div class="form-group is-invalid">
  <FormCheckbox name={name} error={error} bind:value={checked} on:change={onChange}>
    <slot/>
  </FormCheckbox>
</div>
