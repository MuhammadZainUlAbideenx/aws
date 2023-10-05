<template >
  <div class="" v-if="!this.$auth.user.store">
    <SellerShopSettings />
  </div>
  <div class="" v-else-if="!this.$auth.user.is_active">
    <SellerShopDeactive />
  </div>
  <div class="" v-else>
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="row g-0">
        <div class="col-sm-12 px-0">
          <h2 class="m-0 text-body bold">{{ this.$t("sidebar.rider") }}</h2>
        </div>
        <!-- /.col -->
        <div class="row">
          <div class="col-sm-12 px-0">
            <ol class="breadcrumb float-sm-right text-body">
              <li class="breadcrumb-item">
                <a href="#">{{ this.$t("sidebar.home") }}</a>
              </li>
              <li class="breadcrumb-item active">
                {{ this.$t("sidebar.rider") }}
              </li>
            </ol>
            <p class="text-body-secondary">
            {{ this.$t("form.rider.index_description") }}
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
            <div
              class="row mx-0 table-filter-row w-100 g-0"
            >
              <!-- Small boxes (Stat box) -->
              <div class="col-lg-8">
                <div class="d-flex flex-column flex-md-row">
                    <select class="form-select custom-select" v-model="filterData.column">
                      <option value="" disabled>{{ $t("table.select_column") }}</option>
                      <option value="first_name">{{ $t("columns.first_name") }}</option>
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
                    <div v-bind:class="{ 'd-none': hideIcon }" class="position-absolute search-input-custom">
                      <fa :icon="['fas', 'search']" fixed-width class="" />
                    </div>
                  </div>
                </div>

              </div>

              <div class="col-lg-4 table-actions px-0">
                <div slot="table-actions" class="align-middle">
                  <div class="share">
                    <nav>
                      <span @click="exportRiders('csv')">
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

                      <span @click="exportRiders('xlsx')">
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

                      <span @click="exportRiders('pdf')">
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
                  <nuxt-link :to="localePath('/seller/riders/create')">
                    <button
                      type="button"
                      v-tooltip="{ content: 'Add Rider' }"
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
                          (event) => changeRiderStatus(props.row.id, event)
                        "
                        :checked="props.row.is_active == 1 ? 'checked' : ''"
                        type="checkbox"
                        id="flexSwitchCheckChecked"
                      />
                      <!-- <label class="form-check-label" for="flexSwitchCheckChecked">Checked switch checkbox input</label> -->
                    </div>
                  </div>
                  <div v-else-if="props.column.field == 'actions'">
                    <nuxt-link
                      class="btn btn-sm rounded-circle text-primary"
                      v-tooltip="{ content: 'Show' }"
                      :to="localePath('/seller/riders/view/' + props.row.id)"
                    >
                      <fa :icon="['fas', 'eye']" fixed-width />
                    </nuxt-link>
                    <nuxt-link
                      class="btn btn-sm rounded-circle text-success"
                      v-tooltip="{ content: 'Edit' }"
                      :to="localePath('/seller/riders/edit/' + props.row.id)"
                    >
                      <fa :icon="['fas', 'edit']" fixed-width />
                    </nuxt-link>
                    <button
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
                      @deleteClicked="deleteRider(props.row.id)"
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
import { mapGetters, mapActions } from "vuex";
import datatableMixin from "~/mixins/datatableMixin.js";
export default {
  layout: "vendor",
  middleware: ["vendor"],
  meta: {
    permission: "riders.index",
    strategy: "read",
  },
  mixins: [datatableMixin],
  data() {
    return {
      columns: [
        {
          label: this.$t("columns.first_name"),
          field: "first_name",
        },
{
          label: this.$t("columns.last_name"),
          field: "last_name",
        },
        {
          label: this.$t("columns.email"),
          field: "email",
        },
        {
          label: this.$t("columns.gender"),
          field: "gender",
        },
        {
            label: this.$t('columns.status'),
            field: 'is_active',
            sortable: false
          },
        {
          label: this.$t("columns.phone"),
          field: "phone",
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
    await this.fetchRiders(this.page).then();
  },
  methods: {
    ...mapActions({
      fetchRiders: "Seller/Riders/fetchRiders",
      fetchActiveRiders: "General/fetchActiveRiders",
      deleteRiders: "Seller/Riders/deleteRiders",
      filterRiders: "Seller/Riders/filterRiders",
      updateRiderStatus: "Seller/Riders/updateRiderStatus",
      updateRiderIsDefault: "Seller/Riders/updateRiderIsDefault",
    }),
    async exportRiders(type) {
      this.filterData.export = type;
      await this.$sellerRepositories.riders.export(this.filterData);
    },
    async deleteRider(id) {
      await this.deleteRiders({
        filterData: this.filterData,
        rider_id: id,
      })
        .then((response) => {
          if (response.state == "fail") {
            this.$toast.error(response.message);
          }
          if (response.state == "success") {
            this.$toast.success(response.message);
            this.fetchActiveRiders();
          }
        })
        .catch((e) => {});
    },
    async filter() {
      await this.filterRiders(this.filterData).then((response) => {
        if (response.state == "fail") {
          this.$toast.error(response.message);
        }
        if (response.state == "success") {
        }
      });
    },
    async changeDefaultRider(id, event) {
      await this.updateRiderIsDefault({
        filterData: this.filterData,
        rider_id: id,
      }).then((response) => {
        if (response.state == "fail") {
          this.$toast.error(response.message);
          event.target.checked = !event.target.checked;
        }
        if (response.state == "success") {
          this.$toast.success(response.message);
          this.fetchActiveRiders();
        }
      });
    },
    async changeRiderStatus(id, event) {
      await this.updateRiderStatus({
        filterData: this.filterData,
        rider_id: id,
      })
        .then((response) => {
          if (response.state == "fail") {
            this.$toast.error(response.message);
            event.target.checked = !event.target.checked;
          }
          if (response.state == "success") {
            this.$toast.success(response.message);
            this.fetchActiveRiders();
          }
        })
        .catch((e) => {
          event.target.checked = !event.target.checked;
        });
    },
  },

  computed: {
    ...mapGetters({
      allRiders: "Seller/Riders/allRiders",
    }),
  },
  mounted() {},
  watch: {
    allRiders(newCount, oldCount) {
      if (
        this.allRiders &&
        this.allRiders != null &&
        this.allRiders.data != null
      ) {
        this.rows = this.allRiders.data;
        this.totalRows = this.allRiders.meta.total;
        if (this.filterData.page != this.allRiders.meta.current_page) {
          this.filterData.page = this.allRiders.meta.current_page;
        }
        if (this.filterData.perPage != this.allRiders.meta.per_page) {
          this.filterData.perPage = this.allRiders.meta.per_page;
        }
      }
    },
  },
};
</script>
s
