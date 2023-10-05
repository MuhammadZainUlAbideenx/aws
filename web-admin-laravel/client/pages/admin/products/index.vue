<template >
  <div class="">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="row g-0">
        <div class="col-sm-12 px-0 d-flex">
          <h2 class="m-0 text-body bold">{{ this.$t("sidebar.product") }}</h2>
          <button
            v-tooltip="{ content: 'Import Products' }"
            type="button"
            class="
              btn btn-sm btn-primary
              text-white
              ms-auto
              d-flex
              justify-content-end
              align-items-end
              mb-3
            "
            name="button"
            data-bs-toggle="modal"
            data-bs-target="#importForm"
          >
          {{$t('import_bulk_products')}}
          </button>
          <!-- import button  ends-->
        </div>
        <!-- /.col -->
        <div class="row">
          <div class="col-sm-12 px-0">
            <ol class="breadcrumb float-sm-right text-body">
              <li class="breadcrumb-item">
                <a href="#">{{ this.$t("sidebar.home") }}</a>
              </li>
              <li class="breadcrumb-item active">
                {{ this.$t("sidebar.product") }}
              </li>
            </ol>
            <p class="text-body-secondary">
              {{ this.$t("form.product.index_description") }}
            </p>
          </div>
          <!-- /.col -->
        </div>
      </div>
      <!-- /.row -->
    </div>

    <!-- import button  starts-->

    <!-- Main content -->
    <section class="content">
      <div v-if="$fetchState.pending || loader">
        <AdminTableLoader />
      </div>
      <div class="container-fluid" v-else>
        <div class="card gutter-b border-0">
          <div class="card-header p-0">
            <div class="row table-filter-row g-0">
              <!-- Small boxes (Stat box) -->
              <div class="col-lg-9 col-md-8">
                <div class="d-flex flex-column flex-md-row">
                  <select
                    class="form-select custom-select"
                    v-model="filterData.column"
                  >
                    <option value="" disabled>
                      {{ $t("table.select_column") }}
                    </option>
                    <option value="name">{{ $t("columns.name") }}</option>
                  </select>
                  <div class="form-group position-relative col-md-4 col-lg-4">
                    <input
                      class="form-control"
                      v-model="filterData.search"
                      @change="filter"
                      type="search"
                      :placeholder="this.$t('dataTables.Search')"
                      @keyup="removeIcon"
                    />
                    <div
                      v-bind:class="{ 'd-none': hideIcon }"
                      class="position-absolute search-input-custom product-top"
                    >
                      <fa :icon="['fas', 'search']" fixed-width class="" />
                    </div>
                  </div>
                  <div
                    class="form-group position-relative"
                    style="padding-left: 0px"
                    v-if="
                      allActiveSettings.settings.generalSettings
                        .is_multi_vendor == 1
                    "
                  >
                    <AdminSearchSelectable
                      :class="error && error.vendor_id ? 'error' : ''"
                      apiMethod="activeVendors"
                      responseKey="vendors"
                      :initialOptions="allActiveVendors.vendors"
                      :placeholder="this.$t('table.select_vendor')"
                      v-model="filterData.vendor_id"
                      v-on:input="getVendorProducts($event)"
                    />
                  </div>
                </div>
              </div>

              <div class="col-lg-3 col-md-4 table-actions px-0">
                <div slot="table-actions" class="align-middle">
                  <div class="share">
                    <nav>
                      <span @click="exportProducts('csv')">
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

                      <span @click="exportProducts('xlsx')">
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
                  <nuxt-link
                    v-permission="'products.create'"
                    :to="localePath('/admin/products/create')"
                  >
                    <button
                      type="button"
                      v-tooltip="{ content: 'Add Product' }"
                      class="btn add px-3 rounded-circle"
                      name="button"
                    >
                      <fa :icon="['fas', 'plus']" fixed-width />
                    </button>
                  </nuxt-link>
                </div>
              </div>
            </div>
          </div>

          <AdminImportModal modal_id="importForm" api_prefix="admin">
          </AdminImportModal>
          <div
            class="
              card-body
              mt-2
              data-tables-div
              py-0
              m-0
              rounded-md
              responsive-custom
            "
          >
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
                  <div v-if="props.column.field == 'display_price'">
                    <span v-if="props.row.product_type == 1">
                      <span v-if="props.row.special_sale">
                        {{ props.row.special_sale.display_price }}<br />
                        <span class="text-decoration-line-through text-danger">
                          {{ props.row.display_price }}
                        </span>
                      </span>
                      <span v-else-if="props.row.flash_sale">
                        {{ props.row.flash_sale.display_price }}<br />
                        <span class="text-decoration-line-through text-danger">
                          {{ props.row.display_price }}
                        </span>
                      </span>
                      <span v-else>
                        {{ props.row.display_price }}
                      </span>
                    </span>
                    <span v-else-if="props.row.product_type == 2">
                      <span v-if="props.row.special_sale">
                        {{ props.row.special_sale.display_price }}
                        <br />
                        <span class="text-decoration-line-through text-danger">
                          {{ props.row.display_price }}
                        </span>
                      </span>
                      <span v-else-if="props.row.flash_sale">
                        {{ props.row.flash_sale.display_price }}
                        <br />
                        <span class="text-decoration-line-through text-danger">
                          {{ props.row.display_price }}
                        </span>
                      </span>
                      <span v-else>
                        {{ props.row.starting_from_price }}
                      </span>
                    </span>
                  </div>
                  <div v-else-if="props.column.field == 'is_active'">
                    <div class="form-switch" v-if="props.row.product_type == 1">
                      <input
                        class="form-check-input"
                        @change="
                          (event) => changeProductStatus(props.row.id, event)
                        "
                        :checked="props.row.is_active == 1 ? 'checked' : ''"
                        type="checkbox"
                        id="flexSwitchCheckChecked"
                      />
                      <!-- <label class="form-check-label" for="flexSwitchCheckChecked">Checked switch checkbox input</label> -->
                    </div>
                    <div
                      class="form-switch"
                      v-else-if="
                        props.row.product_type == 2 &&
                        props.row.variants.length == 0
                      "
                    >
                      <input
                        class="form-check-input"
                        disabled
                        @change="
                          (event) => changeProductStatus(props.row.id, event)
                        "
                        :checked="props.row.is_active == 1 ? 'checked' : ''"
                        type="checkbox"
                        id="flexSwitchCheckChecked"
                      />
                      <span v-tooltip="{ content: 'Please add variants' }"
                        ><fa :icon="['fas', 'info-circle']" fixed-width
                      /></span>
                    </div>
                    <div class="form-switch" v-else>
                      <input
                        class="form-check-input"
                        @change="
                          (event) => changeProductStatus(props.row.id, event)
                        "
                        :checked="props.row.is_active == 1 ? 'checked' : ''"
                        type="checkbox"
                        id="flexSwitchCheckChecked"
                      />
                    </div>
                  </div>
                  <div v-else-if="props.column.field == 'flash_sale'">
                    <div class="form-switch">
                      <input
                        class="form-check-input"
                        @change="
                          (event) => changeProductStatus(props.row.id, event)
                        "
                        :checked="props.row.flash_sale == 1 ? 'checked' : ''"
                        type="checkbox"
                        id="flexSwitchCheckChecked"
                      />
                      <!-- <label class="form-check-label" for="flexSwitchCheckChecked">Checked switch checkbox input</label> -->
                    </div>
                  </div>

                  <div v-else-if="props.column.field == 'special_sale'">
                    <div class="form-switch">
                      <input
                        class="form-check-input"
                        @change="
                          (event) => changeProductStatus(props.row.id, event)
                        "
                        :checked="props.row.special_sale == 1 ? 'checked' : ''"
                        type="checkbox"
                        id="flexSwitchCheckChecked"
                      />
                      <!-- <label class="form-check-label" for="flexSwitchCheckChecked">Checked switch checkbox input</label> -->
                    </div>
                  </div>

                  <div v-else-if="props.column.field == 'is_featured'">
                    <div class="form-switch">
                      <input
                        class="form-check-input"
                        @change="
                          (event) => changeProductStatus(props.row.id, event)
                        "
                        :checked="props.row.is_featured == 1 ? 'checked' : ''"
                        type="checkbox"
                        id="flexSwitchCheckChecked"
                      />
                      <!-- <label class="form-check-label" for="flexSwitchCheckChecked">Checked switch checkbox input</label> -->
                    </div>
                  </div>
                  <!-- sale and flash sale tag with the name starts -->

                  <div v-else-if="props.column.field == 'name'">
                    <span v-if="props.row.special_sale">
                      {{ props.row.name }}
                      <span class="badge bg-danger">{{
                        $t("form.product.special_sale.label")
                      }}</span>
                    </span>
                    <span v-else-if="props.row.flash_sale">
                      {{ props.row.name }}
                      <span class="badge bg-danger">{{
                        $t("form.product.flash_sale.label")
                      }}</span>
                    </span>
                    <span v-else>
                      {{ props.row.name }}
                    </span>
                  </div>
                  <!-- sale and flash sale tag with the name ends -->
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

                  <div v-else-if="props.column.field == 'actions'">
                    <nuxt-link
                      v-permission="'products.index'"
                      v-tooltip="{ content: 'Show' }"
                      class="btn btn-sm rounded-circle text-primary"
                      :to="localePath('/admin/products/view/' + props.row.id)"
                    >
                      <fa :icon="['fas', 'eye']" fixed-width />
                    </nuxt-link>
                    <nuxt-link
                      v-permission="'products.update'"
                      v-tooltip="{ content: 'Edit' }"
                      class="btn btn-sm rounded-circle text-success"
                      :to="localePath('/admin/products/edit/' + props.row.id)"
                    >
                      <fa :icon="['fas', 'edit']" fixed-width />
                    </nuxt-link>
                    <button
                      v-permission="'products.delete'"
                      v-tooltip="{ content: 'Delete' }"
                      type="button"
                      class="btn btn-sm rounded-circle text-danger"
                      name="button"
                      data-bs-toggle="modal"
                      :data-bs-target="'#DeleteItem' + props.row.id"
                    >
                      <fa :icon="['fas', 'trash-alt']" fixed-width />
                    </button>
                    <AdminDeleteModal
                      :modal_id="'DeleteItem' + props.row.id"
                      @deleteClicked="deleteProduct(props.row.id)"
                      :delete_id="props.row.id"
                    >
                    </AdminDeleteModal>
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
import productMixin from "~/mixins/productMixin.js";
import { mapGetters, mapActions } from "vuex";
export default {
  layout: "admin",
  middleware: ["admin", "permission"],
  meta: {
    permission: "products.index",
    strategy: "read",
  },
  mixins: [datatableMixin, productMixin],
  data() {
    return {
      loader: false,
      url: "/backend",
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
          label: this.$t("columns.status"),
          field: "is_active",
        },
        {
          label: this.$t("columns.created_at"),
          field: "created_at",
          sortable: false,
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
    if (this.$gates.hasPermission("products.index")) {
      await this.fetchProducts(this.page).then();
    }
    if (
      this.allActiveSettings.settings.generalSettings.is_multi_vendor == "1"
    ) {
      if (!this.allActiveVendors.vendors) {
        await this.fetchActiveVendors();
      }
    }
  },
  methods: {
    ...mapActions({
      fetchProducts: "Products/fetchProducts",
      deleteProducts: "Products/deleteProducts",
      filterProducts: "Products/filterProducts",
      updateProductStatus: "Products/updateProductStatus",
      filterVendorProducts: "Products/filterVendorProducts",
    }),
    async exportProducts(type) {
      this.filterData.export = type;
      await this.$repositories.products.export(this.filterData);
    },
    async getVendorProducts(e) {
      this.loader = true;
      this.filterData.venor_id = e;
      await this.filterVendorProducts(e);
      this.loader = false;
    },

    async deleteProduct(id) {
      await this.deleteProducts({
        filterData: this.filterData,
        product_id: id,
      })
        .then((response) => {
          if (response.state == "fail") {
            this.$toast.error(response.message);
          }
          if (response.state == "success") {
            this.fetchActiveProducts();
            this.$toast.success(response.message);
          }
        })
        .catch((e) => {});
    },
    async filter() {
      await this.filterProducts(this.filterData).then((response) => {
        if (response.state == "fail") {
          this.$toast.error(response.message);
        }
        if (response.state == "success") {
        }
      });
    },
    async changeProductStatus(id, event) {
      await this.updateProductStatus({
        filterData: this.filterData,
        product_id: id,
      })
        .then((response) => {
          if (response.state == "fail") {
            this.$toast.error(response.message);
            event.target.checked = !event.target.checked;
          }
          if (response.state == "success") {
            this.fetchActiveProducts();
            this.$toast.success(response.message);
          }
        })
        .catch((e) => {
          event.target.checked = !event.target.checked;
        });
    },
  },

  computed: {
    ...mapGetters({
      allProducts: "Products/allProducts",
    }),
  },
  watch: {
    allProducts(newCount, oldCount) {
      if (
        this.allProducts &&
        this.allProducts != null &&
        this.allProducts.data != null
      ) {
        this.rows = this.allProducts.data;
        this.totalRows = this.allProducts.meta.total;
        if (this.filterData.page != this.allProducts.meta.current_page) {
          this.filterData.page = this.allProducts.meta.current_page;
        }
        // if (this.filterData.perPage != this.allProducts.meta.per_page) {
        //   this.filterData.perPage = this.allProducts.meta.per_page;
        // }
      }
    },
  },
};
</script>
