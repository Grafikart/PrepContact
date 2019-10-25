<script>
  export let name
  export let value
  export let error
</script>

<div class="form-group is-invalid">
  <div class="form-check">
    <input type="checkbox" id={name} name={name} class="form-check-input" bind:checked={value} class:is-invalid={error}
           on:change>
    <label class="form-check-label" for={name}>
      <slot/>
    </label>
    {#if error}
      <div class="invalid-feedback">{error}</div>
    {/if}
  </div>
</div>
