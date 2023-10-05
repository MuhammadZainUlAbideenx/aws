<template >
  <div class="" v-if="!this.$auth.user.store">
    <SellerShopSettings />
  </div>
  <div class="" v-else-if="!this.$auth.user.is_active">
    <SellerShopDeactive />
  </div>
  <section v-else-if="$fetchState.pending" class="my-profile-page m-0">
    <AdminLoader />
  </section>
  <section v-else class="my-profile-page m-0">
    <div class="container">
      <div class="row mt-5">
        <div class="my-wallet-sec">
          <div class="wallet-cont">
            <div class="row">
              <div class="col-md-4">
                <div class="wallet-sec wallet">
                  <h4>{{$t('web.customer.wallet.current_balance')}}</h4>
                  <p class="fs-2 fw-bold text-body opacity-3 m-0">
                    {{ wallet ? wallet.balance : 0 }}
                  </p>
                </div>
              </div>
              <div class="col-md-4">
                <div class="wallet-sec deposits">
                  <h4>{{$t('web.customer.wallet.deposits')}}</h4>
                  <p class="fs-2 fw-bold text-body opacity-3 m-0">
                    {{ wallet ? wallet.total_deposit : 0 }}
                  </p>
                </div>
              </div>
              <div class="col-md-4">
                <div class="wallet-sec refunds">
                  <h4>{{$t('web.customer.wallet.options.withdraw')}}</h4>
                  <p class="fs-2 fw-bold text-body opacity-3 m-0">
                    {{ wallet ? wallet.total_withdraw :0 }}
                  </p>
                </div>
              </div>
              <!-- <div class="col-3">
                <div class="wallet-sec bonus">
                  <h4>Refunds</h4>
                  <p class="fs-2 fw-bold text-body opacity-3 m-0">
                    {{ wallet ? wallet.total_refund : 0 }}
                  </p>
                </div>
              </div> -->
            </div>
          </div>
          <div
            class="
              wallet-filter
              d-flex
              align-items-center
              justify-content-between
              flex-column flex-md-row
            "
          >
            <div class="dropdown-fild flex-column flex-md-row my-3">
              <label for="item-per-page" class="form-label text-medium me-2"
                >{{$t('web.customer.wallet.transactions')}}</label
              >
              <select
                class="form-select"
                id="item-per-page"
                aria-describedby="item-per-pageFeedback"
                placeholder="All"
                required
              >
                <option disabled selected hidden value="">{{$t('web.customer.wallet.options.all')}}</option>
                <option>{{$t('web.customer.wallet.deposits')}}</option>
                <!-- <option>Refund</option> -->
                <option>{{$t('web.customer.wallet.options.withdraw')}}</option>
              </select>
            </div>
            <div class="d-flex">
              <button
                type="button"
                class="
                  btn
                  bg-primary
                  rounded
                  fw-bold
                  text-uppercase
                  me-3
                  text-white
                "
                data-bs-toggle="modal"
                data-bs-target="#withdrawAmountModel"
              >
              {{$t('web.customer.wallet.withdraw_amount')}}
              </button>
              <!-- Button trigger modal -->
              <!-- Modal -->
              <div
                class="modal fade"
                id="withdrawAmountModel"
                tabindex="-1"
                aria-labelledby="withdrawAmountModelLabel"
                aria-hidden="true"
              >
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="withdrawAmountModelLabel">
                       {{$t('web.customer.wallet.withdraw_amount')}}
                      </h5>
                      <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                      ></button>
                    </div>
                    <div class="modal-body">
                      <div v-if="loading"><AdminLoader /></div>
                      <div v-else>
                        <div class="form-group">
                          <label for="review_message"> {{$t('columns.amount')}}:</label>
                          <input
                            type="number"
                            required
                            class="form-control"
                            placeholder="Enter withdraw amount"
                            v-model="withdraw.amount"
                          />
                        </div>
                        <div class="form-group">
                          <label for="review_message"> {{$t('columns.note')}}:</label>
                          <input
                            type="text"
                            required
                            class="form-control"
                            placeholder="Enter Note e.g Bank Name"
                            v-model="withdraw.note"
                          />
                        </div>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal"
                      >
                        {{$t('web.customer.wallet.close')}}
                      </button>
                      <button
                        type="submit"
                        v-on:click="submit()"
                        class="btn btn-primary"
                      >
                        {{$t('web.customer.wallet.save_changes')}}
                      </button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- End Modal -->
            </div>
          </div>
          <div class="card-body p-0">
            <div class="col-md-12">
              <vue-good-table
                v-if="!$fetchState.pending && allTransactions.length != 0"
                mode="remote"
                :columns="columns"
                :rows="rows"
                :totalRows="totalRows"
                @on-page-change="onPageChange"
                @on-sort-change="onSortChange"
                @on-per-page-change="onPerPageChange"
                :line-numbers="true"
                styleClass="vgt-table striped"
                row-style-class="m-5"
                :pagination-options="{
                  mode: 'pages',
                  enabled: true,
                  perPage: allTransactions.meta.perPage,
                  setCurrentPage: allTransactions.meta.page,
                  nextLabel: pagination.nextLabel,
                  prevLabel: pagination.prevLabel,
                  rowsPerPageLabel: pagination.rowsPerPageLabel,
                  ofLabel: pagination.ofLabel,
                  pageLabel: pagination.pageLabel, // for 'pages' mode
                  allLabel: pagination.allLabel,
                }"
              >
                <template slot="table-row" slot-scope="props">
                  <span>
                    {{ props.formattedRow[props.column.field] }}
                  </span>
                </template>
              </vue-good-table>
              <div slot="emptystate" v-if="allTransactions.length == 0">
                <div class="wallet-history">
                  <div class="empty-wallet d-flex flex-column pt-5">
                    <fa :icon="['fas', 'folder-open']" class="opacity-5" />
                    <p class="mx-auto mb-0"> {{$t("web.customer.wallet.you_any_record")}}</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>
