<template>
  <div class="my-payment-methods payment-methods-form">
    <form class="row g-3">
      <div class="col-md-12">
        <div class="row">
          <div class="col-6">
            <div class="form-check mb-5">
              <input class="form-check-input" type="radio" name="paymentRadio" id="paymentRadio1" checked>
              <label class="form-check-label" for="paymentRadio1"><img src="~assets/images/payment-method/paypal-logo.png" class="img-fluid"></label>
            </div>
          </div>
          <div class="col-6">
            <div class="form-check mb-5">
              <input class="form-check-input" type="radio" name="paymentRadio" id="paymentRadio2">
              <label class="form-check-label" for="paymentRadio2"><img src="~assets/images/payment-method/stripe-logo.png" class="img-fluid"></label>
            </div>
          </div>
          <div class="col-6">
            <div class="form-check mb-5">
              <input class="form-check-input" type="radio" name="paymentRadio" id="paymentRadio3">
              <label class="form-check-label" for="paymentRadio3"><img src="~assets/images/payment-method/mastercard-logo.png" class="img-fluid"></label>
            </div>
          </div>
          <div class="col-6">
            <div class="form-check mb-5">
              <input class="form-check-input" type="radio" name="paymentRadio" id="paymentRadio4">
              <label class="form-check-label" for="paymentRadio4"><img src="~assets/images/payment-method/visa-logo.png" class="img-fluid"></label>
            </div>
          </div>
          <div class="col-6">
            <div class="form-check mb-5">
              <input class="form-check-input" type="radio" name="paymentRadio" id="paymentRadio5">
              <label class="form-check-label" for="paymentRadio5"><img src="~assets/images/payment-method/instamogo-logo.png" class="img-fluid"></label>
            </div>
          </div>
          <div class="col-6">
            <div class="form-check mb-5">
              <input class="form-check-input" type="radio" name="paymentRadio" id="paymentRadio6">
              <label class="form-check-label" for="paymentRadio6"><img src="~assets/images/payment-method/skrill-logo.png" class="img-fluid"></label>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
}
</script>

<style>

</style>
