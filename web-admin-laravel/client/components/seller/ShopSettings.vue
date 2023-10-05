<template>
<section>
  <div class="container">
<div class="row mt-5">
  <div class="col-12">
    <div class="card bg-white p-5">
<div class="text-center">
    <fa :icon="['fas', 'cog']" class="fs-5 me-2 mb-4" />
  <h2>{{$t('You_have_not_set_your_store_yet')}}</h2>
    <nuxt-link to="/seller/store_settings" type="button" class="btn btn-primary" name="button">{{$t('form.store_settings.store_settings')}}</nuxt-link>
  </div>
</div>
  </div>
</div>
  </div>

</section>



</template>
<script>
  export default {

  }
</script>
<style lang="scss" scoped>
.svg-inline--fa.fa-w-16{
  font-size: 4rem !important;
}
</style>
