<template >
  <section v-if="$fetchState.pending" class="my-profile-page m-0">
    <WebsiteGlobalComponentsBreadCrumb />
     <AdminLoader />
    <Component :is="`WebsiteSkeleton${currentlyActiveTemplate}MyWalletPage`" />
  </section>
  <section v-else class="my-profile-page m-0">
    <WebsiteGlobalComponentsBreadCrumb  page="Wallet"/>
    <div class="container">
      <div class="row mt-5">
        <div class="my-wallet-sec mt-50 mb-50">
          <div class="wallet-cont">
            <div class="row">
              <div class="col-md-4 mb-3">
                <div class="wallet-sec wallet">
                  <h4>{{$t('web.customer.wallet.current_balance')}}</h4>
                  <p class="fs-2 fw-bold text-body opacity-3 m-0">
                    {{ wallet ? wallet.balance : 0 }}
                  </p>
                </div>
              </div>
              <div class="col-md-4 mb-3">
                <div class="wallet-sec deposits">
                  <h4>{{$t('web.customer.wallet.deposits')}}</h4>
                  <p class="fs-2 fw-bold text-body opacity-3 m-0">
                    {{ wallet ? wallet.total_deposit : 0 }}
                  </p>
                </div>
              </div>
              <div class="col-md-4">
                <div class="wallet-sec bonus">
                  <h4>{{$t('web.customer.wallet.refund')}}</h4>
                  <p class="fs-2 fw-bold text-body opacity-3 m-0">
                    {{ wallet ? wallet.total_refund : 0 }}
                  </p>
                </div>
              </div>
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
                <option>{{$t('web.customer.wallet.options.deposit')}}</option>
                <option>{{$t('web.customer.wallet.options.refund')}}</option>
                <option>{{$t('web.customer.wallet.options.withdraw')}}</option>
              </select>
            </div>
            <div class="d-flex">
              <!-- Button trigger modal -->
              <button
                type="button"
                class="btn bg-warning rounded fw-bold text-uppercase py-2"
                data-bs-toggle="modal"
                data-bs-target="#paymentModel"
              >
               {{$t('web.customer.wallet.deposit_into_your_wallet')}}
              </button>

              <!-- Modal -->
              <div
                class="modal fade"
                id="paymentModel"
                tabindex="-1"
                aria-labelledby="paymentModelLabel"
                aria-hidden="true"
              >
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5
                        class="
                          modal-title
                          text-primary text-uppercase
                          fw-bold
                          mb-0
                        "
                        id="paymentModelLabel"
                      >
                        {{$t('web.customer.wallet.payment_methods')}}
                      </h5>
                      <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                      ></button>
                    </div>
                    <div v-if="paymentLoader">
                      <AdminLoader />
                    </div>
                    <div class="modal-body" v-else>
                      <div class="mb-3">
                        <label for="deposit_amount" class="form-label"
                          >{{$t('web.customer.wallet.amount')}}</label
                        >
                        <input
                          class="form-control"
                          v-model="deposit_amount"
                          min="16"
                          max="16"
                          type="text"
                          placeholder="Enter Amount"
                          aria-label="cardNumber"
                        />
                      </div>
                      <div class="payment-methods">
                        <div
                          class="
                            payment-methods-form
                            shadow
                            rounded
                            p-4
                            bg-white-secondary-light
                          "
                        >
                          <form class="row g-3">
                            <span
                              class="float-end text-danger"
                              v-if="
                                all_errors && all_errors['payment_method_code']
                              "
                            >
                              {{ all_errors["payment_method_code"][0] }}
                            </span>
                            <div
                              class="col-md-12"
                              v-if="
                               filterPaymentMethods.length > 0
                              "
                            >
                              <div class="row">
                                <div
                                  class="col-6"
                                  v-for="payment_method in filterPaymentMethods"
                                  :key="payment_method.id"
                                >
                                  <div class="form-check mb-5">
                                    <input
                                      class="form-check-input"
                                      :id="`payment_${payment_method.id}`"
                                      :value="payment_method.code"
                                      v-model="details.payment_method_code"
                                      type="radio"
                                    />
                                    <label
                                      class="form-check-label"
                                      :for="`payment_${payment_method.id}`"
                                      >{{ payment_method.name }}</label
                                    >
                                    <!--
                            <label class="form-check-label" for="paymentRadio1"><img v-if='payment_method.image && payment_method.image.thumbnails && payment_method.image.thumbnails.small' v-bind:src=" url + `${payment_method.image.thumbnails.small.thumbnail}`" class="img-fluid"></label>
                            -->
                                  </div>
                                </div>
                                <div
                                  class="col-12"
                                  v-if="
                                    details.payment_method_code == 'stripe' ||
                                    details.payment_method_code == 'braintree'
                                  "
                                >
                                  <div class="payment-det-form border-top pt-4">
                                    <!--
                            <label class="form-check-label" for="paymentRadio1"><img v-if='payment_method.image && payment_method.image.thumbnails && payment_method.image.thumbnails.small' v-bind:src=" url + `${payment_method.image.thumbnails.small.thumbnail}`" class="img-fluid"></label>
                            -->
                                    <div class="mb-3">
                                      <span
                                        class="float-end text-danger"
                                        v-if="
                                          all_errors &&
                                          all_errors['cardInfo.number']
                                        "
                                      >
                                        {{ all_errors["cardInfo.number"][0] }}
                                      </span>
                                      <label
                                        for="card-number"
                                        class="form-label"
                                        >{{$t('web.customer.wallet.card_number')}}</label
                                      >
                                      <input
                                        class="form-control"
                                        v-model="details.number"
                                        min="16"
                                        max="16"
                                        type="text"
                                        placeholder="Number"
                                        aria-label="cardNumber"
                                      />
                                    </div>
                                    <div class="mb-3">
                                      <span
                                        class="float-end text-danger"
                                        v-if="
                                          all_errors &&
                                          all_errors['cardInfo.exp_month']
                                        "
                                      >
                                        {{
                                          all_errors["cardInfo.exp_month"][0]
                                        }}
                                      </span>
                                      <label for="exp-month" class="form-label"
                                        >{{$t('web.customer.wallet.card_exp_month')}}</label
                                      >
                                      <input
                                        class="form-control"
                                        v-model="details.exp_month"
                                        min="2"
                                        max="4"
                                        type="text"
                                        placeholder="Exp Month"
                                        aria-label="CardExpMonth"
                                      />
                                    </div>
                                    <div class="mb-3">
                                      <span
                                        class="float-end text-danger"
                                        v-if="
                                          all_errors &&
                                          all_errors['cardInfo.exp_year']
                                        "
                                      >
                                        {{ all_errors["cardInfo.exp_year"][0] }}
                                      </span>
                                      <label for="exp-year" class="form-label"
                                        >{{$t('web.customer.wallet.card_exp_year')}}</label
                                      >
                                      <input
                                        class="form-control"
                                        v-model="details.exp_year"
                                        min="2"
                                        max="4"
                                        type="text"
                                        placeholder="Exp Year"
                                        aria-label="CardExpYear"
                                      />
                                    </div>
                                    <div class="mb-3">
                                      <span
                                        class="float-end text-danger"
                                        v-if="
                                          all_errors &&
                                          all_errors['cardInfo.cvc']
                                        "
                                      >
                                        {{ all_errors["cardInfo.cvc"][0] }}
                                      </span>
                                      <label for="exp-cvv" class="form-label"
                                        >{{$t('web.customer.wallet.card_exp_cvv')}}</label
                                      >
                                      <input
                                        class="form-control"
                                        v-model="details.cvc"
                                        min="3"
                                        max="3"
                                        type="text"
                                        placeholder="Exp Cvv"
                                        aria-label="CardExpCvv"
                                      />
                                    </div>
                                  </div>
                                </div>
                                <div
                                  class="col-6"
                                  v-if="details.payment_method_code == 'paytm'"
                                >
                                  <input
                                    class="form-check-input"
                                    value="balance"
                                    v-model="details.paytm_mode"
                                    type="radio"
                                  />
                                  <label for=""> <p>{{$t('web.customer.wallet.paytm_balance')}}</p> </label>
                                  <input
                                    class="form-check-input"
                                    value="card"
                                    v-model="details.paytm_mode"
                                    type="radio"
                                  />
                                  <label for=""> <p>{{$t('web.customer.wallet.card')}}</p> </label>

                                  <div
                                    class="form-check mb-5"
                                    v-if="details.paytm_mode == 'card'"
                                  >
                                    <!--
                            <label class="form-check-label" for="paymentRadio1"><img v-if='payment_method.image && payment_method.image.thumbnails && payment_method.image.thumbnails.small' v-bind:src=" url + `${payment_method.image.thumbnails.small.thumbnail}`" class="img-fluid"></label>
                            -->
                                    <p>{{$t('web.customer.wallet.paytm_number')}}</p>
                                    <input
                                      class="form-input"
                                      v-model="details.number"
                                    />
                                    <p>{{$t('web.customer.wallet.card_exp_month')}}</p>
                                    <input
                                      class="form-input"
                                      v-model="details.exp_month"
                                    />
                                    <p>{{$t('web.customer.wallet.card_exp_year')}}</p>
                                    <input
                                      class="form-input"
                                      v-model="details.exp_year"
                                    />
                                    <p>{{$t('web.customer.wallet.card_exp_cvv')}}</p>
                                    <input
                                      class="form-input"
                                      v-model="details.cvc"
                                    />
                                  </div>
                                  <div
                                    class="form-check mb-5"
                                    v-if="details.paytm_mode == 'balance'"
                                  >
                                    <!--
                            <label class="form-check-label" for="paymentRadio1"><img v-if='payment_method.image && payment_method.image.thumbnails && payment_method.image.thumbnails.small' v-bind:src=" url + `${payment_method.image.thumbnails.small.thumbnail}`" class="img-fluid"></label>
                            -->
                                    <p>{{$t('web.customer.wallet.paytm_number_otp')}}</p>
                                    <input
                                      class="form-input"
                                      v-model="details.phone_number"
                                    />
                                  </div>
                                </div>
                              </div>
                            </div>
                            <!-- <div class="col-md-12 mt-4">
                        <h5 class="text-primary text-body mb-4">Order Notes</h5>
                        <div class="mb-3">
                          <textarea
                            class="form-control"
                            id="validationTextarea"
                            placeholder="Order Notes"
                            required
                          >
                        Stripe: Test Card1 details:  number:4242424242424242 exp_month:05 exp_year:2030 cvc:123


                        Braintree: Test Card2 details:  number:4111111111111111 exp_month:05 exp_year:2030 cvc:123
                        </textarea
                          >
                          <div class="invalid-feedback">
                            Please enter a message in the textarea.
                          </div>
                        </div>
                      </div> -->
                          </form>
                        </div>
                      </div>
                    </div>
                    <div class="modal-footer" v-if="!paymentLoader">
                      <button
                        type="button"
                        class="btn btn-secondary px-3 py-2"
                        data-bs-dismiss="modal"
                      >
                        {{$t('web.customer.wallet.close')}}
                      </button>
                      <button
                        type="button"
                        v-on:click="proceedWalletDeposit"
                        class="btn btn-primary px-3 py-2"
                      >
                        {{$t('web.customer.wallet.submit')}}
                      </button>
                    </div>
                  </div>
                </div>
              </div>
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
                    <p class="mx-auto mb-0">{{$t('web.customer.wallet.you_any_record')}}</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <WebsiteTemplate1NewsLetterSection />
  </section>
