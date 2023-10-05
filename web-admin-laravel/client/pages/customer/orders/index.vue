<template>
  <section class="order-detail m-0" v-if="$fetchState.pending">
    <WebsiteGlobalComponentsBreadCrumb :page="`My Orders`" />
    <Component :is="`WebsiteSkeleton${currentlyActiveTemplate}OrdersPage`" />
  </section>
  <section v-else class="order-detail m-0">
    <WebsiteGlobalComponentsBreadCrumb :page="`My Orders`" />
    <div
      class="container"
      v-if="
        orders.data.length == 0 &&
        pagination.status == '' &&
        pagination.date == '' &&
        pagination.search == ''
      "
    >
      <Component :is="`Website${currentlyActiveTemplate}OrderEmpty`" />
    </div>
    <div v-else class="container">
      <div class="row">
        <div class="col-12">
          <div class="filter-bar mb-4 rounded px-4 mt-5 bg-secondary mt-100 mb-50">
            <div class="row">
              <div class="col-xl-3 col-lg-4 col-md-2 col-12">
                <div class="d-flex align-items-center h-100">
                  <div
                    class="
                      page-items
                      text_size text-uppercase
                      fw-bold
                      mb-md-0 mb-3
                    "
                  >
                {{this.$t('web.customer.orders.filter.show.first')}} <span>{{ orders.data.length }}</span> {{this.$t('web.customer.orders.filter.show.second')}}
                    <span>{{ orders.meta.total }}</span>
                  </div>
                </div>
              </div>
              <div class="col-xl-8 col-lg-8 col-md-10 col-12">
                <div class="row">
                  <div class="col-lg-6 col-md-5">
                    <!-- <div
                      class="
                        dropdown-fild
                        d-flex
                        align-items-center
                        categories-dropdown
                        me-md-4
                        mb-md-0 mb-2
                        flex-column flex-md-row
                      "
                    >
                      <label
                        class="
                          form-label
                          label_text
                          flex-shrink-0
                          text_size
                          mb-0
                          me-3
                          text-muted
                        "
                        >{{this.$t('web.customer.orders.filter.status')}}:
                      </label>
                      <div class="d-flex align-items-center w-100">
                        <select
                          v-model="pagination.status"
                          class="form-select orderSelectList"
                        >
                          <option selected value="">{{this.$t('web.customer.orders.filter.all')}}</option>
                          <option value="0">{{this.$t('web.customer.orders.filter.pending')}}</option>
                          <option value="2">{{this.$t('web.customer.orders.filter.in_process')}}</option>
                          <option value="6">{{this.$t('web.customer.orders.filter.delivered')}}</option>
                          <option value="7">{{this.$t('web.customer.orders.filter.completed')}}</option>
                          <option value="20">{{this.$t('web.customer.orders.filter.rejected')}}</option>
                        </select>
                        <fa
                          class="caretDown"
                          :icon="['fas', 'caret-down']"
                          fixed-width
                        />
                      </div>
                    </div> -->
                  </div>
                  <div class="col-lg-6 col-md-7">
                    <div
                      class="
                        dropdown-fild
                        d-flex
                        flex-column flex-md-row
                        align-items-center
                        sort-by-dropdown
                      "
                    >
                      <label
                        class="
                          form-label
                          label_text
                          flex-shrink-0
                          text_size
                          mb-0
                          me-md-0 me-2
                          text-muted
                        "
                        >{{this.$t('web.customer.orders.filter.date')}}:
                      </label>
                      <div class="d-flex align-items-center w-100 mb-3 mb-md-0">
                        <fa
                          :icon="['fas', 'calendar-alt']"
                          fixed-width
                          text-secondary
                          class="calenderIcon"
                        />
                        <datetime
                          class="dateTimePicker"
                          placeholder="Select Date"
                          input-class="form-control"
                          type="date"
                          use12-hour
                          format="dd-MM-yyyy"
                          v-model="pagination.date"
                          value-zone="local"
                        ></datetime>
                        <fa
                          class="caretDown"
                          :icon="['fas', 'caret-down']"
                          fixed-width
                        />
                      </div>
                      <div
                        class="col-md-6 d-flex justify-content-md-end pe-4"
                        v-on:click="resetFilter"
                      >
                        <a
                          href="javascript:void(0)"
                          class="text-primary fw-bold px-2 px-md-3"
                        >
                          {{this.$t('web.customer.orders.filter.reset_filter')}}
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div>
          <div class="p-0 shadow border">
            <div class="table-responsive bg-secondary mb-0 mx-0 border-bottom"
              v-for="order in orders.data"
              :key="order.id">
              <div class="row w-100 mx-0">
                <table class="table m-0 py-1">
                  <tr class="d-block py-2 px-3">
                    <td>
                         <span class="text-primary fw-bold text_size"
                          >{{$t('web.customer.orders.filter.order')}}: {{ order.number }}
                        </span>
                        <span class="text-primary fw-bold text_size"
                          >{{ order.created_at }}
                        </span>
                    </td>
                    <td>
                      <div
                        class="
                          d-flex
                          justify-content-center
                          align-items-center
                          h-100
                        "
                      >
                        <span class="text-muted fw-bold letter_spacing" v-if="order.is_paid"
                          >  {{ $t("is_paid") }}
                        </span>
                        <span class="text-muted fw-bold letter_spacing" v-else
                          > {{ $t("is_not_paid") }}
                        </span>
                      </div>
                    </td>
                    <td>
                      <div
                        class="
                          d-flex
                          justify-content-center
                          align-items-center
                          h-100
                        "
                      >
                        <span class="text-primary fw-bold letter_spacing">
                          {{ order.order_time_currency_display_total }}
                        </span>
                      </div>
                    </td>
                    <td v-if="allSettings.general_settings.is_multi_vendor == 1">
                      <div
                        class="
                          d-flex
                          justify-content-end
                          align-items-center
                          h-100
                        "
                      >
                        <span class="text-primary fw-bold letter_spacing">
                            <span v-if="order.payment_method == 'cash_on_delivery' ">
                               Cash on Delivery
                            </span>
                            <span v-if="order.payment_method == 'paypal' ">
                               Paypal
                            </span>
                            <span v-if="order.payment_method == 'stripe' ">
                               Stripe
                            </span>
                            <span v-if="order.payment_method == 'braintree' ">
                               Braintree
                            </span>
                             <span v-if="order.payment_method == 'paytm' ">
                               Paytm
                            </span>
                             <span v-if="order.payment_method == 'payment_wallet' ">
                               Through Wallet
                            </span>
                             <span v-if="order.payment_method == 'razorpay' ">
                               Razorpay
                            </span>
                             <span v-if="order.payment_method == 'flutterwave' ">
                               Flutterwave
                            </span>
                             <span v-if="order.payment_method == 'paystack' ">
                               Paystack
                            </span>
                        </span>
                      </div>
                    </td>
                    <td v-else>
                         <div
                        class="
                          d-flex
                          justify-content-center
                          align-items-center
                          h-100
                        "
                      >
                        <span class="text-primary fw-bold letter_spacing">
                          {{ order.order_status.name }}
                        </span>
                      </div>
                    </td>
                    <td>
                      <nuxt-link
                        :to="`/customer/orders/${order.id}`"
                        class="text-primary fw-bold"
                      >
                       {{$t('web.customer.orders.filter.view_details')}}
                      </nuxt-link>
                    </td>
                  </tr>
                </table>
              </div>
            </div>
            <div slot="emptystate" v-if="orders.data.length == 0">
              <div class="wallet-history">
                <div class="empty-wallet d-flex flex-column pt-0">
                  <p class="mx-auto mb-0">{{this.$t('web.customer.orders.order_empty_message')}}</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- <div class="col-12 mt-5 d-flex justify-content-center">
          <AdminLoader v-if="loading_more" />
          <button
            type="button"
            name="button"
            class="btn btn-primary py-2 px-4"
            @click="loadmore"
            v-if="orders.meta.current_page != orders.meta.last_page"
          >
            {{ $t("load_more") }}
          </button>
        </div> -->

        <div class="col-12 mt-50 mb-50">
          <div
            class="
              d-md-flex
              justify-content-between
              align-items-center
              filter-bar
              rounded
              px-0 py-0
              bg-white
            "
          >
            <WebsiteGlobalComponentsPaginationBar
              :orders="orders"
              @updateFilter="updateFilter"
              class="mt-5"
            />
          </div>
        </div>
      </div>
    </div>

    <WebsiteTemplate1NewsLetterSection />
  </section>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
