<template >
  <div class="" v-if="!this.$auth.user.store">
    <SellerShopSettings />
  </div>
  <div class="" v-else-if="!this.$auth.user.is_active">
    <SellerShopDeactive />
  </div>
  <div v-else>
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="row g-0">
        <div class="col-sm-12 px-0">
          <h2 class="m-0 text-body bold">
            {{ this.$t("sidebar.reports.sale") }}
          </h2>
        </div>
        <!-- /.col -->
        <div class="row">
          <div class="col-sm-12 px-0">
            <ol class="breadcrumb float-sm-right text-body">
              <li class="breadcrumb-item">
                <a href="#">{{ this.$t("sidebar.home") }}</a>
              </li>
              <li class="breadcrumb-item active">
                {{ this.$t("sidebar.reports.sale") }}
              </li>
            </ol>
            <p class="text-body-secondary">
              {{ this.$t("reports.sale.index_description") }}
            </p>
          </div>
          <!-- /.col -->
        </div>
      </div>
      <!-- /.row -->
    </div>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="card gutter-b bsale-0">
          <div class="card-header p-0">
            <div class="row table-filter-row g-0">
              <!-- Small boxes (Stat box) -->
              <div class="col-lg-5 col-md-12">
                 <div class="d-flex flex-column flex-md-row">
                    <select class="form-select form-width" v-model="filterData.column">
                      <option value="" disabled>{{ $t("table.select_column") }}</option>
                      <option value="order_number">
                        {{ $t("columns.number") }}
                      </option>
                      <option value="payment_method_id">
                        {{ $t("columns.payment_method") }}
                      </option>
                      <option value="sub_total">
                        {{
                          $t("columns.order_time_currency_display_sub_total")
                        }}
                      </option>
                      <option value="shipping_price">
                        {{
                          $t(
                            "columns.order_time_currency_display_shipping_price"
                          )
                        }}
                      </option>
                      <option value="coupon_amount">
                        {{ $t("columns.coupon_amount") }}
                      </option>
                      <option value="total">
                        {{ $t("columns.order_time_currency_display_total") }}
                      </option>
                    </select>
                    <div class="form-group position-relative">
                        <input
                        class="form-control"
                        v-model="filterData.search"
                        type="search"
                        :placeholder="this.$t('dataTables.Search')"
                        @keyup="removeIcon"
                        />
                        <div v-bind:class="{ 'd-none': hideIcon }" class="position-absolute search-input-custom">
                        <fa :icon="['fas', 'search']" fixed-width class="" />
                        </div>
                    </div>
                 </div>
              </div>
              <div class="col-lg-7 col-md-12 mt-md-3 mt-lg-0 d-flex flex-column flex-md-row">
                <div class="col-lg-9">
                    <div class="d-flex flex-column flex-md-row">
                        <div class="position-relative form-width ps-0 ps-md-4">
                            <datetime
                            format="yyyy-MM-dd"
                            :placeholder="this.$t('reports.sale.start_date')"
                            v-model="filterData.date_from"
                            input-class="form-control"
                            type="date"
                            value-zone="local"
                            ></datetime>
                            <span
                            class="float-end text-danger"
                            v-if="error && errors.date_from"
                            >
                            {{ errors.date_from[0] }}
                            </span>
                        </div>
                        <div class="position-relative form-width">
                            <datetime
                            format="yyyy-MM-dd"
                            :placeholder="this.$t('reports.sale.end_date')"
                            v-model="filterData.date_to"
                            input-class="form-control"
                            type="date"
                            value-zone="local"
                                :min-datetime="filter_min_date"
                            ></datetime>
                            <span
                            class="float-end text-danger"
                            v-if="error && errors.date_to"
                            >
                            {{ errors.date_to[0] }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-xlg-2 table-actions px-0">
                <div slot="table-actions" class="align-middle">
                  <div class="share" v-if="rows.length > 0">
                    <nav>
                      <span @click="exportSellerSales('csv')">
                        <!-- <nuxt-link
                          to="#"
                          v-tooltip="{ content: 'Export CSV File' }"
                        >
                          <img
                            src="~/assets/images/csv.png"
                            alt=""
                            height="20px"
                            width="20px"
                          />
                        </nuxt-link> -->
                      </span>

                      <span @click="exportSellerSales('xlsx')">
                        <!-- <nuxt-link
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
                        </nuxt-link> -->
                      </span>

                      <span @click="exportSellerSales('pdf')">
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
                </div>
                </div>
              </div>

              <div class="col-lg-12 mt-3">
                <div class="position-relative">
                    <button
                      data-v-cba73d34=""
                      type="button"
                      name="button"
                      class="btn btn-primary px-3 py-2"
                      @click="getReports"
                    >
                      {{$t('apply')}}
                    </button>
                  </div>
              </div>
            </div>
            <!-- <div class="row table-filter-row g-0 justify-content-end">

              <div class="col-md-6 col-lg-7">

              </div>
              <div class="col-md-6 col-lg-5 col-xlg-6 table-actions px-0">
                <div slot="table-actions" class="align-middle"></div>
              </div>
            </div> -->
          </div>
          <div class="card-body mt-2 data-tables-div py-0 m-0 rounded-md">
            <div v-if="loading">
              <AdminTableLoader />
            </div>
            <div class="col-md-12" v-else>
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
                          (event) => changeSaleStatus(props.row.id, event)
                        "
                        :checked="props.row.is_active == 1 ? 'checked' : ''"
                        type="checkbox"
                        id="flexSwitchCheckChecked"
                      />
                      <!-- <label class="form-check-label" for="flexSwitchCheckChecked">Checked switch checkbox input</label> -->
                    </div>
                  </div>
                   <div v-else-if="props.column.field == 'payment_method'">
                    <span v-if="props.row.payment_method == 'payment_wallet'">
                      {{ $t("payment.wallet") }}
                    </span>
                    <span
                      v-else-if="props.row.payment_method == 'cash_on_delivery'"
                    >
                      {{ $t("payment.cash_on_delivery") }}
                    </span>
                    <span v-else-if="props.row.payment_method == 'stripe'">
                      {{ $t("payment.stripe") }}
                    </span>
                    <span v-else-if="props.row.payment_method == 'braintree'">
                      {{ $t("payment.braintree") }}
                    </span>
                     <span v-else-if="props.row.payment_method == 'razorpay'">
                      {{ $t("payment.razorpay") }}
                    </span>
                    <span v-else-if="props.row.payment_method == 'flutterwave'">
                      {{ $t("payment.flutterwave") }}
                    </span>
                    <span v-else-if="props.row.payment_method == 'paypal'">
                      {{ $t("payment.paypal") }}
                    </span>
                    <span v-else-if="props.row.payment_method == 'paytm'">
                      {{ $t("payment.paytm") }}
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
import datatableMixin from "~/mixins/datatableMixin.js";
export default {
  layout: "vendor",
  middleware: ["vendor"],
  meta: {
    strategy: "read",
  },
  mixins: [datatableMixin],
  data() {
    return {
      error: false,
      errors: "",
      loading: false,
      allSaleReports: '',
       filter_min_date: "",
      columns: [
        {
          label: this.$t("columns.number"),
          field: "number",
          sortable: false,
        },
        {
          label: this.$t("columns.payment_method"),
          field: "payment_method",
          sortable: false,
        },
        {
          label: this.$t("columns.order_time_currency_display_sub_total"),
          field: "sub_total",
          sortable: false,
        },
        {
          label: this.$t("columns.order_time_currency_display_shipping_price"),
          field: "shipping_price",
          sortable: false,
        },
        {
          label: this.$t("columns.coupon_amount"),
          field: "coupon_amount",
          sortable: false,
        },
        {
          label: this.$t("columns.order_time_currency_display_total"),
          field: "total",
          sortable: false,
        },

        // {
        //   label: this.$t("columns.created_at"),
        //   field: "created_at",
        //   sortable: false,
        //   // type: 'date',
        //   // dateInputFormat: 'Y-M-d',
        //   // dateOutputFormat: 'MMM do yy',
        // },
        // {
        //   label: this.$t("columns.actions"),
        //   field: "actions",
        //   sortable: false,
        // },
      ],
    };
  },
  async fetch() {},
  methods: {
    async exportSellerSales(type) {
      this.filterData.export = type;
      await this.$generalService.saleSellerExport(this.filterData);
    },
    async filter() {
      this.getReports();
    },
    async getReports() {
      this.loading = true;
      this.error = false;
      this.errors = "";
      const data = await this.$generalService.getSellerSaleReports(this.filterData);
      if (data.success) {
        this.loading = false;
        this.rows = data.data.data;
        this.allSaleReports = data.data;
      } else {
        this.loading = false;
        this.error = true;
        this.errors = data.errors;
        this.$toast.error(data.message);
      }
    },
  },

  mounted() {},
  watch: {
    allSaleReports(newCount, oldCount) {
      if (
        this.allSaleReports &&
        this.allSaleReports != null &&
        this.allSaleReports.data != null
      ) {
        this.rows = this.allSaleReports.data;
        this.totalRows = this.allSaleReports.meta.total;
        if (this.filterData.page != this.allSaleReports.meta.current_page) {
          this.filterData.page = this.allSaleReports.meta.current_page;
        }
        if (this.filterData.perPage != this.allSaleReports.meta.per_page) {
          this.filterData.perPage = this.allSaleReports.meta.per_page;
        }
      }
    },
    "filterData.date_from"(newCount, oldCount) {
      var min_date = new Date(newCount).toISOString();
      this.filter_min_date = min_date;
    },
  },
};
</script>
