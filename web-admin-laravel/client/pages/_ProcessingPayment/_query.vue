<template>
  <div class="thanks-you-form shadow rounded bg-white-secondary-light text-center">
    <div class="thank-icon"><fa :icon=" error ? ['fas', 'times-circle'] : ['fas', 'check-circle'] "/></div>
    <h2 class="text-uppercase fw-bold my-3" v-if='paymentProcessing' >{{$t('web.customer.thankyou.label')}}</h2>
    <!-- <p class="fs-6" v-if='paymentProcessing'>Be Patience Your payment is Processing..</p> -->
    <p class="fs-6" v-if='!error'> {{ message }} </p>
    <p class="fs-6" v-else> {{ message }} </p>
       <p class="fs-6">{{$t('web.customer.thankyou.description')}} <b v-if="customer_credentials && customer_credentials.email && customer_credentials.password">
        {{ order_number }}
        </b>
        <b v-else>
        <nuxt-link :to="'/customer/orders/'+order_id" >
        {{ order_number }}
        </nuxt-link>
        </b>
        </p>
          <div class="fw-bold" v-if="customer_credentials && customer_credentials.email && customer_credentials.password">{{$t('web.customer.thankyou.your_credentials_are')}}
            <p class="mt-3 mb-2 fw-normal">
            <label for="">{{$t('email')}} :</label> {{ customer_credentials.email }}
            </p>
            <p class="fw-normal mb-0">
            <label for="">{{$t('password')}} :</label> {{ customer_credentials.password }}
            </p>
          </div>
      <nuxt-link to="/" class="btn bg-warning rounded lh-sm fw-bold text-uppercase"> {{$t('continue_shopping')}}</nuxt-link>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  validate({ query }) {
  // Must be a number
if(query.payment_intent || query.token ||  query.razorpay_payment_id || query.status || query.reference){
  return true
}else{
  return false
}
},
    data() {
      return {
        paymentProcessing:true,
        message:'',
        error:false,
        formData:{
        data:[],
        },
        customer_credentials : '',
        order_number : '',
        order_id : '',
      }
    },
  async fetch(){
    var routeParam =this.$route.query ;
    routeParam.payment_method_code = this.$cookies.get('payment_method_code');
    this.customer_credentials = this.$cookies.get('customer_credentials');
    this.order_number = this.$cookies.get('order_number');
    this.order_id = this.$cookies.get('order_id');
    var obj = {
      "payment_method_code" : this.$cookies.get('payment_method_code'),
      "order_id" : this.$cookies.get('order_id'),
      "params" : routeParam,
    }
    this.formData.data.push(obj);
    let res = await this.$webService.verifyPayment(this.formData);
    if(res){
      if(res.captured){
        localStorage.removeItem("coupon_applied");
        this.paymentProcessing = false
        this.error = false
        this.message = 'Your Payment is successful'
      }else{
        this.paymentProcessing = false
        this.error = true;
        this.message = res.data.message
      }
    }
},

auth:false,
}
</script>

<style>

</style>
