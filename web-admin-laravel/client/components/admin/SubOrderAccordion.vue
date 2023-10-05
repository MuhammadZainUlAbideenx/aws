<template>
  <div>
      <div>
      <table class="table text-center">
                    <tbody>
                      <tr >
                        <td ><b>Sr#</b></td>
                        <td >
                          <b>{{ this.$t("columns.consignment_number") }}
                        </b></td>
                        <td >
                          <b>{{ this.$t("columns.order_status") }}
                        </b></td>
                        <td >
                          <b>{{
                            this.$t("columns.order_time_currency_display_total")
                          }}</b>
                        </td>
                        <td ><b>{{ this.$t("columns.is_paid") }}</b></td>
                        <td >
                          <b>{{ this.$t("columns.payment_method") }}</b>
                        </td>
                         <td >
                          <b>{{ this.$t("columns.store_name") }}</b>
                        </td>
                        <td ><b>{{ this.$t("columns.status") }}</b></td>

                      </tr>
                    </tbody>
                  </table>
                  </div>
    <div
      class="accordion accordion-flush"
      id="accordionFlushExample"
      v-for="(detail, index) in order"
      :key="index"
    >
      <div class="accordion-item">
        <h2 class="accordion-header" :id="`flush-headingOne${index}`">
          <button
            class="accordion-button collapsed"
            type="button"
            data-bs-toggle="collapse"
            :data-bs-target="`#flush-collapseOne${index}`"
            aria-expanded="false"
            aria-controls="flush-collapseOne"
          >
            <table class="table text-center mb-0">
              <tbody>
                <tr>
                  <td >{{ index + 1 }}</td>
                  <td>{{ detail.number }}</td>
                  <td>{{ detail.order_status.name }}</td>
                  <td>
                    {{ detail.order_time_currency_display_total }}
                  </td>
                  <td>
                    <span v-if="detail.is_paid == 1">
                      {{ $t("is_paid") }}
                    </span>
                    <span v-else>
                      {{ $t("is_not_paid") }}
                    </span>
                  </td>
                  <td>
                    <span v-if="detail.payment_method.code == 'cash_on_delivery'">
                      {{ $t("payment.cash_on_delivery") }}
                    </span>
                    <span v-else-if="detail.payment_method.code == 'wallet'">
                      {{ $t("payment.wallet") }}
                    </span>
                    <span v-else-if="detail.payment_method.code == 'stripe'">
                      {{ $t("payment.stripe") }}
                    </span>
                    <span v-else-if="detail.payment_method.code == 'braintree'">
                      {{ $t("payment.braintree") }}
                    </span>
                    <span v-else-if="detail.payment_method.code == 'paypal'">
                      {{ $t("payment.paypal") }}
                    </span>
                  </td>
                  <td v-if="detail.vendor.store_details">
                      {{detail.vendor.store_details.name}}
                  </td>
                  <td v-else>
                      Admin
                  </td>
                  <td>
                    <div v-if="detail.is_active == 1">
                      <div class="form-switch">
                        <input
                          class="form-check-input"
                          :checked="detail.is_active == 1 ? 'checked' : ''"
                          type="checkbox"
                          id="flexSwitchCheckChecked"
                        />
                      </div>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </button>
        </h2>
        <div
          :id="`flush-collapseOne${index}`"
          class="accordion-collapse collapse"
          aria-labelledby="flush-headingOne"
          data-bs-parent="#accordionFlushExample"
        >
          <div class="accordion-body">
            <div
              v-for="(product, index) in detail.order_products"
              :key="index"
            >
              <div
                class="row my-3 order-items p-3 shadow-sm mb-3 border"

              >
                <div
                  class="
                    col-md-2
                    d-flex
                    justify-content-center
                    align-items-center
                  "
                >
                  <div
                    class="item-img"
                    v-if="
                      product.product.media &&
                      product.product.media[0] &&
                      product.product.media[0].thumbnails
                    "
                  >
                    <img
                      :src="`/backend${product.product.media[0].thumbnails.small.thumbnail}`"
                      alt="Product Image"
                      class="img-fluid"
                    />
                  </div>
                  <div class="item-img" v-else>
                    <img
                      src="/_nuxt/client/assets/images/ringg.png"
                      alt="Product Image"
                      class="img-fluid"
                    />
                  </div>
                </div>

                <div
                  class="
                    col-md-4
                    d-flex
                    justify-content-start
                    align-items-center
                  "
                >
                  <div class="item-detail w-75 pe-5">
                    <h4 class="mb-0">
                      {{ product.product.name }}
                    </h4>
                    <span
                      v-if="product.order_product_variant_details"
                      v-for="variant in product.order_product_variant_details"
                    >
                      {{ variant.attribute_name }} : {{ variant.value_name }}
                      <br />
                    </span>
                  </div>
                  {{$t('quantity')}}:<span
                    class="
                      col-md-2
                      d-flex
                      justify-content-center
                      align-items-center
                      fw-bold
                    "
                    v-if="product.quantity"
                  >
                    {{ product.quantity }}
                  </span>
                </div>

                <div
                  class="
                    col-md-3
                    d-flex
                    justify-content-center
                    align-items-center
                  "
                  v-if="product.sale_type != null"
                >
                  <div class="text-primary h4 fw-bold mb-0">
                    {{
                      product.current_product_order_time_total_sale_display_price
                    }}
                  </div>
                </div>
                <div
                  v-else
                  class="
                    col-md-3
                    d-flex
                    justify-content-center
                    align-items-center
                  "
                >
                  <div class="text-primary h4 fw-bold mb-1">
                    {{ product.current_product_order_time_total_display_price }}
                  </div>
                </div>
                <!-- <div
                  class="
                    col-md-3
                    d-flex
                    justify-content-start
                    align-items-center
                  "
                >
                  <div
                    class="h4 fw-bold mb-1"
                    v-if="product.product.vendor.store"
                  >
                    <span class="text-dark">By: &nbsp;</span>
                    <nuxt-link
                      :to="`/store/${product.product.vendor.store.slug}`"
                      class="text-primary primary_border text-uppercase"
                    >
                      {{ product.product.vendor.store.name }}</nuxt-link
                    >
                  </div>
                </div> -->

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script >
export default {
  props: ["order"],
  data() {
    return {};
  },
  mounted() {
  },
};
</script>
