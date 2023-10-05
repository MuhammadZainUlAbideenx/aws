<template>
  <div
    class="
      order-form-btns
      text-center
      d-flex
      flex-column
      px-5
      py-4
      bg-secondary
      rounded-bottom
    "
  >
    <div class="">
      <span class="text-center text-danger" v-if="payment_error">
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
        :disabled="loading"
      v-if="this.step == 5"
      class="btn bg-warning rounded py-2 lh-sm fw-bold text-uppercase mt-4 mx-3"
      @click="executePayment"
    >
    {{$t('web.btn_order.proceed_payment')}}
    </button>
    <a
      v-else-if="this.step == 2"
      class="btn bg-warning rounded py-2 lh-sm fw-bold text-uppercase mt-4 mx-3"
      @click="validateBillingAddress"
    >
      <span class="d-lg-block d-none">{{$t('next')}}</span>
      <span class="d-lg-none d-block">{{$t('next')}}</span>
    </a>
    <a
      v-else-if="this.step == 3"
      class="btn bg-warning rounded py-2 lh-sm fw-bold text-uppercase mt-4 mx-3"
      @click="validateShippingAddress"
    >
      <span class="d-lg-block d-none">{{$t('next')}}</span>
      <span class="d-lg-none d-block">{{$t('next')}}</span>
    </a>
    <a
      v-else-if="this.step == 4"
      class="btn bg-warning rounded py-2 lh-sm fw-bold text-uppercase mt-4 mx-3"
      @click="validateShippingMethod"
    >
      <span class="d-lg-block d-none">{{$t('next')}}</span>
      <span class="d-lg-none d-block">{{$t('next')}}</span>
    </a>
    <a
      v-else
      class="btn bg-warning rounded py-2 lh-sm fw-bold text-uppercase mt-4 mx-3"
      @click="nextStep"
    >
    {{$t('web.btn_order.other')}}
    </a>

    <!-- <a class="btn back-link text-decoration-none mt-3 fw-bold text-uppercase"  @click="backStep" >Back to Shopping</a> -->
  </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
export default {
  data() {
    return {
        loading : false,
      payment_error: "",
      formData: {
        // customer_id: "",
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
        shipping_value: "",
        plateForm: "web",
        paytm_mode: "",
        coupon_id: "",
      },
      order_nunber: "",
      order_id: "",
      calculated_shipping_value: "",
      guest_customer_credentials: {},
      errors: {},
    };
  },
  async fetch() {},
  computed: {
    ...mapGetters({
      allSettings: "allDefaultSettings",
      allCartItems: "Web/Cart/allCartItems",
    }),
  },
  props: [
    "step",
    "previous",
    "payment_details",
    "shipping_details",
    "shipping_method_id",
    "billing_details",
    "shipping_value"
  ],
  methods: {
    ...mapActions({
      fetchCartItems: "Web/Cart/fetchCartItems",
    }),
    async validateBillingAddress() {
      this.formData.billing_address = this.billing_details;
      await this.$webService
        .validateBillingAddress(this.formData)
        .then((res) => {
          // some error occur
          if (res.response) {
            this.errors = res.response.data.errors ?? res.response.data;
            this.$toast.error(res.response.data.message);
          } else {
            if (res.state) {
              this.errors = {};
              this.nextStep();
            }
          }
        })
        .catch((error) => {
          this.errors = error.response.data.errors;
        });
    },
    async validateShippingAddress() {
      this.formData.shipping_address = this.shipping_details;
      let res = await this.$webService
        .validateShippingAddress(this.formData)
        .then((res) => {
          // some error occur
          if (res.response) {
            this.errors = res.response.data.errors ?? res.response.data;
            this.$toast.error(res.response.data.message);
          } else {
            if (res.state) {
              this.calculated_shipping_value = res.data;
              this.errors = {};
              this.nextStep();
            }
          }
        })
        .catch((error) => {
          this.errors = error.response.data.errors;
        });
    },
    async validateShippingMethod() {
      this.formData.shipping_id = this.shipping_method_id;
      let res = await this.$webService
        .validateShippingMethod(this.formData)
        .then((res) => {
          // some error occur
          if (res.response) {
            this.errors = res.response.data.errors ?? res.response.data;
            this.$toast.error(res.response.data.message);
          } else {
            if (res.state) {
              this.errors = {};
              this.nextStep();
            }
          }
        })
        .catch((error) => {
          this.errors = error.response.data.errors;
        });
    },
    async executePayment() {

        this.loading =  true;
    this.formData.shipping_value = this.shipping_value ? this.shipping_value: "";
      this.formData.billing_address = this.billing_details;
      this.formData.shipping_address = this.shipping_details;
      this.formData.shipping_id = this.shipping_method_id;
      this.formData.payment_method_code =
        this.payment_details.payment_method_code;
      this.formData.cardInfo.number = this.payment_details.number;
      this.formData.cardInfo.exp_month = this.payment_details.exp_month;
      this.formData.cardInfo.exp_year = this.payment_details.exp_year;
      this.formData.cardInfo.cvc = this.payment_details.cvc;
      this.formData.paytm_mode = this.payment_details.paytm_mode;
      await this.$webService
        .executePayment(this.formData)
        .then((res) => {
            this.loading =  false;
          if (res.data.customer_credentials) {
            this.$cookies.set(
              "customer_credentials",
              res.data.customer_credentials
            );
          }
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
                this.nextStep();
              }
              if (res.authorization_required) {
                this.$cookies.set(
                  "payment_method_code",
                  this.formData.payment_method_code
                );
                this.$cookies.set("order_id", res.data.order_detail.order_id);
                this.$cookies.set(
                  "order_number",
                  res.data.order_detail.order_number
                );
                window.location.href = res.authorization_url;
                //  window.open(res.authorization_url)
              }
            }
            if (!res.success) {
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
    nextStep() {
      if (this.step == 3) {
        this.$emit("step_click_with_shipping_data", { 'step': this.step, 'calculated_shipping_value':this.calculated_shipping_value });
      } else {
        this.$emit("step_click", this.step);
      }
    },
    backStep() {
      this.$emit("step_click", this.previous);
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
  mounted() {
    this.formData.coupon_id = this.allCartItems.coupon_id ? this.allCartItems.coupon_id: "";

  },
};
</script>

<style>
</style>
