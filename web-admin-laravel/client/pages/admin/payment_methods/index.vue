<template >

  <div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="row g-0">
          <div class="col-sm-12 px-0">
            <h2 class="m-0 text-body bold">{{this.$t("sidebar.payment_method")}}</h2>
          </div>
          <!-- /.col -->
          <div class="row">
            <div class="col-sm-12 px-0">
              <ol class="breadcrumb float-sm-right text-body">
                <li class="breadcrumb-item "><a href="#">{{this.$t("sidebar.home")}}</a></li>
                <li class="breadcrumb-item active">{{this.$t("sidebar.payment_method")}}</li>
              </ol>
              <p class="text-body-secondary">{{this.$t("payment_method.index_description")}}</p>
            </div>
            <!-- /.col -->
          </div>
        </div>
        <!-- /.row -->
    </div>

    <!-- Main content -->
    <section class="content">
 <div v-if="$fetchState.pending">
        <div class="container-fluid skeletion-effect">
          <div class="card gutter-b border-0">
            <div class="card-header p-0">
              <div class="row table-filter-row g-0">
                <!-- Small boxes (Stat box) -->
                <div class="col-md-6 col-lg-7">
                  <div class="filter-bar skeletion-animation"></div>
                </div>
                <div class="col-md-6 col-lg-5 col-xlg-6 table-actions px-0">
                  <div slot="table-actions" class="align-middle">
                    <div class="circle-btn skeletion-animation"></div>
                    <div class="circle-btn skeletion-animation"></div>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-body mt-2 data-tables-div py-0 m-0 rounded-md">
              <div class="col-md-12">
                <div class="vgt-wrap">
                  <!---->
                  <div class="vgt-inner-wrap">
                    <!---->
                    <!---->
                    <!---->
                    <div class="vgt-fixed-header"><!----></div>
                    <div class="vgt-responsive">
                      <table id="vgt-table" class="vgt-table striped">
                        <thead>
                          <tr>
                            <!---->
                            <th scope="col" class="line-numbers"></th>
                            <th>
                              <div class="heading skeletion-animation"></div>
                            </th>

                            <th>
                              <div class="heading skeletion-animation"></div>
                            </th>

                            <th>
                              <div class="heading skeletion-animation"></div>
                            </th>

                            <th>
                              <div class="heading skeletion-animation"></div>
                            </th>

                            <th>
                              <div class="heading skeletion-animation"></div>
                            </th>
                          </tr>
                          <!---->
                        </thead>

                        <tbody>
                          <!---->
                          <tr class="m-5">
                            <th class="line-numbers">
                              <div class="icon skeletion-animation"></div>
                            </th>
                            <td class="vgt-left-align">
                              <div class="heading skeletion-animation"></div>
                            </td>
                            <td class="vgt-left-align">
                              <div class="heading skeletion-animation"></div>
                            </td>
                            <td class="vgt-left-align">
                              <div class="switch skeletion-animation"></div>
                            </td>
                            <td class="vgt-left-align">
                              <div class="content skeletion-animation"></div>
                            </td>
                            <td class="vgt-left-align">
                              <div class="icon skeletion-animation"></div>
                              <div class="icon skeletion-animation"></div>
                              <div class="icon skeletion-animation"></div>
                            </td>
                          </tr>

                          <tr class="m-5">
                            <th class="line-numbers">
                              <div class="icon skeletion-animation"></div>
                            </th>
                            <td class="vgt-left-align">
                              <div class="heading skeletion-animation"></div>
                            </td>

                            <td class="vgt-left-align">
                              <div class="heading skeletion-animation"></div>
                            </td>
                            <td class="vgt-left-align">
                              <div class="switch skeletion-animation"></div>
                            </td>
                            <td class="vgt-left-align">
                              <div class="content skeletion-animation"></div>
                            </td>
                            <td class="vgt-left-align">
                              <div class="icon skeletion-animation"></div>
                              <div class="icon skeletion-animation"></div>
                              <div class="icon skeletion-animation"></div>
                            </td>
                          </tr>

                          <tr class="m-5">
                            <th class="line-numbers">
                              <div class="icon skeletion-animation"></div>
                            </th>
                            <td class="vgt-left-align">
                              <div class="heading skeletion-animation"></div>
                            </td>

                            <td class="vgt-left-align">
                              <div class="heading skeletion-animation"></div>
                            </td>
                            <td class="vgt-left-align">
                              <div class="switch skeletion-animation"></div>
                            </td>
                            <td class="vgt-left-align">
                              <div class="content skeletion-animation"></div>
                            </td>
                            <td class="vgt-left-align">
                              <div class="icon skeletion-animation"></div>
                              <div class="icon skeletion-animation"></div>
                              <div class="icon skeletion-animation"></div>
                            </td>
                          </tr>

                          <tr class="m-5">
                            <th class="line-numbers">
                              <div class="icon skeletion-animation"></div>
                            </th>
                            <td class="vgt-left-align">
                              <div class="heading skeletion-animation"></div>
                            </td>

                            <td class="vgt-left-align">
                              <div class="heading skeletion-animation"></div>
                            </td>
                            <td class="vgt-left-align">
                              <div class="switch skeletion-animation"></div>
                            </td>
                            <td class="vgt-left-align">
                              <div class="content skeletion-animation"></div>
                            </td>
                            <td class="vgt-left-align">
                              <div class="icon skeletion-animation"></div>
                              <div class="icon skeletion-animation"></div>
                              <div class="icon skeletion-animation"></div>
                            </td>
                          </tr>

                          <tr class="m-5">
                            <th class="line-numbers">
                              <div class="icon skeletion-animation"></div>
                            </th>
                            <td class="vgt-left-align">
                              <div class="heading skeletion-animation"></div>
                            </td>

                            <td class="vgt-left-align">
                              <div class="heading skeletion-animation"></div>
                            </td>
                            <td class="vgt-left-align">
                              <div class="switch skeletion-animation"></div>
                            </td>
                            <td class="vgt-left-align">
                              <div class="content skeletion-animation"></div>
                            </td>
                            <td class="vgt-left-align">
                              <div class="icon skeletion-animation"></div>
                              <div class="icon skeletion-animation"></div>
                              <div class="icon skeletion-animation"></div>
                            </td>
                          </tr>
                          <!---->
                        </tbody>
                        <!---->
                      </table>
                    </div>

                    <div class="vgt-wrap__footer vgt-clearfix">
                      <div class="footer__row-count vgt-pull-left">
                        <div class="content skeletion-animation"></div>
                      </div>
                      <div class="footer__navigation vgt-pull-right">
                        <div class="footer__navigation__page-info">
                          <div class="content skeletion-animation"></div>
                        </div>
                      </div>
                    </div>
                    <!---->
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="container-fluid" v-else>
         <div class="card gutter-b border-0" >
           <div class="card-header p-0">
             <div class="row table-filter-row g-0">
               <!-- Small boxes (Stat box) -->
               <div class="col-lg-8">
                 <div class="d-flex flex-column flex-md-row">
                    <select class="form-select custom-select" v-model="filterData.column">
                       <option value="" disabled>{{ $t("table.select_column") }}</option>
                       <option value="name">{{ $t("columns.name") }}</option>
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
                       <span @click="exportPaymentMethods('csv')">
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

                       <span @click="exportPaymentMethods('xlsx')">
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

                       <span @click="exportPaymentMethods('pdf')">
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
                     v-permission="'payment_method.create'"
                     :to="localePath('/admin/manufacturers/create')"
                   >
                     <button
                       type="button"
                       v-tooltip="{ content: 'Add payment_method' }"
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
                          (event) => changePaymentMethodStatus(props.row.id, event)
                        "
                        :checked="props.row.is_active == 1 ? 'checked' : ''"
                        type="checkbox"
                        id="flexSwitchCheckChecked"
                      />
                      <!-- <label class="form-check-label" for="flexSwitchCheckChecked">Checked switch checkbox input</label> -->
                    </div>
                  </div>
                  <div v-else-if="props.column.field == 'is_default'">
                    <div class="form-switch">
                      <input
                        class="form-check-input"
                        @change="
                          (event) => changeDefaultPaymentMethod(props.row.id, event)
                        "
                        :checked="props.row.is_default == 1 ? 'checked' : ''"
                        type="checkbox"
                        id="flexSwitchCheckChecked"
                      />
                      <!-- <label class="form-check-label" for="flexSwitchCheckChecked">Checked switch checkbox input</label> -->
                    </div>
                  </div>
                 <div v-else-if="props.column.field == 'actions'">
              <!--      <nuxt-link
                            v-permission="'payment_methods.index'" v-tooltip="{ content: 'Show' }"
                              class="btn btn-sm rounded-circle text-primary   "
                            :to="
                              localePath('/admin/payment_methods/view/' + props.row.id)
                            "
                            >
                              <fa :icon="['fas', 'eye']" fixed-width />
                           </nuxt-link
                          > -->
                          <nuxt-link
                          v-permission="'payment_methods.update'" v-tooltip="{ content: 'Edit' }"
                            class=" btn btn-md rounded-circle text-success   "
                          :to="
                            localePath('/admin/payment_methods/edit/' + props.row.id)
                          "
                          >
                            <fa :icon="['fas', 'edit']" fixed-width />
                          </nuxt-link>
                      <!-- Delete Button <button
                        v-permission="'payment_methods.delete'"
                          type="button" v-tooltip="{ content: 'Delete' }"
                          class="btn btn-sm rounded-circle text-danger   "
                          name="button" data-bs-toggle="modal" :data-bs-target="'#DeleteItem'+props.row.id"
                        >
                         <fa :icon="['fas', 'trash-alt']" fixed-width />
                        </button>
                                          <AdminDeleteModal :modal_id="'DeleteItem'+props.row.id" @deleteClicked="deletePaymentMethod(props.row.id)"  :delete_id="props.row.id">
                </AdminDeleteModal> -->
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
      permission: 'payment_methods.index',
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
            label: this.$t('columns.status'),
            field: 'is_active',
            sortable: false
          },
          {
            label: this.$t('columns.is_default'),
            field: 'is_default',
            sortable: false
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
      if (this.$gates.hasPermission('payment_methods.index')) {
        await this.fetchPaymentMethods(this.page).then()
      }
    },
    methods: {
      ...mapActions({
        fetchPaymentMethods: 'PaymentMethods/fetchPaymentMethods',
        fetchActivePaymentMethods: 'General/fetchActivePaymentMethods',
        deletePaymentMethods: 'PaymentMethods/deletePaymentMethods',
        filterPaymentMethods: 'PaymentMethods/filterPaymentMethods',
        updatePaymentMethodStatus: 'PaymentMethods/updatePaymentMethodStatus',
        updatePaymentMethodIsDefault: 'PaymentMethods/updatePaymentMethodIsDefault',
      }),
      async exportPaymentMethods(type) {
        this.filterData.export = type
        await this.$repositories.payment_methods.export(this.filterData)
      },
    async deletePaymentMethod(id) {
      await this.deletePaymentMethods({
        filterData: this.filterData,
        payment_method_id: id,
      }).then((response) => {
        if (response.state == "fail") {
          this.$toast.error(response.message);
        }
        if (response.state == "success") {
          this.$toast.success(response.message);
          this.fetchActivePaymentMethods();
        }
      }).catch((e) => {
      });
    },
      async filter() {
        await this.filterPaymentMethods(this.filterData).then(response => {
          if (response.state == 'fail') {
            this.$toast.error(response.message)
          }
          if (response.state == 'success') {
          }
        })
      },
    async changePaymentMethodStatus(id, event) {
      await this.updatePaymentMethodStatus({
        filterData: this.filterData,
        payment_method_id: id,
      }).then((response) => {
        if (response.state == "fail") {
          this.$toast.error(response.message);
          event.target.checked = !event.target.checked;
        }
        if (response.state == "success") {
          this.$toast.success(response.message);
          this.fetchActivePaymentMethods();
        }
      })
      .catch((e) => {
        event.target.checked = !event.target.checked;
      });
    },
    async changeDefaultPaymentMethod(id, event) {
      await this.updatePaymentMethodIsDefault({
        filterData: this.filterData,
        payment_method_id: id
      }).then(response => {
        if (response.state == 'fail') {
          this.$toast.error(response.message)
          event.target.checked = !event.target.checked
        }
        if (response.state == 'success') {
          this.$toast.success(response.message)
          this.fetchActivePaymentMethods();
        }
      })
    }
  },

    computed: {
      ...mapGetters({
        allPaymentMethods: 'PaymentMethods/allPaymentMethods'
      })
    },
    mounted() {},
    watch: {
      allPaymentMethods(newCount, oldCount) {
        if (this.allPaymentMethods && this.allPaymentMethods != null && this.allPaymentMethods.data != null)   {
          this.rows = this.allPaymentMethods.data
          this.totalRows = this.allPaymentMethods.meta.total
          if (this.filterData.page != this.allPaymentMethods.meta.current_page) {
            this.filterData.page = this.allPaymentMethods.meta.current_page
          }
          if (this.filterData.perPage != this.allPaymentMethods.meta.per_page) {
            this.filterData.perPage = this.allPaymentMethods.meta.per_page
          }
        }
      }
    }
  }

</script>
