<template>
  <div class="cart-summary pt-4 bg-secondary rounded-top">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h5 class="text-primary text-uppercase fw-bold mb-0 ps-3">
        {{ this.$t("order_summary") }}
      </h5>
      <a
        href="#"
        class="text-primary text-uppercase text-decoration-none fw-bold fs-7"
      ></a>
    </div>
    <div class="cart-summary-widget">
      <ul class="product-list" v-if="allCartItems">
        <li v-for="cart_item in allCartItems.cart_items" :key="cart_item.id">
          <div
            class="item-img"
            v-if="
              cart_item.product.media &&
              cart_item.product.media[0] &&
              cart_item.product.media[0].thumbnails
            "
          >
            <img
              :src="`/backend${cart_item.product.media[0].thumbnails.small.thumbnail}`"
              alt="Product Image"
              class="img-fluid"
            />
          </div>
          <div class="item-img" v-else>
            <img
              src="~/assets/images/defult-product-img.png"
              alt="Product Image"
              class="img-fluid"
            />
          </div>
          <div class="item-detail-wrap d-flex flex-grow-1 align-items-center">
            <div class="item-detail">
              <h6>
                <nuxt-link :to="`/product/${cart_item.product.slug}`">
                  {{ cart_item.product.name }}
                </nuxt-link>
              </h6>
              <!-- <p class="opacity-5">Women's Fashiom</p> -->
            </div>
            <div class="item-s">
              {{ cart_item.quantity }} x {{ cart_item.single_price }}
            </div>
          </div>
        </li>
      </ul>
      <ul class="product-detail-list">
        <li>
          <ul>
            <li>
              <h6 class="text-start">{{ this.$t("sub_total") }}</h6>
              <div class="item-s text-end">
                {{ allCartItems ? allCartItems.subtotal_with_currency : 0 }}

              </div>
            </li>
          </ul>
        </li>
        <li v-if="allCartItems.discount">
          <ul>
            <li>
              <h6 class="text-start">{{ this.$t("discount") }}</h6>
              <div class="item-s text-end" v-if="allCartItems.currency_direction == 'rlt'">
                {{ allCartItems ? allCartItems.discount : 0 }}
                {{ allCartItems.symbol }}
              </div>
              <div class="item-s text-end" v-if="allCartItems.currency_direction == 'ltr'">
                {{ allCartItems.symbol }} {{ allCartItems ? allCartItems.discount : 0 }}
              </div>
            </li>
          </ul>
        </li>
        <li v-if="shipping_value">
          <ul>
            <li>
              <h6 class="text-start">{{ this.$t("shipping") }}</h6>
              <div class="item-s text-end" v-if="allCartItems.currency_direction == 'rlt'">
                {{ shipping_value }} {{ allCartItems.symbol }}
              </div>
               <div class="item-s text-end" v-if="allCartItems.currency_direction == 'ltr'">
                {{ allCartItems.symbol }} {{ shipping_value }}
              </div>
            </li>
          </ul>
        </li>
        <li v-if="shippingApply">
          <h6 class="text-start">{{ this.$t("total") }}</h6>
          <div class="total-price item-s text-end" v-if="allCartItems.currency_direction == 'rlt'">
            {{ totalAfterShipping }} {{ allCartItems.symbol }}
          </div>
          <div class="total-price item-s text-end" v-if="allCartItems.currency_direction == 'ltr'">
           {{ allCartItems.symbol }} {{ totalAfterShipping }}
          </div>
        </li>
        <li v-else>
          <h6 class="text-start">{{ this.$t("total") }}</h6>
          <div class="total-price item-s text-end" v-if="allCartItems.currency_direction == 'rlt'">
            {{
              allCartItems.total ? allCartItems.total : allCartItems.subtotal
            }}
            {{ allCartItems.symbol }}
          </div>
           <div class="total-price item-s text-end" v-if="allCartItems.currency_direction == 'ltr'">
             {{ allCartItems.symbol }}  {{
              allCartItems.total ? allCartItems.total : allCartItems.subtotal
            }}
          </div>
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  props: ["shipping_value"],
  data() {
    return {
      shippingApply: false,
      totalAfterShipping: "",
    };
  },
  methods: {
    format_number(number,decimal) {
      return number.toFixed(decimal).replace(/(\d)(?=(\d{3})+\.)/g, "$1,");
    },
  },
  computed: {
    ...mapGetters({
      allCartItems: "Web/Cart/allCartItems",
    }),
  },
  created() {
    if (this.allCartItems.discount) {
      let order_amount_split = this.allCartItems.subtotal.split(",").join("");
      let totalAmount =
        parseFloat(order_amount_split) - parseFloat(this.allCartItems.discount);
      totalAmount = this.format_number(totalAmount,this.allCartItems.currency_decimal);
      this.allCartItems.total = totalAmount;
    }
  },
  watch: {
    shipping_value: {
      // the callback will be called immediately after the start of the observation
      immediate: true,
      handler(val, oldVal) {
        if (val) {
          if (this.allCartItems.total) {
            this.shippingApply = true;
            let order_amount_split = this.allCartItems.total
              .split(",")
              .join("");
            let totalAfterShipping =
              parseFloat(order_amount_split) + parseFloat(val);
            this.totalAfterShipping = this.format_number(totalAfterShipping,this.allCartItems.currency_decimal);
          } else {
            this.shippingApply = true;
            let order_amount_split = this.allCartItems.subtotal
              .split(",")
              .join("");
            let totalAfterShipping =
              parseFloat(order_amount_split) + parseFloat(val);
            this.totalAfterShipping = this.format_number(totalAfterShipping,this.allCartItems.currency_decimal);
          }
        } else {
          this.shippingApply = false;
        }
      },
    },
  },
};
</script>

<style>
</style>
