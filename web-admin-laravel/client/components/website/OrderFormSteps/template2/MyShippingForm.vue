<template>
  <div class="my-shipping-methods">
    <form class="row g-3">
      <div class="col-md-12">
        <div class="form-check mb-3">
          <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" checked>
          <label class="form-check-label" for="flexRadioDefault1">Flat Rate -- $50.00</label>
        </div>
      </div>
      <div class="col-md-12 mt-4">
        <h5 class="text-primary text-body mb-4">UPS Shipping</h5>
        <div class="form-check mb-3">
          <input class="form-check-input" type="radio" name="flexRadio" id="flexRadio1">
          <label class="form-check-label" for="flexRadio1">Flat Rate -- $50.00</label>
        </div>
        <div class="form-check mb-3">
          <input class="form-check-input" type="radio" name="flexRadio" id="flexRadio2">
          <label class="form-check-label" for="flexRadio2">Flat Rate -- $50.00</label>
        </div>
        <div class="form-check mb-3">
          <input class="form-check-input" type="radio" name="flexRadio" id="flexRadio3">
          <label class="form-check-label" for="flexRadio3">Flat Rate -- $50.00</label>
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
