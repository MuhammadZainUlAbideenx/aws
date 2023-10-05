<template >

  <div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="row g-0">
          <div class="col-sm-12 px-0">
            <h2 class="m-0 text-body bold">{{this.$t("sidebar.vendor")}}</h2>
          </div>
          <!-- /.col -->
          <div class="row">
            <div class="col-sm-12 px-0">
              <ol class="breadcrumb float-sm-right text-body">
                <li class="breadcrumb-item "><a href="#">{{this.$t("sidebar.home")}}</a></li>
                <li class="breadcrumb-item active">{{this.$t("sidebar.vendor")}}</li>
              </ol>
              <p class="text-body-secondary">{{this.$t("form.vendor.index_description")}}</p>
            </div>
            <!-- /.col -->
          </div>
        </div>
        <!-- /.row -->
    </div>

    <!-- Main content -->
    <section class="content">
         <div v-if="$fetchState.pending">
       <AdminTableLoader/>
      </div>
      <div class="container-fluid" v-else>
         <div class="card gutter-b border-0" >
           <div class="card-header p-0">
         <div class="row table-filter-row g-0">
          <!-- Small boxes (Stat box) -->
               <div class="col-lg-8">
                 <div class="d-flex flex-column flex-md-row">
                     <select class="form-select custom-select"
                          v-model="filterData.column">
                          <option value="" disabled>{{ $t('table.select_column')}}</option>
                          <option value="name">{{ $t('columns.name')}}</option>
                       </select>
                         <div class="form-group position-relative col-md-8 col-lg-5">
                     <input class="form-control "
                         v-model="filterData.search"
                         @change="filter"
                         type="search"
                         :placeholder='this.$t("dataTables.Search")'
                         @keyup="removeIcon">
                         <div v-bind:class="{ 'd-none': hideIcon }" class="position-absolute search-input-custom">
                    <fa :icon="['fas','search']" fixed-width class="" />

                  </div>
                </div>
                 </div>


        </div>
               <div class="col-lg-4 table-actions px-0">
                <div slot="table-actions" class="align-middle">
                  <div class="share">
                    <nav>
                      <span @click="exportVendors('csv')">
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

                      <span @click="exportVendors('xlsx')">
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

                      <span @click="exportVendors('pdf')">
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
                    v-permission="'vendors.create'"
                    :to="localePath('/admin/vendors/create')"
                  >
                    <button
                      type="button"
                      v-tooltip="{ content: 'Add Vendor' }"
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
            <vue-good-table v-if="!$fetchState.pending"
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
                            row-style-class="m-5">
              <template slot="table-row" slot-scope="props">
                  <div v-if="props.column.field == 'is_active'">
                    <div class="form-switch">
                      <input
                        class="form-check-input"
                        @change="
                          (event) => changeVendorStatus(props.row.id, event)
                        "
                        :checked="props.row.is_active == 1 ? 'checked' : ''"
                        type="checkbox"
                        id="flexSwitchCheckChecked"
                      />
                      <!-- <label class="form-check-label" for="flexSwitchCheckChecked">Checked switch checkbox input</label> -->
                    </div>
                  </div>
                   <div v-else-if="props.column.field == 'store_details.is_active'">
                    <div class="form-switch">
                      <input
                        class="form-check-input"
                        @change="
                          (event) => changeVendorStoreStatus(props.row.id, event)
                        "
                        :checked="props.row.store_details != null && props.row.store_details.is_active == 1 ? 'checked' : ''"
                        type="checkbox"
                        id="flexSwitchCheckChecked"
                        :disabled="props.row.store_details == null"
                      />
                      <!-- <label class="form-check-label" for="flexSwitchCheckChecked">Checked switch checkbox input</label> -->
                    </div>
                  </div>
                  <div v-else-if="props.column.field == 'is_featured'">
                    <div class="form-switch">
                      <input
                        class="form-check-input"
                          @change="
                          (event) => changeVendorFeatured(props.row.id, event)
                        "
                        :checked="props.row.is_featured == 1 ? 'checked' : ''"
                        type="checkbox"
                        id="flexSwitchCheckChecked"
                      />
                      <!-- <label class="form-check-label" for="flexSwitchCheckChecked">Checked switch checkbox input</label> -->
                    </div>
                  </div>
                   <div v-else-if="props.column.field == 'actions'">
                    <nuxt-link
                            v-permission="'vendors.index'"  v-tooltip="{ content: 'Show' }"
                              class="btn btn-sm rounded-circle text-primary   "
                            :to="
                              localePath('/admin/vendors/view/' + props.row.id)
                            "
                            >
                              <fa :icon="['fas', 'eye']" fixed-width />
                           </nuxt-link
                          >
                          <nuxt-link
                          v-permission="'vendors.update'" v-tooltip="{ content: 'Edit' }"
                            class=" btn btn-sm rounded-circle text-success   "
                          :to="
                            localePath('/admin/vendors/edit/' + props.row.id)
                          "
                          >
                            <fa :icon="['fas', 'edit']" fixed-width />
                          </nuxt-link>
                       <button
                        v-permission="'vendors.delete'"
                          type="button" v-tooltip="{ content: 'Delete' }"
                          class="btn btn-sm rounded-circle text-danger   "
                          name="button" data-bs-toggle="modal" :data-bs-target="'#DeleteItem'+props.row.id"

                        >
                         <fa :icon="['fas', 'trash-alt']" fixed-width />
                        </button>
                  <AdminDeleteModal :modal_id="'DeleteItem'+props.row.id" @deleteClicked="deleteVendor(props.row.id)"  :delete_id="props.row.id">
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

  import { mapGetters, mapActions } from 'vuex'
  import datatableMixin from '~/mixins/datatableMixin.js'
  export default {
    layout: 'admin',
    middleware: ['admin', 'permission','onlyMultiVendor'],
    meta: {
      permission: 'vendors.index',
      strategy: 'read'
    },
    mixins: [datatableMixin],
    data() {
      return {
        columns: [
          {
            label: this.$t('columns.name'),
            field: 'name'
          },
             {
            label: this.$t('columns.email'),
            field: 'email'
          },
            {
            label: this.$t('columns.store_name'),
            field: 'store_details.name',
            sortable: false
          },
          {
            label: this.$t('columns.is_featured'),
            field: 'is_featured',
            sortable: false
          },
          {
            label: this.$t('columns.status'),
            field: 'is_active'
          },
          {
            label: this.$t('columns.store_status'),
            field: 'store_details.is_active'
          },

          {
            label: this.$t('columns.created_at'),
            field: 'created_at',
            sortable: false
          },
          {
            label: this.$t('columns.actions'),
            field: 'actions',
            sortable: false
          }
        ]
      }
    },
    async fetch() {
      if (this.$gates.hasPermission('vendors.index')) {
       await this.fetchVendors(this.page).then()
      }
    },
    methods: {
      ...mapActions({
        fetchVendors: 'Vendors/fetchVendors',
        fetchActiveVendors: 'General/fetchActiveVendors',
        deleteVendors: 'Vendors/deleteVendors',
        filterVendors: 'Vendors/filterVendors',
        updateVendorStatus: 'Vendors/updateVendorStatus',
        updateVendorStoreStatus: 'Vendors/updateVendorStoreStatus',
        updateVendorFeatured: 'Vendors/updateVendorFeatured',
      }),
      async exportVendors(type) {
        this.filterData.export = type
        await this.$repositories.vendors.export(this.filterData)
      },
    async deleteVendor(id) {
      await this.deleteVendors({
        filterData: this.filterData,
        vendor_id: id,
      }).then((response) => {
        if (response.state == "fail") {
          this.$toast.error(response.message);
        }
        if (response.state == "success") {
          this.$toast.success(response.message);
          this.fetchActiveVendors();

        }
      }).catch((e) => {
      });
    },
      async filter() {
        await this.filterVendors(this.filterData).then(response => {
          if (response.state == 'fail') {
            this.$toast.error(response.message)
          }
          if (response.state == 'success') {
          }
        })
      },
    async changeVendorStatus(id, event) {

      await this.updateVendorStatus({
        filterData: this.filterData,
        vendor_id: id,
      }).then((response) => {
        if (response.state == "fail") {
          this.$toast.error(response.message);
          event.target.checked = !event.target.checked;
        }
        if (response.state == "success") {
          this.$toast.success(response.message);
          this.fetchActiveVendors();

        }
      })
      .catch((e) => {
        event.target.checked = !event.target.checked;
      });
      },
      async changeVendorStoreStatus(id, event) {
      await this.updateVendorStoreStatus({
        filterData: this.filterData,
        vendor_id: id,
      }).then((response) => {
        if (response.state == "fail") {
          this.$toast.error(response.message);
          event.target.checked = !event.target.checked;
        }
        if (response.state == "success") {
          this.$toast.success(response.message);
          this.fetchActiveVendors();

        }
      })
      .catch((e) => {
        event.target.checked = !event.target.checked;
      });
      },
       async changeVendorFeatured(id, event) {
      await this.updateVendorFeatured({
        filterData: this.filterData,
        vendor_id: id,
      }).then((response) => {
        if (response.state == "fail") {
          this.$toast.error(response.message);
          event.target.checked = !event.target.checked;
        }
        if (response.state == "success") {
          this.$toast.success(response.message);
          this.fetchActiveVendors();

        }
      })
      .catch((e) => {
        event.target.checked = !event.target.checked;
      });
      }

    },

    computed: {
      ...mapGetters({
        allVendors: 'Vendors/allVendors'
      })
    },
    watch: {
      allVendors(newCount, oldCount) {
        if (this.allVendors && this.allVendors != null && this.allVendors.data != null)   {
          this.rows = this.allVendors.data
          this.totalRows = this.allVendors.meta.total
          if (this.filterData.page != this.allVendors.meta.current_page) {
            this.filterData.page = this.allVendors.meta.current_page
          }
          if (this.filterData.perPage != this.allVendors.meta.per_page) {
            this.filterData.perPage = this.allVendors.meta.per_page
          }
        }
      }
    }
  }

</script>
