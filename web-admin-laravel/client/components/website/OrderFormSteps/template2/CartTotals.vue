<template>
  <div class="cart-totals bg-secondary p-4 mt-5">
    <div class="d-flex justify-content-between align-items-center px-3 mb-3 pt-1">
      <h5 class=" fw-bold mb-0 fs-4">
        {{ this.$t("cart_total") }}
      </h5>
    </div>
    <div class="cart-total-widget px-3">
      <ul class="product-list d-flex flex-column">
        <li>
          <h6 class="text-dark-50">{{ this.$t("sub_total") }}</h6>
          <div class="item-s">
             {{ allCartItems ? allCartItems.subtotal_with_currency : 0 }}
          </div>
        </li>
        <!-- <li class="flex-column justify-content-start align-items-start">
            <h6 class="text-dark-50">Shipping</h6>
            <select class="form-select form-control py-2 px-3" aria-label=".form-select-sm example">
                <option selected>Shipping</option>
                <option value="1">Rider Shipping</option>
                <option value="2">Two</option>
                <option value="3">Three</option>
            </select>
        </li> -->
        <li
          v-if="couponData.amount != null"
          class="d-flex justify-content-between"
        >
          <h6>{{ this.$t("discount") }} ({{ couponData.code }})</h6>
          <div class="d-flex flex-column">
              <div class="total-price item-s" v-if="allCartItems.currency_direction == 'rlt'">
              {{ allCartItems ? allCartItems.discount : 0 }}  {{ allCartItems.symbol }}
            </div>
             <div class="item-s" v-if="allCartItems.currency_direction == 'ltr'">
                {{ allCartItems.symbol }} {{ allCartItems ? allCartItems.discount : 0 }}
              </div>
            <div class="text-end">
              <fa
                v-on:click="resetCouponCode"
                :icon="['fas', 'trash']"
                class="me-3 text-danger"
              />
            </div>
          </div>
        </li>
        <li class="order-1 pb-0 border-top border-dark-50 mt-5">
          <h6>{{ this.$t("total") }} :</h6>
           <div class="total-price item-s" v-if="allCartItems.currency_direction == 'ltr'">
           {{allCartItems.symbol}} {{ totalAmount }}
          </div>
           <div class="total-price item-s" v-if="allCartItems.currency_direction == 'rlt'">
           {{ totalAmount }}{{allCartItems.symbol}}
          </div>
        </li>
        <li v-if="!couponApply" class="flex-column justify-content-start align-items-start">
            <h6 class="text-dark-50">{{$t('web.customer.cart.promo_code')}}</h6>
            <span class="d-flex w-100">
          <input
            type="text"
            class="form-control py-2 px-3"
            v-model="coupon_code"
            :placeholder="$t('web.customer.cart.enter_coupon_code')"
          /><br />
          <button
            type="button"
            v-on:click="validateCouponCode"
            class="btn btn-danger ms-2 d-flex justify-content-center py-2 px-3"
          >
            <span class="py-0 fw-bold text-uppercase">{{$t('web.customer.cart.apply')}}</span>
          </button>
            </span>
        </li>
      </ul>
      <div
        class="d-flex flex-column text-center py-4"
        v-if="$auth.loggedIn && $gates.hasRole('customer')"
      >
        <nuxt-link
          class="
            btn
            btn-primary
            rounded
            py-2
            lh-lg
            text-white
            fw-bold
            border-0
            text-uppercase
            d-lg-none d-block
          "
          to="/ProductOrder"
        >
          {{ this.$t("proceed_to_checkout") }}
        </nuxt-link>
        <nuxt-link
          class="
            btn
            btn-primary
            rounded
            py-2
            text-white
            border-0
            lh-lg
            fw-bold
            text-uppercase
            d-none d-lg-block
          "
          to="/ProductOrder"
        >
          {{ this.$t("proceed") }}
        </nuxt-link>
        <nuxt-link
          class="back-link text-decoration-none mt-4 fw-bold text-uppercase"
          to="/shop"
          >{{ this.$t("continue_shopping") }}</nuxt-link
        >
      </div>
      <div v-else class="d-flex flex-column text-center py-4">
        <button
          type="button"
          class="
            btn
            btn-primary
            border-0
            rounded
            text-white
            py-2
            lh-lg
            fw-bold
            text-uppercase
            d-none d-lg-block
          "
          name="button"
          data-bs-toggle="modal"
          data-bs-target="#DeleteItem24"
        >
          {{ this.$t("proceed_to_checkout") }}
        </button>
        <button
          type="button"
          class="
            btn
            btn-primary
            border-0
            rounded
            text-white
            py-2
            lh-lg
            fw-bold
            text-uppercase
            d-lg-none d-inline-block
          "
          name="button"
          data-bs-toggle="modal"
          data-bs-target="#DeleteItem24"
        >
          {{ this.$t("proceed") }}
        </button>
        <WebsiteOrderFormStepsTemplate1AuthModal />
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
export default {
  data() {
    return {
      coupon_code: "",
      loading: false,
      errors: {},
      couponData: {},
      totalAmount: "",
      couponApply: false,
    };
  },
  computed: {
    ...mapGetters({
      allCartItems: "Web/Cart/allCartItems",
    }),
  },
  methods: {
    ...mapActions({
      fetchCartItems: "Web/Cart/fetchCartItems",
    }),
    async validateCouponCode() {
      this.loading = true;
      let order_amount_split = this.allCartItems.subtotal.split(",").join("");
      await this.$webService
        .validateCouponCode({
          coupon_code: this.coupon_code,
          order_amount: order_amount_split,
        })
        .then((res) => {
          if (res.success) {
            this.couponData = res.data;
            this.couponApply = true;
            if (this.couponData.discount_type == 1) {
              // Cart Amount Dicount
              let order_amount_split = this.allCartItems.subtotal
                .split(",")
                .join("");
              let totalAmount =
                parseFloat(order_amount_split) -
                parseFloat(this.couponData.amount);
              totalAmount = this.format_number(totalAmount);
              this.totalAmount = totalAmount;
              this.allCartItems.discount = Math.round(this.couponData.amount);
              this.allCartItems.total = Math.round(this.totalAmount);
              this.allCartItems.coupon_id = this.couponData.id;
            } else if (this.couponData.discount_type == 2) {
              // Cart Amount in Percentage Dicount
              let amount = parseFloat(this.couponData.amount) / 100;
              let order_amount_split = this.allCartItems.subtotal
                .split(",")
                .join("");
              let percentage_amount = amount * parseFloat(order_amount_split);
              this.allCartItems.discount_with_currency = percentage_amount.toFixed(this.allCartItems.currency_decimal);
              this.allCartItems.discount = percentage_amount.toFixed(this.allCartItems.currency_decimal);
              let totalAmount =
                parseFloat(order_amount_split) - parseFloat(percentage_amount);
              totalAmount = this.format_number(totalAmount,this.allCartItems.currency_decimal);
              this.totalAmount = totalAmount;
              this.allCartItems.total = Math.round(this.totalAmount);
              this.allCartItems.coupon_id = this.couponData.id;
            }
            if (process.client) {
              localStorage.setItem("coupon_applied", this.coupon_code);
            }
            this.$toast.success(this.$t("coupon_is_applied"));
            this.loading = false;
          } else {
            this.loading = false;
             this.coupon_code = ''
            this.$toast.error(res.message);
          }
        })
        .catch((error) => {
          this.loading = false;
          this.errors = error.response.data.errors;
          this.$toast.error(this.errors.coupon_code[0]);
        });
    },
    resetCouponCode() {
      this.coupon_code = "";
      this.totalAmount = this.allCartItems.subtotal;
      this.couponData.amount = null;
      this.couponApply = false;
      localStorage.removeItem("coupon_applied");
      this.$toast.error(this.$t("coupon_is_removed"));
      this.fetchCartItems();
    },
    format_number(number,decimal) {
      return number.toFixed(decimal).replace(/(\d)(?=(\d{3})+\.)/g, "$1,");
    },
  },
  created() {
    if (process.client) {
      var coupon_applied = localStorage.getItem("coupon_applied");
      if (coupon_applied) {
        this.coupon_code = coupon_applied;
        this.validateCouponCode();
      }
    }
  },
  mounted() {
    this.totalAmount = this.allCartItems.subtotal;
  },
  watch: {
    allCartItems: {
      deep: true,
      immediate: true,
      handler() {
        this.totalAmount = this.allCartItems.subtotal;
        this.couponData.amount = null;
        this.couponApply = false;
      },
    },
  },
};
</script>

<style>
</style>