<script >
import datatableMixin from "~/mixins/datatableMixin.js";
export default {
  mixins: [datatableMixin],
  layout: "vendor",
  middleware: ["vendor"],
  meta: {
    permission: "wallet.index",
    strategy: "read",
  },
  data() {
    return {
      currentlyActiveTemplate: "",
      loading: false,
      wallet: {},
      allTransactions: [],
      all_errors: "",
      url: "/backend",
      withdraw: {
        amount: "",
        vendor_id: this.$auth.user.id,
        note: "",
      },
      details: {
        payment_method_code: "",
        number: "",
        exp_month: "",
        exp_year: "",
        cvc: "",
        phone_number: "",
        paytm_mode: "",
      },

      columns: [
        {
          label: this.$t("columns.transaction_id"),
          field: "transaction_id",
          sortable: false,
        },
        {
          label: this.$t("columns.transaction_type"),
          field: "transaction_type",
          sortable: false,
        },
        {
          label: this.$t("columns.cash_in"),
          field: "cash_in",
          sortable: false,
        },
        {
          label: this.$t("columns.cash_out"),
          field: "cash_out",
          sortable: false,
        },
        {
          label: this.$t("columns.opening_balance"),
          field: "opening_balance",
          sortable: false,
        },
        {
          label: this.$t("columns.closing_balance"),
          field: "closing_balance",
          sortable: false,
        },
        {
          label: this.$t("columns.description"),
          field: "description",
          sortable: false,
        },
      ],
    };
  },
  created() {},
  async fetch() {
    await this.getWalletBalance();
    await this.getWalletTransactions();
  },
  methods: {
    async getWalletTransactions() {
      const { data } = await this.$webService.getWalletTransactions();
      if (data) {
        this.allTransactions = data;
      } else {
        this.allTransactions = [];
      }
    },
    async getWalletBalance() {
      const balanceData = await this.$webService.getWalletBalance();
      if (balanceData) {
        this.wallet = balanceData.data;
      }
    },
    async filter() {
      var filterData = {
        id: "",
        search: "",
        column: "",
        page: this.filterData.page,
        perPage: this.filterData.perPage,
        sort: {
          field: "",
          type: "",
        },
        export: "",
      };

      const { data } = await this.$webService.getWalletTransactions(filterData);
      if (data) {
        this.allTransactions = data;
      }
    },
    async submit() {
      if (!this.withdraw.amount || !this.withdraw.note) {
        this.$toast.error(this.$t('amount_and_note_fields_are_required'));
      } else {
        this.loading = true
        await this.$webService
          .createPayoutRequest(this.withdraw)
          .then(async (res) => {
            this.loading = false;
            if (res.success == true) {
              this.$toast.success(res.message);
              $("#withdrawAmountModel").modal("hide");

              this.withdraw.amount = "";
              this.withdraw.note = "";
            } else {
              this.$toast.error(res.message);
            }
          })
          .catch(async (res) => {
            this.loading = false;
            this.$toast.error(res.message);
          });
      }
    },
  },

  mounted() {},
  watch: {
    allTransactions(newCount, oldCount) {
      if (
        this.allTransactions &&
        this.allTransactions != null &&
        this.allTransactions.data != null &&
        this.allTransactions != null
      ) {
        this.rows = this.allTransactions.data;
        this.totalRows = this.allTransactions.meta.total;
        if (this.filterData.page != this.allTransactions.meta.current_page) {
          this.filterData.page = this.allTransactions.meta.current_page;
        }
        if (this.filterData.perPage != this.allTransactions.meta.per_page) {
          this.filterData.perPage = this.allTransactions.meta.per_page;
        }
      }
    },
  },
};
</script>
