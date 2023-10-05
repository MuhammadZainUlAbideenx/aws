<template >
  <div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="row g-0">
        <div class="col-sm-12 px-0">
          <h2 class="m-0 text-body bold">
            {{ this.$t("sidebar.reports.product") }}
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
                {{ this.$t("sidebar.reports.product") }}
              </li>
            </ol>
            <p class="text-body-secondary">
              {{ this.$t("reports.product.index_description") }}
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
                      <option value="name">
                        {{ $t("columns.name") }}
                      </option>
                      <option value="manufacturer_id">
                        {{ $t("columns.manufacturer") }}
                      </option>
                      <option value="price">
                        {{ $t("columns.price") }}
                      </option>

                      <option value="sku">
                        {{ $t("columns.sku") }}
                      </option>
                      <option value="stock">
                        {{ $t("columns.stock") }}
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
              <div class="col-md-10 col-lg-5 pt-md-3 pt-lg-0">
                 <div class="d-flex flex-column flex-md-row">
                  <div class=" form-group position-relative ms-md-0 ms-lg-0">
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
                  <div class=" form-group position-relative">
                    <select class="form-select w-100" v-model="filterData.status">
                      <option value="">{{ $t("columns.select_status") }}</option>
                      <option value="1">
                        {{ $t("columns.active") }}
                      </option>
                      <option value="0">
                        {{ $t("columns.deactivate") }}
                      </option>
                    </select>
                  </div>



                </div>
              </div>
              <div class="col-md-2 col-lg-2 col-xlg-2 table-actions px-0">
                <div slot="table-actions" class="align-middle">
                  <div class="share" v-if="rows.length > 0">
                    <nav>
                      <span @click="exportProducts('csv')">
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

                      <span @click="exportProducts('xlsx')">
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

                      <span @click="exportProducts('pdf')">
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
            <!--Filters of second row starts--->
            <div class="row table-filter-row g-0 justify-content-end">
              <!-- Small boxes (Stat box) -->
              <div class="col-md-4 col-lg-12">
                <div class="row g-0 input-group">
                  <div class="col-md-2 col-lg-2 form-group position-relative mt-3 ms-0">
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
                  <div class="form-group position-relative">

                  </div>
                </div>
              </div>
              <div class="col-md-6 col-lg-6">
                <div class="row g-0 input-group justify-content-center">

                </div>
              </div>
               <div class="col-md-2 col-lg-2 col-xlg-2 table-actions px-0">

              </div>
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
                     <div v-if="props.column.field == 'display_price'">
                    <span v-if="props.row.product_type == 1">
                        <span v-if="props.row.special_sale">
                      {{ props.row.special_sale.display_price }}<br>
                      <span class="text-decoration-line-through text-danger">
                        {{ props.row.display_price}}
                      </span>
                        </span>
                        <span v-else-if="props.row.flash_sale">
                      {{ props.row.flash_sale.display_price }}<br>
                       <span class="text-decoration-line-through text-danger">
                        {{ props.row.display_price}}
                      </span>
                        </span>
                        <span v-else>
                        {{ props.row.display_price}}
                        </span>
                    </span>
                    <span v-else-if="props.row.product_type == 2">
                        <span v-if="props.row.special_sale">
                      {{ props.row.special_sale.display_price }}
                      <br>
                         <span class="text-decoration-line-through text-danger">
                        {{ props.row.display_price}}
                      </span>
                        </span>
                        <span v-else-if="props.row.flash_sale">
                      {{ props.row.flash_sale.display_price }}
                      <br>
                         <span class="text-decoration-line-through text-danger">
                        {{ props.row.display_price}}
                      </span>
                        </span>
                        <span v-else>
                         {{ $t("starting_from_price") }} {{ props.row.starting_from_price}}
                        </span>

                    </span>
                  </div>
                  <div v-else-if="props.column.field == 'is_active'">
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
      loading: false,
      allProductReports: '',
       filter_min_date: "",
      columns: [
        {
          label: this.$t("columns.name"),
          field: "name",
        },
        {
          label: this.$t("columns.manufacturer"),
          field: "manufacturer.name",
          sortable: false,
        },
        {
          label: this.$t("columns.price"),
          field: "display_price",
        },
        {
          label: this.$t("columns.product_type"),
          field: "product_type",
        },

        {
          label: this.$t("columns.sku"),
          field: "sku",
        },
        {
          label: this.$t("columns.stock"),
          field: "stock",
        },
         {
          label: this.$t("columns.orders"),
          field: "product_ordered",
        },
        {
          label: this.$t("columns.status"),
          field: "is_active",
        },
        {
          label: this.$t("columns.feature"),
          field: "is_feature",
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
    async exportProducts(type) {
      this.filterData.export = type;
      //   await this.$repositories.sales.export(this.filterData);
      await this.$generalService.productExport(this.filterData);
    },
    async filter() {
      this.getReports();
    },
    async getReports() {
      this.loading = true;
      this.error = false;
      this.errors = "";
    //   this.filterData.perPage = 10;
      const data = await this.$generalService.getProductReports(
        this.filterData
      );
      if (data.success) {
        this.loading = false;
        this.rows = data.data.data;
        this.allProductReports = data.data;
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
    allProductReports(newCount, oldCount) {
      if (
        this.allProductReports &&
        this.allProductReports != null &&
        this.allProductReports.data != null
      ) {
        this.rows = this.allProductReports.data;
        this.totalRows = this.allProductReports.meta.total;
        if (this.filterData.page != this.allProductReports.meta.current_page) {
          this.filterData.page = this.allProductReports.meta.current_page;
        }
        if (this.filterData.perPage != this.allProductReports.meta.per_page) {
          this.filterData.perPage = this.allProductReports.meta.per_page;
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
