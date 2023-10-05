<template >

  <div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="row g-0">
          <div class="col-sm-12">
            <h2 class="m-0 text-body bold">{{this.$t("sidebar.permission")}}</h2>
          </div>
          <!-- /.col -->
          <div class="row">
            <div class="col-sm-12">
              <ol class="breadcrumb float-sm-right text-body">
                <li class="breadcrumb-item "><a href="#">{{this.$t("sidebar.home")}}</a></li>
                <li class="breadcrumb-item active">{{this.$t("sidebar.permission")}}</li>
              </ol>
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
        <div class="row mt-5 table-filter-row mx-0">
          <!-- Small boxes (Stat box) -->
          <div class="col-lg-8  ">
            <div class="row ">
              <div class="col-lg-4 col-md-6 mt-2">
                <div class="form-group position-relative">
                  <select class="form-control "
                          v-model="filterData.column">
                          <option value="" disabled>{{ $t('table.select_column')}}</option>
                          <option value="name">{{ $t('columns.name')}}</option>
                       </select>
                  <div class="position-absolute search-input-custom">
                    <fa :icon="['fas','angle-down']" fixed-width class="" />

                  </div>
                </div>

              </div>
              <div class="col-lg-6 col-md-6 mt-2 ">
                <div class="form-group position-relative">
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
          </div>

          <div class="col-md-4 mt-2 table-actions">
            <div slot="table-actions" class="align-middle">
              <button @click="exportPermissions('xlsx')"
                      class="btn btn-export rounded-circle shadow mx-1 ease-in-out">
                  <fa :icon="['fas', 'file-excel']" fixed-width />
                </button>
              <button @click="exportPermissions('csv')"
                      class="btn btn-export rounded-circle shadow mx-1 ease-in-out">
                  <fa :icon="['fas', 'file-csv']" fixed-width />
                </button>
              <button @click="exportPermissions('pdf')"
                      class="btn btn-export rounded-circle shadow mx-1 ease-in-out">
                  <fa :icon="['fas', 'file-pdf']" fixed-width />
                </button>
              <nuxt-link v-permission="'permissions.create'"
                         :to="localePath('/admin/permissions/create')">
                <button type="button"
                        class="btn btn-primary px-3 py-2"
                        name="button">
                    <fa :icon="['fas', 'plus']" fixed-width />
                    {{this.$t("dataTables.Add") }}
                  </button>
              </nuxt-link>
            </div>
          </div>
        </div>

        <div class="row my-4 data-tables-div p-3 m-0 rounded-md">
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
                          (event) => changePermissionStatus(props.row.id, event)
                        "
                        :checked="props.row.is_active == 1 ? 'checked' : ''"
                        type="checkbox"
                        id="flexSwitchCheckChecked"
                      />
                      <!-- <label class="form-check-label" for="flexSwitchCheckChecked">Checked switch checkbox input</label> -->
                    </div>
                  </div>
                  <div v-else-if="props.column.field == 'actions'">
                    <div class="dropdown">
                      <a
                        class="align-middle"
                        href="#"
                        permission="button"
                        id="dropdownMenuLink"
                        data-bs-toggle="dropdown"
                        aria-expanded="false"
                      >
                        <fa :icon="['fas', 'ellipsis-h']" fixed-width />
                      </a>

                    <ul
                      class="dropdown-menu"
                      aria-labelledby="dropdownMenuLink"
                    >
                      <li>
                        <button
                        v-permission="'permissions.delete'"
                          type="button"
                          class="dropdown-item"
                          name="button"
                          @click="deletePermission(props.row.id)"
                        >
                          {{ $t("delete")}}
                        </button>
                      </li>
                      <li>
                        <nuxt-link
                          v-permission="'permissions.update'"
                          :to="
                            localePath('/admin/permissions/edit/' + props.row.id)
                          "
                          ><button
                            type="button"
                            class="dropdown-item"
                            name="button"
                          >
                            {{ $t("edit")}}
                          </button></nuxt-link>
                        </li>
                      <!--  <li>
                          <nuxt-link
                            v-permission="'permissions.index'"
                            :to="
                              localePath('/admin/permissions/view/' + props.row.id)
                            "
                            ><button
                              type="button"
                              class="dropdown-item"
                              name="button"
                            >
                              {{ $t("show")}}
                            </button></nuxt-link
                          >
                        </li> -->
                      </ul>
                    </div>
                    <!-- <button type="button" class="btn btn-primary" name="button" @click="deletePermission(props.row.id)">Delete</button>
                             <nuxt-link v-permission="'permissions.update'" :to="localePath('/admin/permissions/edit/'+props.row.id)"><button type="button" class="btn btn-primary" name="button">Edit</button></nuxt-link>
                             <nuxt-link v-permission="'permissions.show'" :to="localePath('/admin/permissions/view/'+props.row.id)"><button type="button" class="btn btn-primary" name="button">Show</button></nuxt-link> -->
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
      permission: 'permissions.index',
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
            label: this.$t('columns.display_name'),
            field: 'display_name'
          },
          {
            label: this.$t('columns.actions'),
            field: 'actions',
            sortable: false
          },
          {
            label: this.$t('columns.created_at'),
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
      if (this.$gates.hasPermission('permissions.index')) {
        await this.fetchPermissions(this.page).then()
      }
    },
    methods: {
      ...mapActions({
        fetchPermissions: 'Permissions/fetchPermissions',
        fetchActivePermissions: 'General/fetchActivePermissions',
        deletePermissions: 'Permissions/deletePermissions',
        filterPermissions: 'Permissions/filterPermissions',
        updatePermissionStatus: 'Permissions/updatePermissionStatus',
      }),
      async exportPermissions(type) {
        this.filterData.export = type
        await this.$repositories.permissions.export(this.filterData)
      },
    async deletePermission(id) {
      await this.deletePermissions({
        filterData: this.filterData,
        permission_id: id,
      }).then((response) => {
        if (response.state == "fail") {
          this.$toast.error(response.message);
        }
        if (response.state == "success") {
          this.$toast.success(response.message);
          this.fetchActivePermissions();
        }
      }).catch((e) => {
      });
    },
      async filter() {
        await this.filterPermissions(this.filterData).then(response => {
          if (response.state == 'fail') {
            this.$toast.error(response.message)
          }
          if (response.state == 'success') {
          }
        })
      },
    async changePermissionStatus(id, event) {
      await this.updatePermissionStatus({
        filterData: this.filterData,
        permission_id: id,
      }).then((response) => {
        if (response.state == "fail") {
          this.$toast.error(response.message);
          event.target.checked = !event.target.checked;
        }
        if (response.state == "success") {
          this.$toast.success(response.message);
          this.fetchActivePermissions();
        }
      })
      .catch((e) => {
        event.target.checked = !event.target.checked;
      });
      }
    },

    computed: {
      ...mapGetters({
        allPermissions: 'Permissions/allPermissions',
      })
    },
    mounted() {},
    watch: {
      allPermissions(newCount, oldCount) {
        if (this.allPermissions && this.allPermissions != null && this.allPermissions.data != null)   {
          this.rows = this.allPermissions.data
          this.totalRows = this.allPermissions.meta.total
          if (this.filterData.page != this.allPermissions.meta.current_page) {
            this.filterData.page = this.allPermissions.meta.current_page
          }
          if (this.filterData.perPage != this.allPermissions.meta.per_page) {
            this.filterData.perPage = this.allPermissions.meta.per_page
          }
        }
      }
    }
  }

</script>
