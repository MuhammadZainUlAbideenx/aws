<template >
  <div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="row mb-2 g-0">
        <div class="col-sm-12 px-0">
          <h2 class="m-0 text-body bold">
            {{ this.$t("order.view_order") }}
          </h2>
        </div>
        <!-- /.col -->
        <div class="row">
          <div class="col-sm-12 px-0">
            <ol class="breadcrumb float-sm-right text-body">
              <li class="breadcrumb-item">
                <nuxt-link :to="localePath('/admin/dashboard')">{{
                  this.$t("sidebar.home")
                }}</nuxt-link>
              </li>
              <li class="breadcrumb-item">
                <nuxt-link :to="localePath('/admin/orders')">{{
                  this.$t("sidebar.order")
                }}</nuxt-link>
              </li>
              <li class="breadcrumb-item active">
                {{ this.$t("form.view") }}
              </li>
            </ol>
            <p class="text-body-secondary">
              {{ this.$t("order.view_description") }}
            </p>
          </div>
          <!-- /.col -->
        </div>
      </div>
      <!-- /.row -->
    </div>

    <!-- Main content -->
    <section class="content">
      <div v-if="$fetchState.pending">
        <AdminViewLoader />
      </div>
      <div class="container" v-else>
        <div class="row">
          <div class="col-lg-12">
            <div class="card gutter-b border-0">
              <div class="card-body">
                <div class="row" v-if="!order.sub_order">
                  <div
                    class="col-12 w-100 px-0"
                    v-for="product in order.order_products"
                    :key="product.id"
                  >
                    <div class="row mb-3 order-items p-3 shadow-sm mb-3 border">
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
                            src="~/assets/images/defult-product-img.png"
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
                            {{ variant.attribute_name }} :
                            {{ variant.value_name }} <br />
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
                          {{
                            product.current_product_order_time_total_display_price
                          }}
                        </div>
                      </div>
                      <!-- <div
                        class="
                          col-md-2
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
                      <div
                        class="
                          col-md-1
                          d-flex
                          justify-content-center
                          align-items-center
                        "

                      >
                        <div class="fw-bold mb-1">
                          <span class="text-dark">{{
                            order.order_status.name
                          }}</span>
                        </div>
                      </div>

                    </div>
                  </div>
                </div>
                <div class="row" v-else>
                  <!-- accordion starts  -->
                  <AdminSubOrderAccordion :order="order.sub_order_detail" />
                  <!-- accordion ends  -->
                </div>
                <div class="row">
                  <div class="show-table px-0 mb-0">
                    <div class="row mt-5">
                      <div class="col-md-6 ps-md-0">
                        <div
                          class="
                            row
                            justify-content-end
                            border
                            shadow-sm
                            px-3
                            py-4
                            rounded
                          "
                        >
                          <h2 class="my-4">{{$t('form.orders.shipping_address.label')}}</h2>
                          <div class="col-6">
                            <label for="input-live " class="form-label">{{
                              this.$t("form.orders.shipping_name.label")
                            }}</label>
                          </div>
                          <div class="col-6">
                            <p>{{ order.addresses.shipping.name }}</p>
                          </div>

                          <div class="col-6">
                            <label for="input-live " class="form-label">{{
                              this.$t("form.orders.shipping_address.label")
                            }}</label>
                          </div>
                          <div class="col-6">
                            <p>{{ order.addresses.shipping.address }}</p>
                          </div>
                          <div class="col-6" v-if="order.addresses.shipping.near_by ">
                            <label for="input-live " class="form-label">{{
                              this.$t("form.orders.shipping_address.near_by")
                            }}</label>
                          </div>
                          <div class="col-6" v-if="order.addresses.shipping.near_by ">
                            <p>{{ order.addresses.shipping.near_by }}</p>
                          </div>
                          <div class="col-6">
                            <label for="input-live " class="form-label">{{
                              this.$t("form.orders.shipping_phone.label")
                            }}</label>
                          </div>
                          <div class="col-6">
                            <p>{{ order.addresses.shipping.phone }}</p>
                          </div>
                           <div class="col-6">
                            <label for="input-live " class="form-label">{{
                              this.$t("form.orders.shipping_email.label")
                            }}</label>
                          </div>
                          <div class="col-6">
                            <p>{{ order.addresses.shipping.email }}</p>
                          </div>
                        </div>

                        <div
                          class="
                            row
                            justify-content-end
                            border
                            shadow-sm
                            px-3
                            py-4
                            mt-5
                            rounded
                          "
                        >
                          <h2 class="my-4">{{
                              this.$t("billing_details")
                            }}</h2>
                          <div class="col-6">
                            <label for="input-live " class="form-label">{{
                              this.$t("form.orders.billing_name.label")
                            }}</label>
                          </div>
                          <div class="col-6">
                            <p>{{ order.addresses.billing.name }}</p>
                          </div>

                          <div class="col-6">
                            <label for="input-live " class="form-label">{{
                              this.$t("form.orders.billing_address.label")
                            }}</label>
                          </div>
                          <div class="col-6">
                            <p>{{ order.addresses.billing.address }}</p>
                          </div>
                          <div class="col-6" v-if="order.addresses.billing.near_by">
                            <label for="input-live " class="form-label">{{
                              this.$t("form.orders.billing_address.near_by")
                            }}</label>
                          </div>
                          <div class="col-6" v-if="order.addresses.billing.near_by">
                            <p>{{ order.addresses.billing.near_by }}</p>
                          </div>
                          <div class="col-6">
                            <label for="input-live " class="form-label">{{
                              this.$t("form.orders.billing_phone.label")
                            }}</label>
                          </div>
                          <div class="col-6">
                            <p>{{ order.addresses.billing.phone }}</p>
                          </div>
                          <div class="col-6">
                            <label for="input-live " class="form-label">{{
                              this.$t("form.orders.billing_email.label")
                            }}</label>
                          </div>
                          <div class="col-6">
                            <p>{{ order.addresses.billing.email }}</p>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6 pe-md-0">
                        <div
                          class="
                            row
                            justify-content-end
                            border
                            shadow-sm
                            p-3
                            rounded
                          "
                        >
                          <h2 class="my-4">{{
                              this.$t("bill_summary")
                            }}</h2>
                          <div class="col-6">
                            <label for="input-live " class="form-label">{{
                              this.$t("form.orders.order_time_currency.label")
                            }}</label>
                          </div>
                          <div class="col-6">
                            <p>
                              {{
                                order.order_time_currency_display_sub_total_1
                              }}
                            </p>
                          </div>
                          <div class="col-6">
                            <label for="input-live " class="form-label">{{
                              this.$t(
                                "form.orders.display_shipping_price.label"
                              )
                            }}</label>
                          </div>
                          <div class="col-6">
                            <p>
                              {{ order.order_time_currency_shipping_price_1 }}
                            </p>
                          </div>
                          <div class="col-6" v-if="order.coupon_amount">
                            <label for="input-live " class="form-label">{{
                              this.$t("form.orders.discount.label")
                            }}</label>
                          </div>
                          <div class="col-6" v-if="order.coupon_amount">
                            <p>
                              {{
                                order.order_time_currency_display_coupon_amount
                              }}
                            </p>
                          </div>
                          <div class="col-6">
                            <label for="input-live " class="form-label">{{
                              this.$t("form.orders.display_total.label")
                            }}</label>
                          </div>
                          <div class="col-6">
                            <p>
                              {{ order.order_time_currency_display_total }}
                            </p>
                          </div>
                        </div>
                        <div class="mt-5" v-if="allSettings.general_settings.is_multi_vendor == '0'">

                          <div role="group">
                            <label for="input-live" class="form-label"
                              >{{ $t("form.order.set_status.label") }}</label
                            >
                            <span
                              class="float-end text-danger"
                              v-if="error && error['order_status_id']"
                            >
                              {{ error.order_status_id[0] }}
                            </span>
                            <AdminSearchSelectable
                              :class="
                                error && error.order_status_id ? 'error' : ''
                              "
                              apiMethod="activeOrderStatuses"
                              responseKey="order_statuses"
                              :initialOptions="
                                allActiveOrderStatuses.order_statuses
                              "
                              :selectedOptions="selected_order_status"
                              :placeholder="
                                $t('form.order.set_status.placeholder')
                              "
                              v-model="formData.order_status_id"
                            />
                            <span class="heebo-light">
                              {{ $t("form.order.set_status.subheading") }}
                            </span>
                          </div>
                          <div
                            role="group "
                            v-if="
                              formData.order_status_id == 9 ||
                              formData.order_status_id == 13
                            "
                          >
                            <label for="input-live" class="form-label"
                              >{{
                                $t("form.order.order_status_reason.label")
                              }}:</label
                            >
                            <span
                              class="float-end text-danger"
                              v-if="error && error['order_status_reason']"
                            >
                              {{ error.order_status_reason[0] }}
                            </span>
                            <input
                              :class="
                                error && error.order_status_reason
                                  ? 'error'
                                  : ''
                              "
                              class="form-control"
                              type="text"
                              v-model="formData.order_status_reason"
                              aria-describedby="input-live-help input-live-feedback"
                              :placeholder="
                                this.$t(
                                  'form.order.order_status_reason.placeholder'
                                )
                              "
                              trim
                            />
                            <span class="heebo-light">
                              {{
                                $t("form.order.order_status_reason.subheading")
                              }}
                            </span>
                          </div>
                            <div
                          class="
                            row
                            justify-content-end
                            border
                            shadow-sm
                            p-3
                            rounded
                          "
                          v-if="order.rider && order.rider != null"
                        >
                          <h2 class="my-4">{{
                              this.$t("rider_details")
                            }}</h2>
                          <div class="col-6">
                            <label for="input-live " class="form-label">{{
                              this.$t("form.orders.rider.name")
                            }}</label>
                          </div>
                          <div class="col-6">
                            <p>
                              {{
                                order.rider.name
                              }}
                            </p>
                          </div>
                          <div class="col-6">
                            <label for="input-live " class="form-label">{{
                              this.$t(
                                "form.orders.rider.email"
                              )
                            }}</label>
                          </div>
                          <div class="col-6">
                            <p>
                              {{order.rider.email }}
                            </p>
                          </div>
                          <div class="col-6" v-if="order.coupon_amount">
                            <label for="input-live " class="form-label">{{
                              this.$t("form.orders.rider.order_status")
                            }}</label>
                          </div>
                          <div class="col-6" >
                            <p>
                              {{
                                order.order_status.name
                              }}
                            </p>
                          </div>
                        </div>
                        </div>
                      </div>
                    </div>
                    <hr class="bg-primary">
                  </div>
                </div>
              </div>
              <div class="row" v-if="allSettings.general_settings.is_multi_vendor == '0'">
                <div class="col-md-12 px-4 text-center text-md-end mt-3">
                  <button
                    type="button"
                    class="btn btn-secondary mb-3 px-3 py-2"
                    @click="update"
                    name="button"
                  >
                    {{ this.$t("form.update") }}
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
</template>
<script >
import { mapGetters, mapActions } from "vuex";
export default {
  layout: "admin",
  middleware: ["admin", "permission"],
  meta: {
    permission: "orders.index",
    strategy: "read",
  },
  data() {
    return {
      url: "/backend",
      selected_order_status: "",
      formData: {
        id: "",
        order_status_id: "",
        order_status_reason: "",
      },
      order: "",
      error: false,
      changedStatusName: "",
    };
  },
  async fetch() {
    if (!this.allActiveOrderStatuses.order_statuses) {
      await this.fetchActiveOrderStatuses();
    }
    const { data } = await this.$repositories.orders.show(
      this.$route.params.id
    );
    this.order = data;
    this.formData.order_status_id = data.order_status.id;
    this.formData.order_status_reason = data.order_status_reason;
    this.selected_order_status = data.order_status;
  },
  methods: {
    ...mapActions({
      fetchActiveOrderStatuses: "General/fetchActiveOrderStatuses",
    }),
    async update() {
      this.formData.id = this.$route.params.id;
      await this.$generalService
        .changeOrderStatus(this.formData)
        .then((res) => {
          // some error occur
          if (res.status == false) {
            // this.error = res.errors ?? res;
            this.$toast.error(res.message);
          } else {
            this.error = false;
            this.changedStatusName = res.changes_status_name.name;
            this.sendPushNotification();
            if (this.formData.order_status_id == "4") {
              this.sendPushNotificationToRiders();
            }
            this.$toast.success(res.message);

            this.$router.replace(this.localePath("/admin/orders"));
          }
        })
        .catch((e) => {});
    },
    async sendPushNotification() {
      var apiData = {
        user_id: this.order.customer.id,
        user_type: "customer",
        title: "Order Status",
        body: "Your Order Has been " + this.changedStatusName,
      };
      const { data } = await this.$generalService.sendPushNotification(apiData);
    },
    async sendPushNotificationToRiders() {
      var apiData = {
        user_id: null,
        user_type: "rider",
        title: "New Order",
        body: "You have got a New Order",
      };
      const { data } = await this.$generalService.sendPushNotification(apiData);
    },
  },

  computed: {
    ...mapGetters({
      allActiveOrderStatuses: "General/allActiveOrderStatuses",
      allSettings: "allDefaultSettings",
    }),
  },
  mounted() {
  },
};
</script>
<style>
.accordion-button {
    padding: unset !important;
}
</style>

