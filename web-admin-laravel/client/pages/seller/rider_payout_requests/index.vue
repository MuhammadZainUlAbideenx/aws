<template >
  <div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="row g-0">
        <div class="col-sm-12 px-0">
          <h2 class="m-0 text-body bold">
            {{ this.$t("sidebar.rider_payout_requests.label") }}
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
                {{ this.$t("sidebar.rider_payout_requests.label") }}
              </li>
            </ol>
            <p class="text-body-secondary">
              {{ this.$t("sidebar.rider_payout_requests.index_description") }}
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
                  <select class="form-select" v-model="filterData.column">
                    <option value="" disabled>
                      {{ $t("table.select_column") }}
                    </option>
                    <option value="vendor_name">
                      {{ $t("columns.vendor_name") }}
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
                    <div
                      v-bind:class="{ 'd-none': hideIcon }"
                      class="position-absolute search-input-custom"
                    >
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
                  <div v-if="props.column.field == 'status'">
                    <span v-if="props.row.status == 1">
                      {{ $t("pending") }}
                    </span>
                    <span v-else-if="props.row.status == 2">
                      {{ $t("approved") }}
                    </span>
                    <span v-else>
                      {{ $t("rejected") }}
                    </span>
                  </div>
                  <div v-else-if="props.column.field == 'actions'">
                    <span @click="changeRiderPayoutRequestStatus( props.row.id, 2)">
                      <nuxt-link to="#" v-tooltip="{ content: 'Complete' }" v-if="props.row.status == 1">
                        <fa :icon="['fas', 'check']" fixed-width />
                      </nuxt-link>
                    </span>
                    <span @click="changeRiderPayoutRequestStatus(props.row.id, 3)" v-if="props.row.status == 1">
                      <nuxt-link to="#" v-tooltip="{ content: 'Rejected' }">
                        <fa :icon="['fas', 'trash']" fixed-width />
                      </nuxt-link>
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
  layout: "vendor",
  middleware: ["vendor"],
//   meta: {
//     permission: "rider_payout_requests.index",
//     strategy: "read",
//   },
  mixins: [datatableMixin],
  data() {
    return {
      columns: [
        {
          label: this.$t("columns.rider_name"),
          field: "rider.name",
        },
        {
          label: this.$t("columns.amount"),
          field: "display_amount",
        },
        {
          label: this.$t("columns.note"),
          field: "note",
          sortable: false,
        },
        {
          label: this.$t("columns.status"),
          field: "status",
          sortable: false,
        },
        {
          label: this.$t("columns.actions"),
          field: "actions",
          sortable: false,
        },
      ],
      action : false,
    };
  },
  async fetch() {
    await this.fetchRiderPayoutRequests(this.page).then();
  },
  methods: {
    ...mapActions({
      fetchRiderPayoutRequests: "Seller/RiderPayoutRequests/fetchRiderPayoutRequests",
      filterRiderPayoutRequests: "Seller/RiderPayoutRequests/filterRiderPayoutRequests",
      updateRiderPayoutRequestStatus: "Seller/RiderPayoutRequests/updateRiderPayoutRequestStatus",
    }),
    async exportOrders(type) {
      this.filterData.export = type;
      await this.$sellerRepositories.riderPayoutRequests.export(this.filterData);
    },

    async filter() {
      await this.filterRiderPayoutRequests(this.filterData).then((response) => {
        if (response.state == "fail") {
          this.$toast.error(response.message);
        }
        if (response.state == "success") {
        }
      });
    },
    async changeRiderPayoutRequestStatus(riderPayoutRequest_id , status, event) {
      await this.updateRiderPayoutRequestStatus({
        filterData: this.filterData,
        riderPayoutRequest_id: riderPayoutRequest_id,
        status : status,
      })
        .then((response) => {
          if (response.state == "fail") {
            this.$toast.error(response.message);
            event.target.checked = !event.target.checked;
          }
          if (response.state == "success") {
            this.$toast.success(response.message);
            this.fetchRiderPayoutRequests();
            this.action = true;
          }
        })
        .catch((e) => {
          event.target.checked = !event.target.checked;
        });
    },
  },

  computed: {
    ...mapGetters({
      allRiderPayoutRequests: "Seller/RiderPayoutRequests/allRiderPayoutRequests",
    }),
  },
  mounted() {},
  watch: {
    allRiderPayoutRequests(newCount, oldCount) {
      if (
        this.allRiderPayoutRequests &&
        this.allRiderPayoutRequests != null &&
        this.allRiderPayoutRequests.data != null
      ) {
        this.rows = this.allRiderPayoutRequests.data;
        this.totalRows = this.allRiderPayoutRequests.meta.total;
        if (this.filterData.page != this.allRiderPayoutRequests.meta.current_page) {
          this.filterData.page = this.allRiderPayoutRequests.meta.current_page;
        }
        if (this.filterData.perPage != this.allRiderPayoutRequests.meta.per_page) {
          this.filterData.perPage = this.allRiderPayoutRequests.meta.per_page;
        }
      }
    },
  },
};
</script>
