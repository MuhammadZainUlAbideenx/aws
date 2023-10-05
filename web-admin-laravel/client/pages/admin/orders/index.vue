<template >
  <div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="row g-0">
        <div class="col-sm-12 px-0">
          <h2 class="m-0 text-body bold">{{ this.$t("sidebar.order") }}</h2>
        </div>
        <!-- /.col -->
        <div class="row">
          <div class="col-sm-12 px-0">
            <ol class="breadcrumb float-sm-right text-body">
              <li class="breadcrumb-item">
                <a href="#">{{ this.$t("sidebar.home") }}</a>
              </li>
              <li class="breadcrumb-item active">
                {{ this.$t("sidebar.order") }}
              </li>
            </ol>
            <p class="text-body-secondary">
              {{ this.$t("order.index_description") }}
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
        <AdminTableLoader />
      </div>
      <div class="container-fluid" v-else>
        <div class="card gutter-b border-0">
          <div class="card-header p-0">
            <div class="row table-filter-row g-0">
              <!-- Small boxes (Stat box) -->
              <div class="col-lg-8">
                 <div class="d-flex flex-column flex-md-row">
                    <select class="form-select custom-select" v-model="filterData.column">
                      <option value="" disabled>{{ $t("table.select_column") }}</option>
                      <option value="order_number">
                        {{ $t("columns.number") }}
                      </option>
                    </select>
                      <div class="form-group position-relative col-md-8 col-lg-5">
                    <input
                      class="form-control"
                      v-model="filterData.search"
                      @change="filter"
                      type="search"
                      :placeholder="this.$t('dataTables.Search')"
                      @keyup="removeIcon"
                    />
                    <div  v-bind:class="{ 'd-none': hideIcon }" class="position-absolute search-input-custom">
                      <fa :icon="['fas', 'search']" fixed-width class="" />
                    </div>
                  </div>
                 </div>

              </div>
              <div class="col-lg-4 table-actions px-0">
                <div slot="table-actions" class="align-middle">
                  <div class="share">
                    <nav>
                      <span @click="exportOrders('csv')">
                        <nuxt-link
                          to="#"
                          v-tooltip="{ content: 'Export CSV File' }"
                        >
                          <img
                            src="~/assets/images/csv.png"
                            alt=""
                            height="20px"
                            width="20px"
                          />
                        </nuxt-link>
                      </span>

                      <span @click="exportOrders('xlsx')">
                        <nuxt-link
                          to="#"
                          v-tooltip="{ content: 'Export Excel File' }"
                          data-bs-toggle="tooltip"
                          data-bs-placement="top"
                          title="Tooltip on top"
                        >
                          <img
                            src="~/assets/images/excel.png"
                            alt=""
                            height="20px"
                            width="20px"
                          />
                        </nuxt-link>
                      </span>

                      <span @click="exportOrders('pdf')">
                        <nuxt-link
                          to="#"
                          v-tooltip="{ content: 'Export PDF File' }"
                        >
                          <img
                            src="~/assets/images/pdf.png"
                            alt=""
                            height="20px"
                            width="20px"
                          />
                        </nuxt-link>
                      </span>

                      <nuxt-link to="#" v-tooltip="{ content: 'Export File' }">
                        <fa :icon="['fas', 'arrow-down']" fixed-width />
                      </nuxt-link>
                    </nav>
                  </div>
                  <!--  <nuxt-link
                    v-permission="'orders.create'"
                    :to="localePath('/admin/orders/create')"
                  >
                    <button
                      type="button"
                      v-tooltip="{ content: 'Add Order' }"
                      class="btn add px-3 rounded-circle"
                      name="button"
                    >
                      <fa :icon="['fas', 'plus']" fixed-width />
                    </button>
                  </nuxt-link> -->
                </div>
              </div>
            </div>
          </div>
          <div class="card-body mt-2 data-tables-div py-0 m-0 rounded-md">
            <div class="col-md-12">
              <vue-good-table
                v-if="!$fetchState.pending"
                mode="remote"
                :columns="columns"
                :rows="rows"
                :totalRows="totalRows"
                @on-page-change="onPageChange"
                @on-sort-change="onSortChange"
                @on-per-page-change="onPerPageChange"
                :line-numbers="true"
                :pagination-options="{
                  mode: 'pages',
                  enabled: true,
                  perPage: filterData.perPage,
                  setCurrentPage: filterData.page,
                  nextLabel: pagination.nextLabel,
                  prevLabel: pagination.prevLabel,
                  rowsPerPageLabel: pagination.rowsPerPageLabel,
                  ofLabel: pagination.ofLabel,
                  pageLabel: pagination.pageLabel, // for 'pages' mode
                  allLabel: pagination.allLabel,
                }"
                styleClass="vgt-table striped"
                row-style-class="m-5"
              >
                <template slot="table-row" slot-scope="props">
                  <div v-if="props.column.field == 'is_active'">
                    <div class="form-switch">
                      <input
                        class="form-check-input"
                        @change="
                          (event) => changeOrderStatus(props.row.id, event)
                        "
                        :checked="props.row.is_active == 1 ? 'checked' : ''"
                        type="checkbox"
                        id="flexSwitchCheckChecked"
                      />
                    </div>
                  </div>
                  <div v-else-if="props.column.field == 'actions'">
                    <nuxt-link
                      v-permission="'orders.index'"
                      v-tooltip="{ content: 'Show' }"
                      class="btn btn-sm rounded-circle text-primary"
                      :to="localePath('/admin/orders/view/' + props.row.id)"
                    >
                      <fa :icon="['fas', 'eye']" fixed-width
                    /></nuxt-link>

                    <!-- <nuxt-link
                      v-permission="'orders.update'"
                      v-tooltip="{ content: 'Edit' }"
                      class="btn btn-sm rounded-circle text-success"
                      :to="localePath('/admin/orders/edit/' + props.row.id)"
                    >
                      <fa :icon="['fas', 'edit']" fixed-width />
                    </nuxt-link> -->

                    <!-- <button
                      v-permission="'orders.delete'"
                      type="button"
                      v-tooltip="{ content: 'Delete' }"
                      class="btn btn-sm rounded-circle text-danger"
                      name="button"
                      data-bs-toggle="modal"
                      :data-bs-target="'#DeleteItem' + props.row.id"
                    >
                      <fa :icon="['fas', 'trash-alt']" fixed-width />
                    </button> -->
                    <AdminDeleteModal
                      :modal_id="'DeleteItem' + props.row.id"
                      @deleteClicked="deleteOrder(props.row.id)"
                      :delete_id="props.row.id"
                    >
                    </AdminDeleteModal>
                  </div>
                  <div v-else-if="props.column.field == 'is_paid'">
                    <span v-if="props.row.is_paid == 1">
                      {{ $t("is_paid") }}
                    </span>
                    <span v-else>
                      {{ $t("is_not_paid") }}
                    </span>
                  </div>
                  <div v-else-if="props.column.field == 'payment_method'">
                    <span v-if="props.row.payment_method == 'cash_on_delivery'">
                      {{ $t("payment.cash_on_delivery") }}
                    </span>
                    <span v-else-if="props.row.payment_method == 'payment_wallet'">
                      {{ $t("payment.wallet") }}
                    </span>
                    <span v-else-if="props.row.payment_method == 'stripe'">
                      {{ $t("payment.stripe") }}
                    </span>
                    <span v-else-if="props.row.payment_method == 'braintree'">
                      {{ $t("payment.braintree") }}
                    </span>
                    <span v-else-if="props.row.payment_method == 'paypal'">
                      {{ $t("payment.paypal") }}
                    </span>
                    <span v-else-if="props.row.payment_method == 'razorpay'">
                      {{ $t("payment.razorpay") }}
                    </span>
                    <span v-else-if="props.row.payment_method == 'flutterwave'">
                      {{ $t("payment.flutterwave") }}
                    </span>
                    <span v-else-if="props.row.payment_method == 'paytm'">
                      {{ $t("payment.paytm") }}
                    </span>
                     <span v-else-if="props.row.payment_method == 'paystack'">
                      {{ $t("payment.paystack") }}
                    </span>
                  </div>
                  <span v-else>
                    {{ props.formattedRow[props.column.field] }}
                  </span>
                </template>
                <div slot="emptystate">
                  {{ $t("table.table_empty_message") }}
                </div>
              </vue-good-table>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>
