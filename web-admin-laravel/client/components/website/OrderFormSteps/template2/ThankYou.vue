<template>
  <div class="thanks-you-form bg-white-secondary-light text-center">
    <div class="thank-icon"><fa :icon="['fas', 'check-circle']" /></div>
    <h2 class="text-uppercase fw-bold my-3">{{$t('web.customer.thankyou.label')}}</h2>
    <p class="fs-6">{{$t('web.customer.thankyou.description')}}<b v-if="customer_credentials && customer_credentials.email && customer_credentials.password">
        {{ order_num }}
        </b>
        <b v-else>
        <nuxt-link :to="'/customer/orders/'+ordered_id" >
        {{ order_num }}
        </nuxt-link>
        </b>
        .</p>
          <div class="fw-bold" v-if="customer_credentials && customer_credentials.email && customer_credentials.password">{{$t('web.customer.thankyou.your_credentials_are')}}
            <p class="mt-3 mb-2 fw-normal">
            <label for="">{{$t('email')}} :</label> {{ customer_credentials.email }}
            </p>
            <p class="fw-normal mb-0">
            <label for="">{{$t('password')}} :</label> {{ customer_credentials.password }}
            </p>
          </div>
      <nuxt-link to="/" class="btn bg-warning rounded lh-sm fw-bold text-uppercase">{{$t('continue_shopping')}}</nuxt-link>
  </div>
</template>

<script>
export default {

  props:['order_num','customer_credentials','ordered_id'],

  async fetch(){
  },
    mounted()
    {
         localStorage.removeItem("coupon_applied");
    }
}
</script>

<style>

</style>
