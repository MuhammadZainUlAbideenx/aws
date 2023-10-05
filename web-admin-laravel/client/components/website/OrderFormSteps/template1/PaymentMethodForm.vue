<template>
  <div v-if="$fetchState.pending">
    <div class="general-card skeletion-effect p-5">
      <div class="text skeletion-animation"></div>
      <div class="text second skeletion-animation"></div>
      <div class="text third skeletion-animation"></div>
    </div>
  </div>
  <div v-else class="payment-methods pt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h5 class="text-primary text-uppercase fw-bold mb-0">
        {{ $t("web.customer.wallet.payment_methods") }}
      </h5>
    </div>
    <div
      class="payment-methods-form shadow rounded p-4 bg-white-secondary-light"
    >
      <form class="row g-3">
        <span
          class="float-end text-danger"
          v-if="all_errors && all_errors['payment_method_code']"
        >
          {{ all_errors["payment_method_code"][0] }}
        </span>
        <div
          class="col-md-12"
          v-if="payment_methods != '' && payment_methods.data"
        >
          <h5 class="text-primary text-body mb-4">{{$t('web.customer.wallet.payment_methods')}}</h5>
          <div class="row">
            <div
              class="col-6"
              v-for="(payment_method, index) in payment_methods.data"
              :key="index"
            >
              <div class="form-check mb-3 d-flex align-items-center">
                <input
                  class="form-check-input"
                  :id="`payment_${payment_method.id}`"
                  :value="payment_method.code"
                  v-model="details.payment_method_code"
                  type="radio"
                />
              <label
                  class="form-check-label mb-0 ms-3"
                  :for="`payment_${payment_method.id}`"
                  >
                  <!-- {{ payment_method.name }} -->
                   <img v-if="payment_method.image && payment_method.image.thumbnails" :src="`/backend${payment_method.image.thumbnails.small.thumbnail}`" class="rounded">
                  </label
                >
                <!--
                <label class="form-check-label" for="paymentRadio1"><img v-if='payment_method.image && payment_method.image.thumbnails && payment_method.image.thumbnails.small' v-bind:src=" url + `${payment_method.image.thumbnails.small.thumbnail}`" class="img-fluid"></label>
                  -->
              </div>
            </div>
            <div
              class="col-12"
              v-if="
                details.payment_method_code == 'stripe' ||
                details.payment_method_code == 'braintree' ||
                details.payment_method_code == 'paytm'
              "
            >
              <div class="payment-det-form border-top pt-4">
                <!--
                <label class="form-check-label" for="paymentRadio1"><img v-if='payment_method.image && payment_method.image.thumbnails && payment_method.image.thumbnails.small' v-bind:src=" url + `${payment_method.image.thumbnails.small.thumbnail}`" class="img-fluid"></label>
                  -->
                <div class="mb-3">
                  <span
                    class="float-end text-danger"
                    v-if="all_errors && all_errors['cardInfo.number']"
                  >
                    {{ all_errors["cardInfo.number"][0] }}
                  </span>
                  <label for="card-number" class="form-label"
                    > {{ $t("web.customer.wallet.card_number")}}</label
                  >
                  <input
                    class="form-control"
                    v-model="details.number"
                    min="16"
                    max="16"
                    type="text"
                    :placeholder="
                      $t('web.customer.wallet.card_number_placeholder')
                    "
                    aria-label="cardNumber"
                  />
                </div>
                <div class="mb-3">
                  <span
                    class="float-end text-danger"
                    v-if="all_errors && all_errors['cardInfo.exp_month']"
                  >
                    {{ all_errors["cardInfo.exp_month"][0] }}
                  </span>
                  <label for="exp-month" class="form-label"
                    >{{
                    $t("web.customer.wallet.card_exp_month")
                  }}</label
                  >
                  <input
                    class="form-control"
                    v-model="details.exp_month"
                    min="2"
                    max="2"
                    type="text"
                  :placeholder="
                      $t('web.customer.wallet.card_exp_month_placeholder')
                    "
                    aria-label="CardExpMonth"
                  />
                </div>
                <div class="mb-3">
                  <span
                    class="float-end text-danger"
                    v-if="all_errors && all_errors['cardInfo.exp_year']"
                  >
                    {{ all_errors["cardInfo.exp_year"][0] }}
                  </span>
                  <label for="exp-year" class="form-label">{{
                    $t("web.customer.wallet.card_exp_year")
                  }}</label>
                  <input
                    class="form-control"
                    v-model="details.exp_year"
                    min="2"
                    max="2"
                    type="text"
                   :placeholder="
                      $t('web.customer.wallet.card_exp_year_placeholder')
                    "
                    aria-label="CardExpYear"
                  />
                </div>
                <div class="mb-3">
                  <span
                    class="float-end text-danger"
                    v-if="all_errors && all_errors['cardInfo.cvc']"
                  >
                    {{ all_errors["cardInfo.cvc"][0] }}
                  </span>
                  <label for="exp-cvv" class="form-label">{{
                    $t("web.customer.wallet.card_exp_cvv")
                  }}</label>
                  <input
                    class="form-control"
                    v-model="details.cvc"
                    min="3"
                    max="3"
                    type="text"
                    :placeholder="
                      $t('web.customer.wallet.card_exp_cvv_placeholder')
                    "
                    aria-label="CardExpCvv"
                  />
                </div>
              </div>
            </div>
            <!-- <div class="col-6" v-if="details.payment_method_code == 'paytm'">
              <input class="form-check-input" value='balance' v-model='details.paytm_mode' type="radio" >
              <label for=""> <p>Paytm Balance</p> </label>
              <input class="form-check-input" value='card' v-model='details.paytm_mode' type="radio" >
              <label for=""> <p>Card</p> </label>

              <div class="form-check mb-5" v-if="details.paytm_mode == 'card'"> -->
            <!--
                <label class="form-check-label" for="paymentRadio1"><img v-if='payment_method.image && payment_method.image.thumbnails && payment_method.image.thumbnails.small' v-bind:src=" url + `${payment_method.image.thumbnails.small.thumbnail}`" class="img-fluid"></label>
                  -->
            <!-- <p>Paytm Number</p>
                <input class="form-input" v-model='details.number'>
                <p>Card Exp Month</p>
                <input class="form-input" v-model='details.exp_month'>
                <p>Card Exp Year</p>
                <input class="form-input" v-model='details.exp_year'>
                <p>Card Exp Cvv</p>
                <input class="form-input" v-model='details.cvc'>
              </div>
              <div class="form-check mb-5" v-if="details.paytm_mode == 'balance'"> -->
            <!--
                <label class="form-check-label" for="paymentRadio1"><img v-if='payment_method.image && payment_method.image.thumbnails && payment_method.image.thumbnails.small' v-bind:src=" url + `${payment_method.image.thumbnails.small.thumbnail}`" class="img-fluid"></label>
                  -->
            <!-- <p>Paytm Phone Number for Otp</p>
                <input class="form-input" v-model='details.phone_number'>
              </div>
            </div> -->
          </div>
        </div>
        <!-- <div class="col-md-12 mt-4">
          <h5 class="text-primary text-body mb-4">Order Notes</h5>
          <div class="mb-3">
            <textarea
              class="form-control"
              id="validationTextarea"
              placeholder="Order Notes"
              required
            >
              Stripe: Test Card1 details:  number:4242424242424242 exp_month:05 exp_year:2030 cvc:123


              Braintree: Test Card2 details:  number:4111111111111111 exp_month:05 exp_year:2030 cvc:123
            </textarea>
            <div class="invalid-feedback">
              Please enter a message in the textarea.
            </div>
          </div>
        </div> -->
      </form>
    </div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  data() {
    return {
      payment_methods: {},
      url: "/backend",
      details: {
        payment_method_code: "",
        number: "",
        exp_month: "",
        exp_year: "",
        cvc: "",
        phone_number: "",
        paytm_mode: "",
      },
    };
  },
  props: ["all_errors"],
  async fetch() {
    this.payment_methods = await this.$webService.allPaymentMethods();
    this.details.payment_method_code = this.payment_methods.data[0].code;
  },
  methods: {},
  watch: {
    details: {
      deep: true,
      handler() {
        this.$emit("details", this.details);
      },
    },
  },
};
</script>

<style>
</style>
