<template >

  <div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="row g-0" >
          <div class="col-sm-12 px-0">
            <h2 class="m-0 text-body bold">{{this.$t("sidebar.Language")}}</h2>
          </div>
          <!-- /.col -->
          <div class="row">
            <div class="col-sm-12 px-0">
              <ol class="breadcrumb float-sm-right text-body">
                <li class="breadcrumb-item "><a href="#">{{this.$t("sidebar.Home")}}</a></li>
                <li class="breadcrumb-item active">{{this.$t("sidebar.Language")}}</li>
              </ol>
              <p class="text-body-secondary">{{this.$t("sidebar.Description")}}</p>
            </div>
            <!-- /.col -->
          </div>
        </div>
        <!-- /.row -->
    </div>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
         <div class="card gutter-b border-0" >
           <div class="card-header p-0">
        <div class="row table-filter-row">
              <div class="col-md-6 col-lg-7">
		    <div class="row g-0 input-group">
               <div class="col-md-4 col-lg-3 form-group position-relative">
                  <select class="form-select"
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
                         <div  v-bind:class="{ 'd-none': hideIcon }" class="position-absolute search-input-custom">
                    <fa :icon="['fas','search']" fixed-width class="" />

                  </div>
                </div>


            </div>

        </div>
               <div class="col-md-6 col-lg-5 col-xlg-6 table-actions px-0">
            <div slot="table-actions" class="align-middle">
              <button @click="exportLanguages('xlsx')"
                     class="btn btn-export rounded-circle shadow mx-1 ease-in-out">
                 <img src="~/assets/images/excel.png" alt="" height="20px" width="20px">
                </button>
              <button @click="exportLanguages('csv')"
                      class="btn btn-export rounded-circle shadow mx-1 ease-in-out">
                  <img src="~/assets/images/csv.png" alt="" height="20px" width="20px">
                </button>
              <button @click="exportLanguages('pdf')"
                      class="btn btn-export rounded-circle shadow mx-1 ease-in-out">
                   <img src="~/assets/images/pdf.png" alt="" height="20px" width="20px">
                </button>
              <nuxt-link v-permission="'languages.create'"
                         :to="localePath('/admin/tabs/create')">
                <button type="button"
                         class="btn add btn-primary px-3 shadow  rounded-circle"
                        name="button">
                    <fa :icon="['fas', 'plus']" fixed-width />
                  </button>
              </nuxt-link>
            </div>
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
                  <div v-if="props.column.field == 'is_default'">
                    <div class="form-switch">
                      <input
                        class="form-check-input"
                        @change="
                          (event) => changeDefaultLanguage(props.row.id, event)
                        "
                        :checked="props.row.is_default == 1 ? 'checked' : ''"
                        type="checkbox"
                        id="flexSwitchCheckChecked"
                      />
                      <!-- <label class="form-check-label" for="flexSwitchCheckChecked">Checked switch checkbox input</label> -->
                    </div>
                  </div>
                  <div v-else-if="props.column.field == 'status'">
                    <div class="form-switch">
                      <input
                        class="form-check-input"
                        @change="
                          (event) => changeLanguageStatus(props.row.id, event)
                        "
                        :checked="props.row.status == 1 ? 'checked' : ''"
                        type="checkbox"
                        id="flexSwitchCheckChecked"
                      />
                      <!-- <label class="form-check-label" for="flexSwitchCheckChecked">Checked switch checkbox input</label> -->
                    </div>
                  </div>
                  <div v-else-if="props.column.field == 'actions'">
                    <nuxt-link
                            v-permission="'languages.index'" class="btn btn-sm rounded-circle text-primary   "
                               v-tooltip="{ content: 'Show' }"
                            :to="
                              localePath('/admin/languages/view/' + props.row.id)
                            "
                            >
                              <fa :icon="['fas', 'eye']" fixed-width />
                           </nuxt-link
                          >
                          <nuxt-link
                          v-permission="'languages.update'" class=" btn btn-sm rounded-circle text-success   "
                             v-tooltip="{ content: 'Edit' }"
                          :to="
                            localePath('/admin/languages/edit/' + props.row.id)
                          "
                          >
                            <fa :icon="['fas', 'edit']" fixed-width />
                         </nuxt-link>
                       <button
                        v-permission="'languages.delete'" v-tooltip="{ content: 'Delete' }"
                          type="button"
                          class="btn btn-sm rounded-circle text-danger   "
                          name="button" data-bs-toggle="modal" :data-bs-target="'#DeleteItem'+props.row.id"

                        >
                         <fa :icon="['fas', 'trash-alt']" fixed-width />
                        </button>
                                          <AdminDeleteModal :modal_id="'DeleteItem'+props.row.id" @deleteClicked="deleteManufacturer(props.row.id)"  :delete_id="props.row.id">
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
            <div v-if="$fetchState.pending">
              <h1>{{$t('loader_shows_here')}}</h1>
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
      permission: 'languages.index',
      strategy: 'read'
    },
    mixins: [datatableMixin],
    data() {
      return {
        columns: [

          {
            label: this.$t('column.name'),
            field: 'name'
          },
          {
            label: this.$t('column.code'),
            field: 'code'
          },
          {
            label: this.$t('column.direction'),
            field: 'direction'
          },
          {
            label: this.$t('column.is_default'),
            field: 'is_default'
          },
          {
            label: this.$t('column.status'),
            field: 'status'
          },
          {
            label: this.$t('column.actions'),
            field: 'actions',
            sortable: false
          },
          {
            label: this.$t('column.created_at'),
            field: 'created_at',
            sortable: false
            // type: 'date',
            // dateInputFormat: 'Y-M-d',
            // dateOutputFormat: 'MMM do yy',
          }
        ]
      }
    },
    async fetch() {
      if (this.$gates.hasPermission('languages.index')) {
        await this.fetchLanguages(this.page).then()
      }
    },
    methods: {
      ...mapActions({
        fetchLanguages: 'Languages/fetchLanguages',
        fetchActiveLanguages: 'Languages/fetchActiveLanguages',
        deleteLanguages: 'Languages/deleteLanguages',
        filterLanguages: 'Languages/filterLanguages',
        updateLanguageStatus: 'Languages/updateLanguageStatus',
        updateLanguageIsDefault: 'Languages/updateLanguageIsDefault'
      }),
      async exportLanguages(type) {
        this.filterData.export = type
        await this.$repositories.languages.export(this.filterData)
      },
    async deleteLanguage(id) {
      await this.deleteLanguages({
        filterData: this.filterData,
        language_id: id,
      }).then((response) => {
        if (response.state == "fail") {
          this.$toast.error(response.message);
        }
        if (response.state == "success") {
          this.$toast.success(response.message);
          this.fetchActiveLanguages();
        }
      }).catch((e) => {
      });
    },
      async filter() {
        await this.filterLanguages(this.filterData).then(response => {
          if (response.state == 'fail') {
            this.$toast.error(response.message)
          }
          if (response.state == 'success') {
          }
        })
      },
      async changeDefaultLanguage(id, event) {
        await this.updateLanguageIsDefault({
          filterData: this.filterData,
          language_id: id
        }).then(response => {
          if (response.state == 'fail') {
            this.$toast.error(response.message)
            event.target.checked = !event.target.checked
          }
          if (response.state == 'success') {
            this.$toast.success(response.message)
          }
        })
      },
    async changeLanguageStatus(id, event) {
      await this.updateLanguageStatus({
        filterData: this.filterData,
        language_id: id,
      }).then((response) => {
        if (response.state == "fail") {
          this.$toast.error(response.message);
          event.target.checked = !event.target.checked;
        }
        if (response.state == "success") {
          this.$toast.success(response.message);
          this.fetchActiveLanguages();
        }
      })
      .catch((e) => {
        event.target.checked = !event.target.checked;
      });
      }
    },

    computed: {
      ...mapGetters({
        allLanguages: 'Languages/allLanguages'
      })
    },
    mounted() {},
    watch: {
      allLanguages(newCount, oldCount) {
        if (this.allLanguages && this.allLanguages != null && this.allLanguages.data != null)   {
          this.rows = this.allLanguages.data
          this.totalRows = this.allLanguages.meta.total
          if (this.filterData.page != this.allLanguages.meta.current_page) {
            this.filterData.page = this.allLanguages.meta.current_page
          }
          if (this.filterData.perPage != this.allLanguages.meta.per_page) {
            this.filterData.perPage = this.allLanguages.meta.per_page
          }
        }
      }
    }
  }

</script>
