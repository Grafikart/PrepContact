<script>
  export let label
  export let name
  export let value
  export let type = 'text'
  export let error = null
  export let required = false
</script>

<div class="form-group">
  <label for={name}>{label}</label>
  {#if type === "textarea"}
    <textarea required={required} class:is-invalid={error} id={name} name={name} class="form-control"
              bind:value={value}></textarea>
  {:else if type === "email"}
    <input required={required} class:is-invalid={error} type="email" id={name} name={name} class="form-control"
           bind:value={value}/>
  {:else}
    <input required={required} class:is-invalid={error} type="text" id={name} name={name} class="form-control"
           bind:value={value}/>
  {/if}
  {#if error}
    <div class="invalid-feedback">
      {error}
    </div>
  {/if}
</div>
