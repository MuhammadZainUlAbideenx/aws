<template >
  <div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="row g-0">
        <div class="col-sm-12 px-0">
          <h2 class="m-0 text-body bold">
            {{ this.$t("sidebar.reports.customer") }}
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
                {{ this.$t("sidebar.reports.customer") }}
              </li>
            </ol>
            <p class="text-body-secondary">
              {{ this.$t("reports.customer.index_description") }}
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
            <div class="row table-filter-row g-0 justify-content-end">
              <!-- Small boxes (Stat box) -->
              <div class="col-lg-5 col-md-12">
                 <div class="d-flex flex-column flex-md-row">
                    <select class="form-select custom-select" v-model="filterData.column">
                      <option value="" disabled>{{ $t("table.select_column") }}</option>
                      <option value="first_name">
                        {{ $t("form.customer.first_name.label") }}
                      </option>
                      <option value="last_name">
                        {{ $t("form.customer.last_name.label") }}
                      </option>
                      <option value="phone">
                        {{ $t("form.customer.phone.label") }}
                      </option>
                      <option value="email">
                        {{
                          $t("form.customer.email.label")
                        }}
                      </option>
                      <option value="gender">
                        {{
                          $t(
                            "form.customer.gender.label"
                          )
                        }}
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
                    <div v-bind:class="{ 'd-none': hideIcon }" class="position-absolute search-input-custom">
                      <fa :icon="['fas', 'search']" fixed-width class="" />
                    </div>
                  </div>
                 </div>

              </div>
              <div class="col-lg-5 col-md-10 pt-md-3 pt-lg-0">
                 <div class="d-flex flex-column flex-md-row">
 <div class="form-group position-relative ms-md-0 ms-lg-0">
                    <datetime
                      format="yyyy-MM-dd"
                      :placeholder="this.$t('reports.customer.start_date')"
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
                   <div class="form-group position-relative">
                    <datetime
                      format="yyyy-MM-dd"
                      :placeholder="this.$t('reports.customer.end_date')"
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
              <div class="col-md-2 col-lg-2 col-xlg-2 table-actions px-0">
                <div slot="table-actions" class="align-middle">
                  <div class="share" v-if="rows.length > 0">
                    <nav>
                      <span @click="exportCustomers('csv')">
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

                      <span @click="exportCustomers('xlsx')">
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

                      <span @click="exportCustomers('pdf')">
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
                <div class="col-12 mt-3 position-relative d-flex align-items-center">
                    <button
                      data-v-cba73d34=""
                      type="button"
                      name="button"
                      class="btn btn-primary py-2 px-3 z-index-1"
                      @click="getReports"
                    >
                      {{$t('apply')}}
                    </button>
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
                        :checked="props.row.is_active == 1 ? 'checked' : ''"
                        type="checkbox"
                        disabled="disabled"
                        id="flexSwitchCheckChecked"
                      />
                      <!-- <label class="form-check-label" for="flexSwitchCheckChecked">Checked switch checkbox input</label> -->
                    </div>
                  </div>
                  <!-- <div v-else-if="props.column.field == 'payment_method'">
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
                  </div> -->
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
       filter_min_date: "",
      loading: false,
      allCustomerReports: '',
      columns: [
        {
          label: this.$t("form.customer.first_name.label"),
          field: "first_name",
          sortable: false,
        },
        {
          label: this.$t("form.customer.last_name.label"),
          field: "last_name",
          sortable: false,
        },
        {
          label: this.$t("form.customer.dob.label"),
          field: "dob",
          sortable: false,
        },
        {
          label: this.$t("form.customer.phone.label"),
          field: "phone",
          sortable: false,
        },
        {
          label: this.$t("form.customer.email.label"),
          field: "email",
          sortable: false,
        },
        {
          label: this.$t("form.customer.gender.label"),
          field: "gender",
          sortable: false,
        },
          {
          label: this.$t("form.customer.status.label"),
          field: "is_active",
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
    async exportCustomers(type) {
      this.filterData.export = type;
      //   await this.$repositories.sales.export(this.filterData);
      await this.$generalService.customerExport(this.filterData);
    },
    async filter() {
      this.getReports();
    },
    async getReports() {
      this.loading = true;
      this.error = false;
      this.errors = "";
      const data = await this.$generalService.getCustomerReports(this.filterData);
      if (data.success) {
        this.loading = false;
        this.rows = data.data.data;
        this.allCustomerReports = data.data;
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
    allCustomerReports(newCount, oldCount) {
      if (
        this.allCustomerReports &&
        this.allCustomerReports != null &&
        this.allCustomerReports.data != null
      ) {
        this.rows = this.allCustomerReports.data;
        this.totalRows = this.allCustomerReports.meta.total;
        if (this.filterData.page != this.allCustomerReports.meta.current_page) {
          this.filterData.page = this.allCustomerReports.meta.current_page;
        }
        if (this.filterData.perPage != this.allCustomerReports.meta.per_page) {
          this.filterData.perPage = this.allCustomerReports.meta.per_page;
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
