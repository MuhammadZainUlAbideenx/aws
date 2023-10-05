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
            <h2 class="m-0 text-body bold">{{this.$t("sidebar.seo_page")}}</h2>
          </div>
          <!-- /.col -->
          <div class="row">
            <div class="col-sm-12 px-0">
              <ol class="breadcrumb float-sm-right text-body">
                <li class="breadcrumb-item "><a href="#">{{this.$t("sidebar.home")}}</a></li>
                <li class="breadcrumb-item active">{{this.$t("sidebar.seo_page")}}</li>
              </ol>
              <p class="text-body-secondary">{{this.$t("seo_page.index_description")}}</p>
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
        <div class="row table-filter-row g-0 justify-content-end">
          <!-- Small boxes (Stat box) -->
              <div class="col-md-6 col-lg-7">
		    <div class="row g-0 input-group">
               <div class="col-md-4 col-lg-3 form-group position-relative">
                  <select class="form-select "
                          v-model="filterData.column">
                          <option value="" disabled>{{ $t('table.select_column')}}</option>
                          <option value="name">{{ $t('columns.name')}}</option>
                       </select>

                </div>
                 <div class="vl"></div>
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
                 <div class="col-md-6 col-lg-5 col-xlg-6 table-actions px-0">
                <div slot="table-actions" class="align-middle">
                  <div class="share">
                    <nav>
                      <span @click="exportSeoPages('csv')">
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

                      <span @click="exportSeoPages('xlsx')">
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

                      <span @click="exportSeoPages('pdf')">
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
                    v-permission="'seo_pages.create'"
                    :to="localePath('/admin/seo_pages/create')"
                  >
                    <button
                      type="button"
                      v-tooltip="{ content: 'Add Seo Page' }"
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
                           <div v-if="props.column.field == 'actions'">
                    <nuxt-link
                            v-permission="'seo_pages.index'"  v-tooltip="{ content: 'Show' }"
                              class="btn btn-sm rounded-circle text-primary   "
                            :to="
                              localePath('/admin/seo_pages/view/' + props.row.seo.id)
                            "
                            >
                              <fa :icon="['fas', 'eye']" fixed-width />
                            </nuxt-link
                          >
                          <nuxt-link
                          v-permission="'seo_pages.update'" v-tooltip="{ content: 'Edit' }"
                            class=" btn btn-sm rounded-circle text-success   "
                          :to="
                            localePath('/admin/seo_pages/edit/' + props.row.seo.id)
                          "
                          >
                            <fa :icon="['fas', 'edit']" fixed-width />
                         </nuxt-link>
                       <button
                        v-permission="'seo_pages.delete'"
                          type="button"  v-tooltip="{ content: 'Delete' }"
                          class="btn btn-sm rounded-circle text-danger  "
                          name="button" data-bs-toggle="modal" :data-bs-target="'#DeleteItem'+props.row.seo.id">
                         <fa :icon="['fas', 'trash-alt']" fixed-width />
                        </button>
                                             <AdminDeleteModal :modal_id="'DeleteItem'+props.row.seo.id" @deleteClicked="deleteSeoPage(props.row.seo.id)"  :delete_id="props.row.seo.id">
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
    middleware: ['admin', 'permission'],
    meta: {
      permission: 'seo_pages.index',
      strategy: 'read'
    },
    mixins: [datatableMixin],
    data() {
      return {
        columns: [
          {
            label: this.$t('columns.title'),
            field: 'seo.title',
          },
          {
            label: this.$t('columns.description'),
            field: 'seo.description'
          },
          {
            label: this.$t('columns.keywords'),
            field: 'seo.keywords',
          },
          {
            label: this.$t('columns.product'),
            field: 'seo.product.name',
          },
          {
            label: this.$t('columns.type'),
            field: 'seo.seo_type_text',
          },

          {
            label: this.$t('columns.created_at'),
            field: 'seo.created_at',
            sortable: false
            // type: 'date',
            // dateInputFormat: 'Y-M-d',
            // dateOutputFormat: 'MMM do yy',
          },
          {
            label: this.$t('columns.actions'),
            field: 'actions',
            sortable: false
          },
        ]
      }
    },
    async fetch() {
      if (this.$gates.hasPermission('seo_pages.index')) {
        await this.fetchSeoPages(this.page).then()
      }
    },
    methods: {
      ...mapActions({
        fetchSeoPages: 'SeoPages/fetchSeoPages',
        fetchActiveSeoPages: 'General/fetchActiveSeoPages',
        deleteSeoPages: 'SeoPages/deleteSeoPages',
        filterSeoPages: 'SeoPages/filterSeoPages',
        updateSeoPageStatus: 'SeoPages/updateSeoPageStatus',
        updateSeoPageIsDefault: 'SeoPages/updateSeoPageIsDefault'
      }),
      async exportSeoPages(type) {
        this.filterData.export = type
        await this.$repositories.seo_pages.export(this.filterData)
      },
    async deleteSeoPage(id) {
      await this.deleteSeoPages({
        filterData: this.filterData,
        seo_page_id: id,
      }).then((response) => {
        if (response.state == "fail") {
          this.$toast.error(response.message);
        }
        if (response.state == "success") {
          this.$toast.success(response.message);
          this.fetchActiveSeoPages();
        }
      }).catch((e) => {
      });
    },
      async filter() {
        await this.filterSeoPages(this.filterData).then(response => {
          if (response.state == 'fail') {
            this.$toast.error(response.message)
          }
          if (response.state == 'success') {
          }
        })
      },
      async changeDefaultSeoPage(id, event) {
        await this.updateSeoPageIsDefault({
          filterData: this.filterData,
          seo_page_id: id
        }).then(response => {
          if (response.state == 'fail') {
            this.$toast.error(response.message)
            event.target.checked = !event.target.checked
          }
          if (response.state == 'success') {
            this.$toast.success(response.message)
            this.fetchActiveSeoPages();
          }
        })
      },
    async changeSeoPageStatus(id, event) {
      await this.updateSeoPageStatus({
        filterData: this.filterData,
        seo_page_id: id,
      }).then((response) => {
        if (response.state == "fail") {
          this.$toast.error(response.message);
          event.target.checked = !event.target.checked;
        }
        if (response.state == "success") {
          this.$toast.success(response.message);
          this.fetchActiveSeoPages();
        }
      })
      .catch((e) => {
        event.target.checked = !event.target.checked;
      });
      }
    },

    computed: {
      ...mapGetters({
        allSeoPages: 'SeoPages/allSeoPages'
      })
    },
    mounted() {},
    watch: {
      allSeoPages(newCount, oldCount) {
        if (this.allSeoPages && this.allSeoPages != null && this.allSeoPages.data != null)   {
          this.rows = this.allSeoPages.data
          this.totalRows = this.allSeoPages.meta.total
          if (this.filterData.page != this.allSeoPages.meta.current_page) {
            this.filterData.page = this.allSeoPages.meta.current_page
          }
          if (this.filterData.perPage != this.allSeoPages.meta.per_page) {
            this.filterData.perPage = this.allSeoPages.meta.per_page
          }
        }
      }
    }
  }

</script>
s
