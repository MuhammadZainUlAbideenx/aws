<template>
  <div>
    <div class="container">
      <div class="row" v-if=" Step == 1 && $fetchState.pending">
        <div class="col-md-5 skeletion-effect">
          <div class="cart-totals">
            <div class="d-flex justify-content-between align-items-center mb-4">
              <div class="h2 skeletion-animation"></div>
            </div>
            <div class="cart-total-widget shadow rounded bg-secondary">
              <ul class="product-list">
                <li>
                  <p class="text skeletion-animation"></p>
                </li>
                <li>
                  <p class="text skeletion-animation"></p>
                </li>
                <li>
                  <p class="text skeletion-animation"></p>
                </li>
              </ul>
              <div
                class="d-flex align-items-center flex-column text-center p-4"
              >
                <button class="btn text skeletion-animation btn-block"></button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row" v-else>
        <div class="col-lg-7 col-md-6 mb-3 mb-md-5">
          <WebsiteOrderFormStepsTemplate2BillingAddressForm
             :all_errors="all_errors"
            @billing_address="billing_address"
            :billing_details="billing_details"
             @errors="errors"
             @shipping_method_details="shipping_method_details"
             @shipping_address="shipping_address"
             @details="details"
             @paymentMethodsFilled="(paymentMethodsFilled)=> this.isPaymentMethodSelected = paymentMethodsFilled"
             />
        </div>
        <div class="col-lg-5 col-md-6 mb-5">
            <WebsiteOrderFormStepsTemplate2CartSummary
             :shipping_value="shipping_method_value"
             />
          <WebsiteOrderFormStepsTemplate2BtnOrder
             @errors="errors"
            :shipping_details="shipping_details"
            :shipping_method_id="shipping_method_id"
            :shipping_method_value="shipping_method_value"
            :billing_details="billing_details"
            :payment_details="details_payment"
            @showThankYouPage="showThankYouPage"
            @customer="customer"
            @order_nunber="order_nunber"
            @order_id="order_id"
            :isPaymentMethodSelected="isPaymentMethodSelected"
             />
        </div>
      </div>

    </div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";

export default {
 data() {
    return {
     thankYou: false,
     isPaymentMethodSelected: false,
      Step: 1,
      previous: 1,
      billing_details: {},
      shipping_method_id: "",
      shipping_method_value: "",
      shipping_details: {},
      details_payment: {},
      order_num: "",
      ordered_id: "",
      all_errors: {},
      customer_credentials: {},
      calculated_shipping_value:""
    };
  },
  fetch() {},
  computed: {
    ...mapGetters({
      allCartItems: "Web/Cart/allCartItems",
    }),
  },
  methods: {
    changeStep(step) {
      this.Step = step;
    },
    step_click_with_shipping_data({step,calculated_shipping_value}) {
        this.Step = step;
        this.calculated_shipping_value = calculated_shipping_value;
    },
    details(details) {
      this.details_payment = details;
    },
    shipping_method_details(shipping_method_details) {
      this.shipping_method_id = shipping_method_details.id;
      this.shipping_method_value = shipping_method_details.value;
    },
    shipping_address(shipping_address) {
      this.shipping_details = shipping_address;
    },
    billing_address(billing_address) {
      this.billing_details = billing_address;
    },
    order_nunber(order_nunber) {
      this.order_num = order_nunber;
    },
    order_id(order_id) {
      this.ordered_id = order_id;
    },
    customer(customer) {
      this.customer_credentials = customer;
    },
    errors(errors) {
      this.all_errors = errors;
    },
    step_clicked(step_clicked) {
      this.Step = step_clicked;
    },
    showThankYouPage(showThankYouPage)
    {
         this.$emit("customer", this.customer_credentials);
        this.$emit("order_nunber", this.order_num);
        this.$emit("order_id", this.ordered_id);
        this.$emit("showThankYouPage",showThankYouPage);
    }
  },
}
</script>

<style>

</style>
