<template>
  <div class="input-group search-field">
    <input id="example-search-input" class="form-control bg-secondary border rounded px-3" type="text" :placeholder="this.$t('web.home.navbar.search.placeholder')" />
    <span class="input-group-ppend position-absolute top-50 end-0 translate-middle-y me-3">
      <fa :icon="['fas', 'search']" class="text-primary" />
    </span>
  </div>
</template>

<script>
import { mapGetters,mapActions } from "vuex";
export default {
}
</script>

<style>

</style>
