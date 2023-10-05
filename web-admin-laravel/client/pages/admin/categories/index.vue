<template >

  <div >
    <!-- Content Header (Page header) -->
    <div class="content-header ">
        <div class="row g-0">
          <div class="col-sm-12 px-0">
            <h2 class="m-0 text-body bold">{{this.$t("sidebar.category")}}</h2>
          </div>
          <!-- /.col -->
          <div class="row">
            <div class="col-sm-12 px-0">
              <ol class="breadcrumb float-sm-right text-body">
                <li class="breadcrumb-item "><a href="#">{{this.$t("sidebar.home")}}</a></li>
                <li class="breadcrumb-item active">{{this.$t("sidebar.category")}}</li>
              </ol>
              <p class="text-body-secondary">{{this.$t("form.category.index_description")}}</p>
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
                         <div  v-bind:class="{ 'd-none': hideIcon }" class="position-absolute search-input-custom">
                    <fa :icon="['fas','search']" fixed-width class="" />

                  </div>
                </div></div>

        </div>
               <div class="col-lg-4 table-actions px-0">
                <div slot="table-actions" class="align-middle">
                  <div class="share">
                    <nav>
                      <span @click="exportCategories('csv')">
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

                      <span @click="exportCategories('xlsx')">
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

                      <span @click="exportCategories('pdf')">
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
                    v-permission="'categories.create'"
                    :to="localePath('/admin/categories/create')"
                  >
                    <button
                      type="button"
                      v-tooltip="{ content: 'Add Category' }"
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
                  </div>

                  <div v-else-if="props.column.field == 'icon'">

                      <img v-if="props.row.icon && props.row.icon.thumbnails && props.row.icon.thumbnails.small" v-bind:src=" url + `${props.row.icon.thumbnails.small.thumbnail}`" alt="" height="40px" width="40px">

                  </div>
                   <div v-else-if="props.column.field == 'parent_id'">

                      <span v-if="props.row.parent"> {{props.row.parent.name}} </span>

                  </div>
                  <div v-else-if="props.column.field == 'is_active'">
                    <div class="form-switch">
                      <input
                        class="form-check-input"
                        @change="
                          (event) => changeCategoryStatus(props.row.id, event)
                        "
                        :checked="props.row.is_active == 1 ? 'checked' : ''"
                        type="checkbox"
                        id="flexSwitchCheckChecked"
                      />
                    </div>
                  </div>
                       <div v-else-if="props.column.field == 'is_featured'">
                    <div class="form-switch">
                      <input
                        class="form-check-input"
                        @change="
                          (event) => changeCategoryStatus(props.row.id, event)
                        "
                        :checked="props.row.is_featured == 1 ? 'checked' : ''"
                        type="checkbox"
                        id="flexSwitchCheckChecked"
                        disabled
                      />
                    </div>
                  </div>
                    <div v-else-if="props.column.field == 'actions'">
                    <nuxt-link
                            v-permission="'categories.index'" v-tooltip="{ content: 'Show' }"
                              class="btn btn-sm rounded-circle text-primary   "
                            :to="
                              localePath('/admin/categories/view/' + props.row.id)
                            "
                            >
                              <fa :icon="['fas', 'eye']" fixed-width />
                            </nuxt-link
                          >
                          <nuxt-link
                          v-permission="'categories.update'" v-tooltip="{ content: 'Edit' }"
                            class=" btn btn-sm rounded-circle text-success   "
                          :to="
                            localePath('/admin/categories/edit/' + props.row.id)
                          "
                          >
                            <fa :icon="['fas', 'edit']" fixed-width />
                          </nuxt-link>
                       <button
                        v-permission="'categories.delete'" v-tooltip="{ content: 'Delete' }"
                          type="button"
                          class="btn btn-sm rounded-circle text-danger   "
                          name="button" data-bs-toggle="modal" :data-bs-target="'#DeleteItem'+props.row.id"

                        >
                         <fa :icon="['fas', 'trash-alt']" fixed-width />
                        </button>
                                          <AdminDeleteModal :modal_id="'DeleteItem'+props.row.id" @deleteClicked="deleteCategory(props.row.id)"  :delete_id="props.row.id">
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
      permission: 'categories.index',
      strategy: 'read'
    },
    mixins: [datatableMixin],
    data() {
      return {
           url: '/backend',
        columns: [
          {
            label: this.$t('columns.name'),
            field: 'name'
          },
           {
            label: this.$t('columns.icon'),
            field: 'icon',
            sortable: false
          },
          {
            label: this.$t('columns.slug'),
            field: 'slug'
          },
          {
            label: this.$t('columns.parent'),
            field: 'parent_id'
          },
          {
            label: this.$t('columns.status'),
            field: 'is_active'
          },
            {
            label: this.$t('columns.is_featured'),
            field: 'is_featured'
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
      if (this.$gates.hasPermission('categories.index')) {
        await this.fetchCategories(this.page).then()
      }
    },
    methods: {
      ...mapActions({
        fetchCategories: 'Categories/fetchCategories',
        fetchActiveInactiveCategories: 'General/fetchActiveInactiveCategories',
        fetchActiveCategories: 'General/fetchActiveCategories',
        deleteCategories: 'Categories/deleteCategories',
        filterCategories: 'Categories/filterCategories',
        updateCategoryStatus: 'Categories/updateCategoryStatus',
      }),
      async exportCategories(type) {
        this.filterData.export = type
        await this.$repositories.categories.export(this.filterData)
      },
    async deleteCategory(id) {
      await this.deleteCategories({
        filterData: this.filterData,
        category_id: id,
      }).then((response) => {
        if (response.state == "fail") {
          this.$toast.error(response.message);
        }
        if (response.state == "success") {
          this.$toast.success(response.message);
          this.fetchActiveInactiveCategories();
          this.fetchActiveCategories();
        }
      }).catch((e) => {
      });
    },
      async filter() {
        await this.filterCategories(this.filterData).then(response => {
          if (response.state == 'fail') {
            this.$toast.error(response.message)
          }
          if (response.state == 'success') {
          }
        })
      },
    async changeCategoryStatus(id, event) {
      await this.updateCategoryStatus({
        filterData: this.filterData,
        category_id: id,
      }).then((response) => {
        if (response.state == "fail") {
          this.$toast.error(response.message);
          event.target.checked = !event.target.checked;
        }
        if (response.state == "success") {
          this.$toast.success(response.message);
          this.fetchActiveInactiveCategories();
          this.fetchActiveCategories();
        }
      })
      .catch((e) => {
        event.target.checked = !event.target.checked;
      });
      }
    },

    computed: {
      ...mapGetters({
        allCategories: 'Categories/allCategories'
      })
    },
    mounted() {},
    watch: {
      allCategories(newCount, oldCount) {
        if (this.allCategories && this.allCategories != null && this.allCategories.data != null)   {
          this.rows = this.allCategories.data
          this.totalRows = this.allCategories.meta.total
          if (this.filterData.page != this.allCategories.meta.current_page) {
            this.filterData.page = this.allCategories.meta.current_page
          }
          if (this.filterData.perPage != this.allCategories.meta.per_page) {
            this.filterData.perPage = this.allCategories.meta.per_page
          }
        }
      }
    }
  }

</script>
