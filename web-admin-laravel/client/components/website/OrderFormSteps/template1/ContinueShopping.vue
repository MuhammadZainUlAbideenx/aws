<template>
 <section class="m-0">
   <WebsiteGlobalComponentsBreadCrumb :page="`cart`"/>
   <div class="card_empty thanks-you-form rounded bg-white-secondary-light text-center">
    <div class="empty_icon"><fa :icon="['fas', 'cart-arrow-down']" /></div>
    <h2 class="text-uppercase fw-bold my-2"> {{ $t("cart_empty") }} </h2>
    <p class="fs-6">{{ $t("cart_is_empty_message") }}</p>
    <nuxt-link to="/shop" class="btn bg-warning rounded py-2 lh-sm fw-bold text-uppercase">{{$t('web.customer.compare.continue_shopping')}}</nuxt-link>
  </div>
 </section>
</template>

<script>
export default {};
</script>

<style>
</style>
