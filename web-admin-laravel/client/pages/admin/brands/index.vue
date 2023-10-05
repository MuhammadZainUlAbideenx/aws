<template >

  <div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="row g-0">
          <div class="col-sm-12 px-0">
            <h2 class="m-0 text-body bold">{{this.$t("sidebar.brand")}}</h2>
          </div>
          <!-- /.col -->
          <div class="row">
            <div class="col-sm-12 px-0">
              <ol class="breadcrumb float-sm-right text-body">
                <li class="breadcrumb-item "><a href="#">{{this.$t("sidebar.home")}}</a></li>
                <li class="breadcrumb-item active">{{this.$t("sidebar.brand")}}</li>
              </ol>
              <p class="text-body-secondary">{{this.$t("form.brand.index_description")}}</p>
            </div>
            <!-- /.col -->
          </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- Main content -->
    <section class="content">
        <div v-if="$fetchState.pending">
              <AdminTableLoader :image='true'/>
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
		    <div class="row g-0 input-group">
               <div class="col-md-4 col-lg-3 form-group position-relative">

                </div>
                 <div class="vl"></div>



            </div>

        </div>
              <div class="col-lg-4 table-actions px-0">
                <div slot="table-actions" class="align-middle">
                  <div class="share">
                    <nav>
                      <span @click="exportBrands('csv')">
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

                      <span @click="exportBrands('xlsx')">
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

                      <span @click="exportBrands('pdf')">
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
                    v-permission="'brands.create'"
                    :to="localePath('/admin/brands/create')"
                  >
                    <button
                      type="button"
                      v-tooltip="{ content: 'Add Brand' }"
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
                  <div v-if="props.column.field == 'image'">

                      <img v-if="props.row.image && props.row.image.thumbnails && props.row.image.thumbnails.small" v-bind:src=" url + `${props.row.image.thumbnails.small.thumbnail}`" alt="" height="40px" width="40px">
                      <!-- <label class="form-check-label" for="flexSwitchCheckChecked">Checked switch checkbox input</label> -->

                  </div>
                  <div v-else-if="props.column.field == 'is_active'">
                    <div class="form-switch">
                      <input
                        class="form-check-input"
                        @change="
                          (event) => changeBrandStatus(props.row.id, event)
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
                            v-permission="'brands.index'"  class="btn btn-sm rounded-circle text-primary   "
                            :to="
                              localePath('/admin/brands/view/' + props.row.id)
                            "
                            >
                              <fa :icon="['fas', 'eye']" fixed-width />
                            </nuxt-link
                          >
                          <nuxt-link
                          v-permission="'brands.update'"  class="btn btn-sm rounded-circle text-success  "
                          :to="
                            localePath('/admin/brands/edit/' + props.row.id)
                          "
                          >
                            <fa :icon="['fas', 'edit']" fixed-width />
                          </nuxt-link>
                       <button
                        v-permission="'brands.delete'" v-tooltip="{ content: 'Delete' }"
                          type="button"
                          class="btn btn-sm text-danger   "
                          name="button" data-bs-toggle="modal" :data-bs-target="'#DeleteItem'+props.row.id"

                        >
                         <fa :icon="['fas', 'trash-alt']" fixed-width />
                        </button>
                                          <AdminDeleteModal :modal_id="'DeleteItem'+props.row.id" @deleteClicked="deleteBrand(props.row.id)"  :delete_id="props.row.id">
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
      permission: 'brands.index',
      strategy: 'read'
    },
    mixins: [datatableMixin],
    data() {
      return {
          url: '/backend',
        columns: [
          {
            label: this.$t('columns.name'),
            field: 'name',
          },
           {
            label: this.$t('columns.image'),
            field: 'image',
            sortable: false
          },
          {
            label: this.$t('columns.status'),
            field: 'is_active',
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
      if (this.$gates.hasPermission('brands.index')) {
        await this.fetchBrands(this.page).then()
      }
    },
    methods: {
      ...mapActions({
        fetchBrands: 'Brands/fetchBrands',
        fetchActiveBrands: 'General/fetchActiveBrands',
        deleteBrands: 'Brands/deleteBrands',
        filterBrands: 'Brands/filterBrands',
        updateBrandStatus: 'Brands/updateBrandStatus',
      }),
      async exportBrands(type) {
        this.filterData.export = type
        await this.$repositories.brands.export(this.filterData)
      },
    async deleteBrand(id) {
      await this.deleteBrands({
        filterData: this.filterData,
        brand_id: id,
      }).then((response) => {
        if (response.state == "fail") {
          this.$toast.error(response.message);
        }
        if (response.state == "success") {
          this.$toast.success(response.message);
          this.fetchActiveBrands();

        }
      }).catch((e) => {
      });
    },
      async filter() {
        await this.filterBrands(this.filterData).then(response => {
          if (response.state == 'fail') {
            this.$toast.error(response.message)
          }
          if (response.state == 'success') {
          }
        })
      },
    async changeBrandStatus(id, event) {
      await this.updateBrandStatus({
        filterData: this.filterData,
        brand_id: id,
      }).then((response) => {
        if (response.state == "fail") {
          this.$toast.error(response.message);
          event.target.checked = !event.target.checked;
        }
        if (response.state == "success") {
          this.$toast.success(response.message);
          this.fetchActiveBrands();
        }
      })
      .catch((e) => {
        event.target.checked = !event.target.checked;
      });
    },
    async changeDefaultBrand(id, event) {
      await this.updateBrandIsDefault({
        filterData: this.filterData,
        order_status_id: id
      }).then(response => {
        if (response.state == 'fail') {
          this.$toast.error(response.message)
          event.target.checked = !event.target.checked
        }
        if (response.state == 'success') {
          this.$toast.success(response.message)
          this.fetchActiveBrand();
        }
      })
    }
    },

    computed: {
      ...mapGetters({
        allBrands: 'Brands/allBrands'
      })
    },
    mounted() {},
    watch: {
      allBrands(newCount, oldCount) {
        if (this.allBrands && this.allBrands != null && this.allBrands.data != null)   {
          this.rows = this.allBrands.data
          this.totalRows = this.allBrands.meta.total
          if (this.filterData.page != this.allBrands.meta.current_page) {
            this.filterData.page = this.allBrands.meta.current_page
          }
          if (this.filterData.perPage != this.allBrands.meta.per_page) {
            this.filterData.perPage = this.allBrands.meta.per_page
          }
        }
      }
    }
  }

</script>