<script >
import { mapGetters, mapActions } from "vuex";
import datatableMixin from "~/mixins/datatableMixin.js";
export default {
  layout: "admin",
  middleware: ["admin", "permission"],
  meta: {
    permission: "orders.index",
    strategy: "read",
  },
  mixins: [datatableMixin],
  data() {
    return {
      columns: [
        {
          label: this.$t("columns.number"),
          field: "number",
          sortable: false,
        },
        {
          label: this.$t("columns.order_status"),
          field: "order_status.name",
          sortable: false,
        },
        {
          label: this.$t("columns.order_time_currency_display_total"),
          field: "total",
          sortable: false,
        },
        {
          label: this.$t("columns.is_paid"),
          field: "is_paid",
          sortable: false,
        },
        {
          label: this.$t("columns.payment_method"),
          field: "payment_method",
          sortable: false,
        },
        {
          label: this.$t("columns.status"),
          field: "is_active",
          sortable: false,
        },
        {
          label: this.$t("columns.created_at"),
          field: "created_at",
          sortable: false,
          // type: 'date',
          // dateInputFormat: 'Y-M-d',
          // dateOutputFormat: 'MMM do yy',
        },
        {
          label: this.$t("columns.actions"),
          field: "actions",
          sortable: false,
        },
      ],
    };
  },
  async fetch() {
    if (this.$gates.hasPermission("orders.index")) {
      await this.fetchOrders(this.page).then();
    }
  },
  methods: {
    ...mapActions({
      fetchOrders: "Orders/fetchOrders",
      fetchActiveOrders: "General/fetchActiveOrders",
      deleteOrders: "Orders/deleteOrders",
      filterOrders: "Orders/filterOrders",
      updateOrderStatus: "Orders/updateOrderStatus",
      updateOrderIsDefault: "Orders/updateOrderIsDefault",
    }),
    async exportOrders(type) {
      this.filterData.export = type;
      await this.$repositories.orders.export(this.filterData);
    },
    async deleteOrder(id) {
      await this.deleteOrders({
        filterData: this.filterData,
        order_id: id,
      })
        .then((response) => {
          if (response.state == "fail") {
            this.$toast.error(response.message);
          }
          if (response.state == "success") {
            this.$toast.success(response.message);
            this.fetchActiveOrders();
          }
        })
        .catch((e) => {});
    },
    async filter() {
      await this.filterOrders(this.filterData).then((response) => {
        if (response.state == "fail") {
          this.$toast.error(response.message);
        }
        if (response.state == "success") {
        }
      });
    },
    async changeDefaultOrder(id, event) {
      await this.updateOrderIsDefault({
        filterData: this.filterData,
        order_id: id,
      }).then((response) => {
        if (response.state == "fail") {
          this.$toast.error(response.message);
          event.target.checked = !event.target.checked;
        }
        if (response.state == "success") {
          this.$toast.success(response.message);
          this.fetchActiveOrders();
        }
      });
    },
    async changeOrderStatus(id, event) {
      await this.updateOrderStatus({
        filterData: this.filterData,
        order_id: id,
      })
        .then((response) => {
          if (response.state == "fail") {
            this.$toast.error(response.message);
            event.target.checked = !event.target.checked;
          }
          if (response.state == "success") {
            this.$toast.success(response.message);
            this.fetchActiveOrders();
          }
        })
        .catch((e) => {
          event.target.checked = !event.target.checked;
        });
    },

  },

  computed: {
    ...mapGetters({
      allOrders: "Orders/allOrders",
    }),
  },
  mounted() {},
  watch: {
    allOrders(newCount, oldCount) {
      if (
        this.allOrders &&
        this.allOrders != null &&
        this.allOrders.data != null
      ) {
        this.rows = this.allOrders.data;
        this.totalRows = this.allOrders.meta.total;
        if (this.filterData.page != this.allOrders.meta.current_page) {
          this.filterData.page = this.allOrders.meta.current_page;
        }
        if (this.filterData.perPage != this.allOrders.meta.per_page) {
          this.filterData.perPage = this.allOrders.meta.per_page;
        }
      }
    },
  },
};
</script>