export default {
  middleware: "customer",
  data() {
    return {
      currentlyActiveTemplate: "",
      url: "/backend",
      loading_more: false,
      searching: false,
      pagination: {
        status: "",
        date: "",
        page: 1,
        column: "",
        search: "",
        perPage: 10,
        sort: {
          type: "",
          field: "",
        },
      },
      orders: [],
      key: 1,
      detail: "",
      seo: {},
    };
  },
  created() {
    this.currentlyActiveTemplate =
      this.allSettings.general_settings.currently_active_theme;
  },
  head() {
    return this.seo;
  },
  async fetch() {
    const { data } = await this.$webService.customerOrders(this.pagination);
    if (data) {
      this.orders = data;
      this.pagination.perPage = this.orders.meta.per_page;
    }
  },

  methods: {
    async loadmore() {
      this.loading_more = true;
      this.pagination.page += 1;
      const { data } = await this.$webService.customerOrders(this.pagination);
      this.orders.data = this.orders.data.concat(data.data);

      this.orders.meta = data.meta;
      this.orders.links = data.links;
      this.loading_more = false;
    },
    async onSearch() {
      this.searching = true;
      this.pagination.page = 1;
      const { data } = await this.$webService.customerOrders(this.pagination);
      this.orders.data = data.data;
      this.orders.meta = data.meta;
      this.orders.links = data.links;
      this.searching = false;
    },
    async onOrderChange() {
      this.searching = true;
      this.pagination.page = 1;
      const { data } = await this.$webService.customerOrders(this.pagination);
      this.searching = false;
      this.orders = data;
    },
    async onPerPageChange() {
      this.searching = true;
      this.pagination.page = 1;
      const { data } = await this.$webService.customerOrders(this.pagination);
      this.orders.data = data.data;
      this.orders.meta = data.meta;
      this.orders.links = data.links;
      this.searching = false;
    },
    updateFilter(value) {
      this.pagination.page = value;
    },
    resetFilter() {
      this.pagination.status = "";
      this.pagination.date = "";
      this.pagination.page = 1;
      this.pagination.column = "";
      this.pagination.search = "";
      this.pagination.perPage = 10;
      this.pagination.sort.type = "";
      this.pagination.sort.field = "";
      this.$fetch();
    },
  },
  computed: {
    ...mapGetters({
      allSettings: "allDefaultSettings",
    }),
  },
  watch: {
    pagination: {
      handler(val) {
        this.$fetch();
      },
      deep: true,
    },
  },
};
</script>

<style>
</style>