</template>
<script >
import { mapGetters } from "vuex";
import datatableMixin from "~/mixins/datatableMixin.js";

export default {
  mixins: [datatableMixin],
  data() {
    return {
         currentlyActiveTemplate: "",
      paymentLoader: false,
      wallet: {},
      allTransactions: [],
      payment_methods: [],
      deposit_amount: "",
      all_errors: "",
      url: "/backend",
      details: {
        payment_method_code: "",
        number: "",
        exp_month: "",
        exp_year: "",
        cvc: "",
        phone_number: "",
        paytm_mode: "",
        paytm_mode: "",
      },
      filterPaymentMethods : [],

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
    created()
  {
    this.currentlyActiveTemplate = this.allSettings.general_settings.currently_active_theme
  },
  async fetch() {
      this.payment_methods = await this.$webService.allPaymentMethods();
    await this.getWalletBalance();
    await this.getWalletTransactions();
     this.filterPaymentMethodData();
  },
  methods: {
    async proceedWalletDeposit() {
      this.paymentLoader = true;
      var depositData = {
        payment_method_code: this.details.payment_method_code,
        cardInfo: {
          number: this.details.number,
          exp_month: this.details.exp_month,
          exp_year: this.details.exp_year,
          cvc: this.details.cvc,
        },
        balance: this.deposit_amount,
        payment_type: "wallet",
      };
      await this.$webService
        .depositAmount(depositData)
        .then(async (res) => {
          this.paymentLoader = false;
          if (res.original.success == true) {
            this.$toast.success(res.original.message);
          }
          $("#paymentModel").modal("hide");
          await this.getWalletBalance();
          await this.getWalletTransactions();

          this.details.payment_method_code = "";
          this.details.number = "";
          this.details.exp_month = "";
          this.details.exp_year = "";
          this.details.cvc = "";
        })
        .catch(async (res) => {
          this.paymentLoader = false;
          if (res.response.data.errors) {
            this.all_errors = res.response.data.errors;
            this.$toast.error(res.response.data.message);
          }
        });
    },
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
    filterPaymentMethodData() {
      for (let index = 0; index < this.payment_methods.data.length; index++) {
        const element = this.payment_methods.data[index];

        if (element.code == "braintree") {
          this.filterPaymentMethods.push(element);
        }
        if (element.code == "stripe") {
          this.filterPaymentMethods.push(element);
        }
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
  },

  computed: {
    ...mapGetters({
         allSettings: 'allDefaultSettings'
    }),
  },
  mounted() {

  },
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
