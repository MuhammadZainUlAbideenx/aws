<template>
  <div class="cart-detail mt-3">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h5 class="text-primary text-uppercase fw-bold mb-0">{{$t('web.customer.cart.label')}}</h5>
    </div>
    <div class="cart-detail-widget shadow rounded bg-white-secondary-light">
      <ul class="product-list" v-if="allCartItems">
        <li class="px-4 py-lg-4 custom-width-card"
          :class="[
            stock_exceeds.includes(cart_item.id) ? 'bg-danger' : '',
            max_order_exceeds.includes(cart_item.id) ? 'bg-danger' : '',
          ]"
          v-for="(cart_item, index) in allCartItems.cart_items"
          :key="cart_item.id"
        >
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
          <div class="item-img mb-md-3 mb-lg-0" v-else>
            <img
              src="~/assets/images/defult-product-img.png"
              alt="Product Image"
              class="img-fluid"
            />
          </div>
          <div
            class="
              item-det-wrap
              d-flex
              align-items-center
              justify-content-between
              flex-fill
              w-100
            "
          >
            <div class="item-detail flex-grow-1">
              <h6 class="mb-0">
                <nuxt-link :to="`/product/${cart_item.product.slug}`">
                  {{ cart_item.product.name }}
                </nuxt-link>
              </h6>
              <span v-for="att_val_name in cart_item.attribute_value_names">
                {{ att_val_name.attribute_name }} :
                {{ att_val_name.value_name }} <br />
              </span>
            </div>
            <div
              class="
                item-img-det
                d-flex
                align-items-start
                align-items-md-center
                justify-content-between
                flex-column flex-md-row
              "
            >
              <div class="item-s w-auto me-3">{{ cart_item.single_price }}
                <span class="text-danger text-decoration-line-through" v-if="cart_item.product.special_sale || cart_item.product.flash_sale">
                {{cart_item.single_default_price_without_sale_web}}
                </span>
              </div>
              <WebsiteTemplate1PlusMinusInput
                :initial="cart_item.quantity"
                @change="quantityChanged(cart_item.id)"
                v-model="quantity_changed[`cart_${cart_item.id}`]"
                :min="cart_item.product.min_order"
                :max="cart_item.stock"
              />
              <span v-if="stock_exceeds.includes(cart_item.id)">{{
                $t("cart_out_of_stock_message")
              }}</span>
              <span v-if="max_order_exceeds.includes(cart_item.id)" class="fs-6">{{
                $t("cart_max_order_limit_reached_message")
              }}</span>
              <div class="item-s">{{ cart_item.display_price }}</div>
            </div>
          </div>
          <div class="item-remove">
            <span
              class="btn-close"
              @click="removeFromCart(cart_item.id)"
            ></span>
          </div>
        </li>
      </ul>
    </div>
    <div class="coupon-btns d-flex justify-content-between flex-column flex-md-row">
      <div class="input-group coupon-field">
        <!-- <input type="text" class="form-control" placeholder="Enter Coupon Code" aria-label="Enter Coupon Code" aria-describedby="basic-addon2"> -->
        <!-- <div class="input-group-append">
          <button class="btn bg-warning w-100 h-100 text-uppercase fw-bold" type="button">Apply</button>
        </div> -->
      </div>

      <div class="col-md-12">
        <button
          class="btn btn-primary text-uppercase fw-bold px-3 float-end"
          @click="updateCart()"
        >
          {{ $t("update_cart") }}
        </button>
        <button
          v-on:click="deleteAllCartItems"
          type="button"
          class="btn btn-danger me-2 float-end text-uppercase fw-bold px-3"
        >
          {{$t('web.customer.compare.clear_cart')}}
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
export default {
  data() {
    return {
      quantity_changed: {},
      cart_to_update: [],
      stock_exceeds: [],
      max_order_exceeds: [],
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
    quantityChanged(cart_id) {
      var ind = this.cart_to_update.findIndex((obj) => obj.cart_id == cart_id);
      if (ind == -1) {
        this.cart_to_update.push({
          cart_id: cart_id,
          quantity: this.quantity_changed[`cart_${cart_id}`],
        });
      } else {
        this.cart_to_update[ind].quantity =
          this.quantity_changed[`cart_${cart_id}`];
      }
    },
    async removeFromCart(cart_id) {
      await this.$webService.removeCartItem(cart_id).then(async (res) => {
        await this.fetchCartItems();
        this.$toast.success(res.message);
        localStorage.removeItem("coupon_applied");
      });
    },
    async updateCart() {
      await this.$webService
        .changeCartItemQuantity({ cart_items: this.cart_to_update })
        .then(async (res) => {
          if (res.success) {
            this.stock_exceeds = [];
            this.max_order_exceeds = [];
            this.$toast.success(res.message);
            await this.fetchCartItems();
          } else {
            this.stock_exceeds = res.data.stock_exceeds;
            this.max_order_exceeds = res.data.max_order_exceeds;
            this.$toast.error(res.message);
          }
        });
    },
    async deleteAllCartItems() {
      await this.$webService.deleteAllCartItems().then(async (res) => {
        await this.fetchCartItems();
        this.$toast.success(res.message);
        localStorage.removeItem("coupon_applied");
      });
    },
  },
};
</script>

<style>
</style>
