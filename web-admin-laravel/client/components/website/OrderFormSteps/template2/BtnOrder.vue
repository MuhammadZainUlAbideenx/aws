<template>
  <div class="order-form-btns text-center d-flex flex-column px-5 py-4 bg-secondary">
    <div class="">
      <span class="float-end text-danger" v-if="payment_error">
        <b>{{ payment_error }}</b>
      </span>
    </div>
    <div
      class="phone-no"
      v-if="
        allSettings &&
        allSettings.general_settings &&
        allSettings.general_settings.contact_number
      "
    >
      <span class="opacity-5">{{$t('web.btn_order.need_help_with_your_order')}}</span>
      <span class="text-primary fw-bold">{{$t('web.btn_order.hotline')}}</span>

      <span class="opacity-5">{{
        allSettings.general_settings.contact_number
      }}</span>
    </div>
    <button
      class="btn bg-primary text-white rounded-1 py-2 lh-lg fw-bold text-uppercase mt-4 mx-3"
      @click="executePayment"
      :disabled="!isPaymentMethodSelected || loading"
    >
    <span class="btn-pro me-2">
    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24" height="24" viewBox="0 0 391.4 489">
  <defs>
    <linearGradient id="linear-gradient" x1="0.872" y1="0.137" x2="0.029" y2="0.988" gradientUnits="objectBoundingBox">
      <stop offset="0" stop-color="#40abfd"/>
      <stop offset="1" stop-color="#00f7fe"/>
    </linearGradient>
  </defs>
  <g id="shopping" transform="translate(-48.8)">
    <g id="Group_188" data-name="Group 188">
      <path id="Path_316" data-name="Path 316" d="M440.1,422.7l-28-315.3a13.477,13.477,0,0,0-13.4-12.3H341.1a96.612,96.612,0,0,0-193.2,0H90.3a13.406,13.406,0,0,0-13.4,12.3l-28,315.3c0,.4-.1.8-.1,1.2,0,35.9,32.9,65.1,73.4,65.1H366.8c40.5,0,73.4-29.2,73.4-65.1A4.868,4.868,0,0,0,440.1,422.7ZM244.5,27a69.672,69.672,0,0,1,69.6,68.1H174.9A69.672,69.672,0,0,1,244.5,27ZM366.8,462H122.2c-25.4,0-46-16.8-46.4-37.5l26.8-302.3h45.2v41a13.5,13.5,0,0,0,27,0v-41H314.1v41a13.5,13.5,0,0,0,27,0v-41h45.2l26.9,302.3C412.8,445.2,392.1,462,366.8,462Z" fill="url(#linear-gradient)"/>
    </g>
  </g>
</svg>

    </span>
        {{$t('web.btn_order.proceed_payment')}}
    </button>
    <!-- <a class="btn back-link text-decoration-none mt-3 fw-bold text-uppercase"  @click="backStep" >Back to Shopping</a> -->
  </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
export default {
  data() {
    return {
        loading: false,
      payment_error: "",
      formData: {
        payment_method_code: "",
        cardInfo: {
          number: "",
          exp_month: "",
          exp_year: "",
          cvc: "",
        },
        billing_address: {},
        shipping_address: {},
        shipping_id: "",
        shipping_value:"",
        plateForm: "web",
        paytm_mode: "",
        coupon_id: ""
      },
      order_nunber: "",
      order_id:"",
      guest_customer_credentials: {},
      errors: {},
    };
  },
  async fetch() {

  },
  computed: {
    ...mapGetters({
      allSettings: "allDefaultSettings",
      allCartItems: 'Web/Cart/allCartItems',
    }),
  },
  props: [
    "payment_details",
    "shipping_details",
    "shipping_method_id",
    "billing_details",
    "shipping_method_value",
    "isPaymentMethodSelected"
  ],
  methods: {
    ...mapActions({
      fetchCartItems: "Web/Cart/fetchCartItems",
    }),
    async executePayment() {
        this.loading = true;
      this.formData.billing_address = this.billing_details;
      this.formData.shipping_address = this.shipping_details;
      this.formData.shipping_id = this.shipping_method_id;
      this.formData.shipping_value = this.shipping_method_value;
      this.formData.payment_method_code =this.payment_details.payment_method_code;
      this.formData.cardInfo.number = this.payment_details.number;
      this.formData.cardInfo.exp_month = this.payment_details.exp_month;
      this.formData.cardInfo.exp_year = this.payment_details.exp_year;
      this.formData.cardInfo.cvc = this.payment_details.cvc;
      this.formData.paytm_mode = this.payment_details.paytm_mode;

      await this.$webService
        .executePayment(this.formData)
        .then((res) => {
            this.loading = false;
          // some error occur
          if (res.response) {
            this.errors = res.response.data.errors ?? res.response.data;
            this.$toast.error(res.response.data.message);
          } else {

            if (res.success) {

              this.payment_error = "";
              if (res.captured) {

                this.fetchCartItems();
                this.order_nunber = res.data.order_detail.order_number;
                this.order_id = res.data.order_detail.order_id;

                if (res.data.customer_credentials) {
                  this.guest_customer_credentials =
                    res.data.customer_credentials;
                }
                this.$emit("customer", this.guest_customer_credentials);
                this.$emit("order_nunber", this.order_nunber);
                this.$emit("order_id", this.order_id);
                this.$emit("showThankYouPage", true);
              }
              if (res.authorization_required) {

                this.$cookies.set(
                  "payment_method_code",
                  this.formData.payment_method_code
                );
                this.$cookies.set("order_id", res.data.order_detail.order_id);
                this.$cookies.set("order_number", res.data.order_detail.order_number);

                window.location.href = res.authorization_url;
              }
            }
            if(!res.success)
            {
            this.$toast.error(res.message);
            }
            if (res.data.message) {
              this.payment_error = res.data.message;
            }
            this.errors = {};
          }
        })
        .catch((error) => {
            this.loading = false;
          this.errors = error.response.data.errors;
        });
    },
  },
  watch: {
    guest_customer_credentials: {
      deep: true,
      handler() {
        this.$emit(
          "guest_customer_credentials",
          this.guest_customer_credentials
        );
      },
    },
    errors: {
      deep: true,
      handler() {
        this.$emit("errors", this.errors);
      },
    },
  },
  mounted()
  {
      this.formData.coupon_id = this.allCartItems.coupon_id ? this.allCartItems.coupon_id: ''
  }
};
</script>

<style>
</style>
