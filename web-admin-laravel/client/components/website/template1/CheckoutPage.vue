<template>
  <div>
    <WebsiteOrderFormStepsTemplate1StepWidget
      :step="Step"
      @step_clicked="step_clicked"
     />
    <div class="container">
      <div class="row" v-if="Step == 1 && $fetchState.pending">
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
      <div class="row" v-else-if="Step == 1">
        <div class="col-lg-7 col-md-6 mb-3 mb-md-5">
          <WebsiteOrderFormStepsTemplate1BillingAddressForm
             :all_errors="all_errors"
            @billing_address="billing_address"
            @shipping_selected_country="(shipping_selected_country)=>this.shipping_selected_country = shipping_selected_country"
             />
        </div>
        <div class="col-lg-5 col-md-6 mb-5">
            <WebsiteOrderFormStepsTemplate1CartSummary
             :shipping_value="shipping_method_value"
             />
          <WebsiteOrderFormStepsTemplate1BtnOrder
             @errors="errors"
            @order_nunber="order_nunber"
            :shipping_details="shipping_details"
            :shipping_method_id="shipping_method_id"
            :billing_details="billing_details"
            :payment_details="details_payment"
            step="2"
            previous="1"
            @step_click="changeStep"

             />
        </div>
      </div>
      <div class="row" v-else-if="Step == 2">
        <div class="col-lg-7 col-md-6 mb-3 mb-md-5">
        <WebsiteOrderFormStepsTemplate1ShippingForm
             :all_errors="all_errors"
            @shipping_address="shipping_address"
            :billing_details="billing_details"
            :shipping_selected_country="shipping_selected_country"
             />
        </div>
        <div class="col-lg-5 col-md-6 mb-5">
           <WebsiteOrderFormStepsTemplate1CartSummary
            :shipping_value="shipping_method_value"
             />
            <WebsiteOrderFormStepsTemplate1BtnOrder
            @errors="errors"
            step="3"
            @order_nunber="order_nunber"
            :shipping_details="shipping_details"
            :shipping_method_id="shipping_method_id"
            :billing_details="billing_details"
            :payment_details="details_payment"
            previous="2"
            @step_click="changeStep"
            @step_click_with_shipping_data="step_click_with_shipping_data"
             />
        </div>
      </div>
      <div class="row" v-else-if="Step == 3">
        <div class="col-lg-7 col-md-6 mb-3 mb-md-5">
            <WebsiteOrderFormStepsTemplate1ShippingMethod
            :all_errors="all_errors"
            @shipping_method_details="shipping_method_details"
            :calculated_shipping_value="calculated_shipping_value"
             />
        </div>
        <div class="col-lg-5 col-md-6 mb-5">

          <WebsiteOrderFormStepsTemplate1CartSummary
            :shipping_value="shipping_method_value"
             />
            <WebsiteOrderFormStepsTemplate1BtnOrder
                @errors="errors"
                step="4"
                @order_nunber="order_nunber"
                :shipping_details="shipping_details"
                :shipping_method_id="shipping_method_id"
                :billing_details="billing_details"
                :payment_details="details_payment"
                previous="3"
                @step_click="changeStep"
             />
        </div>
      </div>
      <div class="row" v-else-if="Step == 4">
        <div class="col-lg-7 col-md-6 mb-3 mb-md-5">
                <WebsiteOrderFormStepsTemplate1PaymentMethodForm
                :all_errors="all_errors"
                @details="details"
             />
        </div>
        <div class="col-lg-5 col-md-6 mb-5">
            <WebsiteOrderFormStepsTemplate1CartSummary
                :shipping_value="shipping_method_value"
             />
            <WebsiteOrderFormStepsTemplate1BtnOrder
                @customer="customer"
                @errors="errors"
                step="5"
                @order_nunber="order_nunber"
                @order_id="order_id"
                :shipping_details="shipping_details"
                :shipping_method_id="shipping_method_id"
                :billing_details="billing_details"
                :payment_details="details_payment"
                :shipping_value="shipping_method_value"
                previous="4"
                @step_click="changeStep"
             />
        </div>
      </div>
      <div class="row" v-else-if="Step == 5">
        <div class="col-12">
              <WebsiteOrderFormStepsTemplate1ThankYou
                :customer_credentials="customer_credentials"
                :order_num="order_num"
                :ordered_id="ordered_id"
             />
        </div>
      </div>
      <div v-else>
        <p>test</p>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";

export default {
 data() {
    return {
      Step: 1,
      previous: 1,
      shipping_selected_country:"",
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
  },
}
</script>

<style>

</style>
