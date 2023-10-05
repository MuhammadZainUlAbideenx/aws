<template >
  <div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="row g-0">
        <div class="col-sm-12 px-0">
          <h2 class="m-0 text-body bold">
            {{ this.$t("form.currency.create_new_currency") }}
          </h2>
        </div>
        <!-- /.col -->
        <div class="row">
          <div class="col-sm-12 px-0">
            <ol class="breadcrumb float-sm-right text-body">
              <li class="breadcrumb-item">
                <nuxt-link :to="localePath('/admin/dashboard')">{{
                  this.$t("sidebar.home")
                }}</nuxt-link>
              </li>
              <li class="breadcrumb-item">
                <nuxt-link :to="localePath('/admin/currencies')">{{
                  this.$t("sidebar.currency")
                }}</nuxt-link>
              </li>
              <li class="breadcrumb-item active">
                {{ this.$t("form.create") }}
              </li>
            </ol>
            <p class="text-body-secondary">
              {{ this.$t("form.currency.form_description") }}
            </p>
          </div>
          <!-- /.col -->
        </div>
      </div>
      <!-- /.row -->
    </div>

    <!-- Main content -->
    <section class="content pb-5">
      <div v-if="$fetchState.pending">
         <AdminFormLoader/>
      </div>
      <div class="container" v-else>
        <div class="row">
          <div class="col-lg-12">
            <div class="card gutter-b border-0">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6 my-1 ps-md-0">
                    <div role="group ">
                      <label for="input-live" class="form-label"
                        >{{ this.$t("form.currency.name.label") }}:</label
                      >
                      <span
                        class="float-end text-danger"
                        v-if="error && error.name"
                      >
                        {{ error.name[0] }}
                      </span>
                      <input
                        class="form-control"
                        :class="error && error.name ? 'error' : ''"
                        v-model="formData.name"
                        aria-describedby="input-live-help input-live-feedback"
                        :placeholder="this.$t('form.currency.name.placeholder')"
                        trim
                      />
                      <span class="heebo-light">
                        {{ this.$t("form.currency.name.subheading") }}
                      </span>
                    </div>
                  </div>
                  <div class="col-md-6 my-1 pe-md-0">
                    <div role="group">
                      <label for="input-live" class="form-label"
                        >{{ this.$t("form.currency.code.label") }}:</label
                      >
                      <span
                        class="float-end text-danger"
                        v-if="error && error.code"
                      >
                        {{ error.code[0] }}
                      </span>
                      <v-select
                        class=""
                        :placeholder="this.$t('form.currency.code.placeholder')"
                        v-model="formData.code"
                        :reduce="(opt) => opt.code"
                        label="code"
                        :options="allActiveCurrencyCodes.currency_codes"
                      >
                        <template slot="no-options">
                          {{ $t("form.search_select.no_options") }}
                        </template>
                        <template slot="option" slot-scope="option">
                          <div class="d-center">
                            {{ option.code }}
                          </div>
                        </template>
                        <template slot="selected-option" slot-scope="option">
                          <div class="selected d-center">
                            {{ option.code }}
                          </div>
                        </template>
                      </v-select>
                      <span class="heebo-light">
                        {{ $t("form.currency.code.subheading") }}
                      </span>
                    </div>
                  </div>
                  <div class="col-md-6 my-1 ps-md-0">
                    <div role="group">
                      <label for="input-live" class="form-label"
                        >{{ this.$t("form.currency.symbol.label") }}:</label
                      >
                      <span
                        class="float-end text-danger"
                        v-if="error && error.symbol"
                      >
                        {{ error.symbol[0] }}
                      </span>
                      <v-select
                        class=""
                        :placeholder="this.$t('form.currency.symbol.placeholder')"
                        v-model="formData.symbol"
                        :reduce="(opt) => opt.symbol"
                        label="symbol"
                        :options="allActiveCurrencyCodes.currency_codes"
                      >
                        <template slot="no-options">
                          {{ $t("form.search_select.no_options") }}
                        </template>
                        <template slot="option" slot-scope="option">
                          <div class="d-center">
                            {{ option.symbol }}
                          </div>
                        </template>
                        <template slot="selected-option" slot-scope="option">
                          <div class="selected d-center">
                            {{ option.symbol }}
                          </div>
                        </template>
                      </v-select>
                      <span class="heebo-light">
                        {{ $t("form.currency.symbol.subheading") }}
                      </span>
                    </div>
                  </div>
                  <div class="col-md-6 my-1 pe-md-0">
                    <div role="group">
                      <label for="input-live" class="form-label"
                        >{{
                          this.$t("form.currency.decimal_places.label")
                        }}:</label
                      >
                      <span
                        class="float-end text-danger"
                        v-if="error && error.decimal_places"
                      >
                        {{ error.decimal_places[0] }}
                      </span>
                      <input
                        :class="error && error.decimal_places ? 'error' : ''"
                        class="form-control"
                        v-model="formData.decimal_places"
                        aria-describedby="input-live-help input-live-feedback"
                        :placeholder="
                          this.$t('form.currency.decimal_places.placeholder')
                        "
                        trim
                      />
                      <span class="heebo-light">
                        {{ $t("form.currency.decimal_places.subheading") }}
                      </span>
                    </div>
                  </div>
                  <div class="col-md-6 my-1 ps-md-0">
                    <div role="group">
                      <label for="input-live" class="form-label"
                        >{{ this.$t("form.currency.value.label") }}:</label
                      >
                      <span
                        class="float-end text-danger"
                        v-if="error && error.value"
                      >
                        {{ error.value[0] }}
                      </span>
                      <input
                        :class="error && error.value ? 'error' : ''"
                        class="form-control"
                        v-model="formData.value"
                        aria-describedby="input-live-help input-live-feedback"
                        :placeholder="
                          this.$t('form.currency.value.placeholder')
                        "
                        trim
                      />
                      <span class="heebo-light">
                        {{ $t("form.currency.value.subheading") }}
                      </span>
                    </div>
                  </div>
                  <div class="col-md-6 my-1 pe-md-0">
                    <div role="group">
                      <label for="input-live" class="form-label">{{ this.$t("form.currency.direction.label") }}:</label>
                      <span class="float-end text-danger"
                            v-if="error && error.direction">
                          {{ error.direction[0] }}
                        </span>
                        <v-select

                          :placeholder="this.$t('form.currency.direction.placeholder')"
                          v-model="formData.direction"
                          :reduce="(opt) => opt.value"
                          label="direction"
                          :options="options"
                        >
                          <template slot="no-options">
                            {{ $t("form.search_select.no_options") }}
                          </template>
                          <template slot="option" slot-scope="option">
                            <div class="d-center">
                              {{ option.value }}
                            </div>
                          </template>
                          <template slot="selected-option" slot-scope="option">
                            <div class="selected d-center">
                              {{ option.value }}
                            </div>
                          </template>
                        </v-select>
                        <span class="heebo-light">
                            {{ $t("form.currency.direction.subheading") }}
                        </span>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6 my-1 justify-content-center flex-column ps-md-0">
                    <div class="d-flex align-items-center">
                      <label class="label form-label me-4 text-capitalize">
                        {{ this.$t("form.vendor.status.label") }}
                      </label>

                      <div class="form-switch">
                        <input
                          class="form-check-input"
                          v-model="formData.is_active"
                          :checked="formData.is_active ? 'checked' : ''"
                          type="checkbox"
                          id="flexSwitchCheckChecked"
                        />
                      </div>
                    </div>

                    <span class="heebo-light">
                      {{ $t("form.vendor.status.subheading") }}
                    </span>
                  </div>
                  <div class="col-md-6 my-1 justify-content-center flex-column pe-md-0">
                    <div class="d-flex align-items-center">
                      <label class="label form-label me-4 text-capitalize">
                        {{ this.$t("form.vendor.is_default.label") }}
                      </label>

                      <div class="form-switch">
                        <input
                          class="form-check-input"
                          v-model="formData.is_default"
                          :checked="formData.is_default ? 'checked' : ''"
                          type="checkbox"
                          id="flexSwitchCheckChecked"
                        />
                      </div>
                    </div>

                    <span class="heebo-light">
                      {{ $t("form.vendor.is_default.subheading") }}
                    </span>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 px-4 text-center text-md-end">
                <button
                  type="button" :disabled="disabled"
                  class="btn btn-primary mb-3 px-3 py-2"
                  @click="add"
                  name="button"
                >
                  {{ this.$t("form.add") }}
                </button>
                <!-- <button
                  type="button"  :disabled="disabled"
                  class="btn btn-success mb-3"
                  @click="addAndContinue"
                  name="button"
                >
                  {{ this.$t("form.add_and_continue") }}
                </button> -->
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
</template>
<script >
import { mapGetters, mapActions } from "vuex";
export default {
  layout: "admin",
  middleware: ["admin", "permission"],
  meta: {
    permission: "currencies.create",
    strategy: "create",
  },
  async asyncData({ params }) {},
   async fetch() {
    if (!this.allActiveCurrencyCodes.currency_codes) {
      await this.fetchActiveCurrencyCodes();
    }
  },
  data() {
    return {
      options: [
        { value: "ltr", text: this.$t('form.currency.direction_type.left') },
        { value: "rlt", text: this.$t('form.currency.direction_type.right') },
      ],
      formData: {
        name: "",
        code: "",
        symbol: "",
        direction: "",
        decimal_places: "",
        value: "",
        is_default: false,
        is_active: false,
      },
      disabled:false,
      error: false,
    };
  },
  methods: {
    ...mapActions({
      addCurrencies: "Currencies/addCurrencies",
      fetchActiveCurrencies: "General/fetchActiveCurrencies",
      fetchActiveCurrencyCodes: "General/fetchActiveCurrencyCodes",
    }),
    async add() {
      await this.addAndContinue();
      if (!this.error) {
        this.$router.replace(this.localePath("/admin/currencies"));
      }
    },
    checkDefault() {
      if (this.formData.is_default == 1) {
        this.formData.is_active = 1;
      }
    },
    checkStatus() {
      if (this.formData.is_active == 0) {
        this.formData.is_default = 0;
      }
    },
    async addAndContinue() {

          this.disabled=true
      await this.addCurrencies(this.formData).then((res) => {
        // some error occur
        if (res.response) {
          this.error = res.response.data.errors ?? res.response.data;
          this.$toast.error(res.response.data.message);
        } else {
          this.error = false;
          this.formData.name = "";
          this.formData.code = "";
          this.formData.direction = "";
          this.formData.symbol = "";
          this.formData.decimal_places = "";
          this.formData.value = "";
          this.formData.is_default = false;
          this.formData.is_active = false;
          this.$toast.success(res.message);
          this.fetchActiveCurrencies();
        }
      });
        this.disabled=false
    },
    checkDefault() {
      if (this.formData.is_default == 1) {
        this.formData.is_active = 1;
    }
  }
  },
  computed: {
    ...mapGetters({
      allCurrencies: "Currencies/allCurrencies",
      allActiveCurrencyCodes: "General/allActiveCurrencyCodes",
    }),
  },
  mounted() {},
};
</script>
