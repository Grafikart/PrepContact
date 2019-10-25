<script>
  export let disabled = false
</script>

<div class="form-group">
  <button class="btn btn-primary" type="submit" disabled={disabled}>
    <slot/>
  </button>
</div>
