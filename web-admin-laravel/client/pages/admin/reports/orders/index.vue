<template>
  <div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="row g-0">
        <div class="col-sm-12 px-0">
          <h2 class="m-0 text-body bold">
            {{ this.$t("sidebar.order") }}
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
                {{ this.$t("sidebar.order") }}
              </li>
            </ol>
            <p class="text-body-secondary">
              {{ this.$t("order.report.index_description") }}
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
                  <select class="form-select custom-select" v-model="filterData.column">
                    <option value="">
                      {{ $t("table.select_column") }}
                    </option>
                    <option value="name">
                      {{ $t("columns.number") }}
                    </option>
                    <option value="sub_total">
                      {{ $t("columns.order_time_currency_display_sub_total") }}
                    </option>
                    <option value="shipping_price">
                      {{ $t("columns.shipping_amount") }}
                    </option>
                    <option value="coupon_amount">
                      {{ $t("columns.coupon_amount") }}
                    </option>
                    <option value="total">
                      {{ $t("columns.order_time_currency_display_total") }}
                    </option>
                  </select>
                  <div class="form-group position-relative custom-search-width">
                    <input
                      class="form-control"
                      v-model="filterData.search"
                      type="search"
                      :placeholder="this.$t('dataTables.Search')"
                      @keyup="removeIcon"
                    />
                    <div
                      v-bind:class="{
                        'd-none': hideIcon,
                      }"
                      class="position-absolute search-input-custom"
                    >
                      <fa :icon="['fas', 'search']" fixed-width class="" />
                    </div>
                  </div>
                </div>
                <div class="row g-0 input-group">
                  <div
                    class="col-md-5 col-lg-5 form-group position-relative"
                  ></div>
                </div>
              </div>
              <div class="col-lg-5 col-md-10 pt-md-3 pt-lg-0 ps-lg-0">
                <div class="d-flex flex-column flex-md-row just">
                  <div class="position-relative">
                    <datetime
                      format="yyyy-MM-dd"
                      :placeholder="this.$t('reports.customer.start_date')"
                      v-model="filterData.date_from"
                      input-class="form-control"
                      type="date"
                      class="me-4"
                      value-zone="local"
                    ></datetime>
                    <span
                      class="float-end text-danger"
                      v-if="error && errors.date_from"
                    >
                      {{ errors.date_from[0] }}
                    </span>
                  </div>
                  <div class="position-relative">
                    <datetime
                      format="yyyy-MM-dd"
                      :placeholder="this.$t('reports.customer.end_date')"
                      v-model="filterData.date_to"
                      input-class="form-control"
                      type="date"
                      class="me-4"
                      :min-datetime="filter_min_date"
                      value-zone="local"
                    ></datetime>
                    <span
                      class="float-end text-danger"
                      v-if="error && errors.date_to"
                    >
                      {{ errors.date_to[0] }}
                    </span>
                  </div>

                  <select class="form-select" v-model="filterData.status">
                    <option value="">
                      {{ $t("columns.select_status") }}
                    </option>
                    <option value="0">
                      {{ $t("columns.pending") }}
                    </option>
                    <option value="1">
                      {{ $t("columns.approved") }}
                    </option>
                    <option value="2">
                      {{ $t("columns.in_process") }}
                    </option>
                    <option value="3">
                      {{ $t("columns.ready_to_ship") }}
                    </option>
                    <option value="4">
                      {{ $t("columns.rider_accepted") }}
                    </option>
                    <option value="5">
                      {{ $t("columns.picked") }}
                    </option>
                    <option value="6">
                      {{ $t("columns.delivered") }}
                    </option>
                    <option value="7">
                      {{ $t("columns.completed") }}
                    </option>
                    <option value="20">
                      {{ $t("columns.rejected") }}
                    </option>
                    <option value="21">
                      {{ $t("columns.on_hold") }}
                    </option>
                    <option value="22">
                      {{ $t("columns.cancelled") }}
                    </option>
                    <option value="23">
                      {{ $t("columns.refunded") }}
                    </option>
                  </select>
                </div>
                <!-- <div class="col-md-4 col-lg-4 form-group position-relative">

                  </div>
                  &nbsp;&nbsp;
                  <div class="form-group position-relative col-md-4 col-lg-4">

                  </div>
                  &nbsp;&nbsp;
                  <div class="col-md-2 col-lg-2 form-group position-relative w-30">

                  </div> -->
              </div>
              <div class="col-md-2 col-lg-2 col-xlg-2 table-actions px-0">
                <div slot="table-actions" class="align-middle">
                  <div class="share" v-if="rows.length > 0">
                    <nav>
                      <span @click="exportOrders('csv')">
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

                      <span @click="exportOrders('xlsx')">
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

                      <span @click="exportOrders('pdf')">
                        <nuxt-link
                          to="#"
                          v-tooltip="{
                            content: 'Export PDF File',
                          }"
                        >
                          <img
                            src="~/assets/images/pdf.png"
                            alt=""
                            height="20px"
                            width="20px"
                          />
                        </nuxt-link>
                      </span>

                      <nuxt-link
                        to="#"
                        v-tooltip="{
                          content: 'Export File',
                        }"
                      >
                        <fa :icon="['fas', 'arrow-down']" fixed-width />
                      </nuxt-link>
                    </nav>
                  </div>
                </div>
              </div>
            </div>
            <!--Filters of second row starts--->
            <div class="row table-filter-row g-0 justify-content-end">
              <!-- Small boxes (Stat box) -->
              <div class="col-md-4 col-lg-12 mt-3">
                <div class="row g-0 input-group">
                  <div class="col-md-2 col-lg-2 form-group position-relative ms-0">
                    <button
                      data-v-cba73d34=""
                      type="button"
                      name="button"
                      class="btn btn-primary px-3 py-2 z-index-1"
                      @click="getReports"
                    >
                      {{$t('apply')}}
                    </button>
                  </div>
                  <!-- <div class="report-vl"></div> -->
                  <div
                    class="form-group position-relative"
                  ></div>
                </div>
              </div>
              <div class="col-md-6 col-lg-6">
                <div class="row g-0 input-group justify-content-center"></div>
              </div>
              <div class="col-md-2 col-lg-2 col-xlg-2 table-actions px-0"></div>
            </div>
            <!--Filters of second row ends--->
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
                        :checked="props.row.is_active == 1 ? 'checked' : ''"
                        type="checkbox"
                        disabled="disabled"
                        id="flexSwitchCheckChecked"
                      />
                      <!-- <label class="form-check-label" for="flexSwitchCheckChecked">Checked switch checkbox input</label> -->
                    </div>
                  </div>
                  <div v-else-if="props.column.field == 'is_feature'">
                    <div class="form-switch">
                      <input
                        class="form-check-input"
                        disabled
                        :checked="props.row.is_feature == 1 ? 'checked' : ''"
                        type="checkbox"
                        id="flexSwitchCheckChecked"
                      />
                      <!-- <label class="form-check-label" for="flexSwitchCheckChecked">Checked switch checkbox input</label> -->
                    </div>
                  </div>
                  <div v-else-if="props.column.field == 'product_type'">
                    <span v-if="props.row.product_type == 1">
                      {{ $t("form.product.product_type.simple") }}
                    </span>
                    <span v-else-if="props.row.product_type == 2">
                      {{ $t("form.product.product_type.variable") }}
                    </span>
                    <span v-else-if="props.row.product_type == 3">
                      {{ $t("form.product.product_type.external") }}
                    </span>
                    <span v-else-if="props.row.product_type == 4">
                      {{ $t("form.product.product_type.digital") }}
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
<script>
import datatableMixin from "~/mixins/datatableMixin.js";
export default {
  layout: "admin",
  middleware: ["admin", "permission"],
  meta: {
    permission: "reports.index",
    strategy: "read",
  },
  mixins: [datatableMixin],
  data() {
    return {
      error: false,
      errors: "",
      loading: false,
      filter_min_date: "",
      allOrderReports: "",
      columns: [
        {
          label: this.$t("columns.number"),
          field: "number",
          sortable: false,
        },
        {
          label: this.$t("columns.customer_name"),
          field: "customer.first_name",
          sortable: false,
        },
        {
          label: this.$t("columns.order_status"),
          field: "order_status.name",
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
          label: this.$t("columns.shipping_amount"),
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
      ],
    };
  },
  async fetch() {},
  methods: {
    async exportOrders(type) {
      this.filterData.export = type;
      //   await this.$repositories.sales.export(this.filterData);
      await this.$generalService.orderExport(this.filterData);
    },
    async filter() {
      this.getReports();
    },
    async getReports() {
      this.loading = true;
      this.error = false;
      this.errors = "";
      //   this.filterData.perPage = 10;
      const data = await this.$generalService.getOrderReports(this.filterData);

      if (data.success) {
        this.loading = false;
        this.rows = data.data.data;
        this.allOrderReports = data.data;
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
    allOrderReports(newCount, oldCount) {
      if (
        this.allOrderReports &&
        this.allOrderReports != null &&
        this.allOrderReports.data != null
      ) {
        this.rows = this.allOrderReports.data;
        this.totalRows = this.allOrderReports.meta.total;
        if (this.filterData.page != this.allOrderReports.meta.current_page) {
          this.filterData.page = this.allOrderReports.meta.current_page;
        }
        if (this.filterData.perPage != this.allOrderReports.meta.per_page) {
          this.filterData.perPage = this.allOrderReports.meta.per_page;
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
