<template>
<section>
  <div class="container">
<div class="row mt-5">
  <div class="col-12">
    <div class="card bg-white p-5">
<div class="text-center">
    <fa :icon="['fas', 'ban']" class="fs-5 me-2 mb-4 text-danger" />
  <h2>{{$t('your_store_currently_is_in_active_or_under_review')}}</h2>
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
