<template >
  <div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="row g-0">
        <div class="col-sm-12 px-0">
          <h2 class="m-0 text-body bold">
            {{ this.$t("form.coupon.create_new_coupon") }}
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
                <nuxt-link :to="localePath('/admin/coupons')">{{
                  this.$t("sidebar.coupon")
                }}</nuxt-link>
              </li>
              <li class="breadcrumb-item active">
                {{ this.$t("form.create") }}
              </li>
            </ol>
            <p class="text-body-secondary">
              {{ this.$t("form.coupon.form_description") }}
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
        <AdminFormLoader :multilang="true" />
      </div>
      <div class="container" v-else>
        <div class="col-lg-12">
          <div class="card gutter-b border-0">
            <div class="card-body">
              <div class="row">
                <div class="col-md-6 my-1 ps-md-0">
                  <div role="group ">
                    <label for="input-live" class="form-label"
                      >{{ $t("form.coupon.code.label") }}:</label
                    >
                    <span
                      class="float-end text-danger"
                      v-if="error && error['code']"
                    >
                      {{ error.code[0] }}
                    </span>
                    <input
                      class="form-control"
                      :class="error && error.code ? 'error' : ''"
                      v-model="formData.code"
                      aria-describedby="input-live-help input-live-feedback"
                      :placeholder="$t('form.coupon.code.placeholder')"
                      trim
                    />
                    <span class="heebo-light">
                      {{ $t("form.coupon.code.subheading") }}
                    </span>
                  </div>
                </div>
                <div class="col-md-6 my-1  pe-md-0">
                  <div role="group ">
                    <label for="input-live" class="form-label"
                      >{{ $t("form.coupon.discount_type.label") }}:</label
                    >
                    <span
                      class="float-end text-danger"
                      v-if="error && error['discount_type']"
                    >
                      {{ error.discount_type[0] }}
                    </span>
                    <select v-model="formData.discount_type" class="form-control">
                        <option value="" disabled>{{this.$t("form.coupon.discount_type.placeholder")}}</option>
                        <option :value="option.value" v-for="(option,index) in discount_type_options" :key="index">{{option.text}}</option>
                    </select>

                    <span class="heebo-light">
                      {{ $t("form.coupon.discount_type.subheading") }}
                    </span>
                  </div>
                </div>
              </div>
              <div class="row">
                <!-- if product is discounted -->
                <div class="col-md-6 my-1 ps-md-0" v-if="isPercentageSelect">
                  <div role="group ">
                    <label for="input-live" class="form-label"
                      >{{ $t("form.coupon.percentage.label") }}:</label
                    >
                    <span
                      class="float-end text-danger"
                      v-if="error && error['amount']"
                    >
                      {{ error.amount[0] }}
                    </span>
                    <span
                      class="float-end text-danger"
                      v-if="error && error['not_in_range']"
                    >
                      {{ error.not_in_range[0] }}
                    </span>
                     <div class="input-group">
                       <span class="input-group-text mb-3">
                        %</span
                      >
                    <input
                      class="form-control"
                      type="number"
                      :class="error && error.amount ? 'error' : ''"
                      v-model="formData.amount"
                      aria-describedby="input-live-help input-live-feedback"
                      :placeholder="$t('form.coupon.percentage.placeholder')"
                      trim
                    />
                     </div>
                    <span class="heebo-light">
                      {{ $t("form.coupon.percentage.subheading") }}
                    </span>
                  </div>
                </div>
                <div class="col-md-6 my-1  ps-md-0" v-else>
                  <div role="group ">
                    <label for="input-live" class="form-label"
                      >{{ $t("form.coupon.amount.label") }}:</label
                    >
                    <span
                      class="float-end text-danger"
                      v-if="error && error['amount']"
                    >
                      {{ error.amount[0] }}
                    </span>
                    <span
                      class="float-end text-danger"
                      v-if="error && error['not_in_range']"
                    >
                      {{ error.not_in_range[0] }}
                    </span>
                     <div class="input-group">
                       <span class="input-group-text mb-3">
                        {{ allActiveSettings.settings.current_currency }}</span
                      >
                    <input
                      class="form-control"
                      type="number"
                      :class="error && error.amount ? 'error' : ''"
                      v-model="formData.amount"
                      aria-describedby="input-live-help input-live-feedback"
                      :placeholder="$t('form.coupon.amount.placeholder')"
                      trim
                    />
                     </div>
                    <span class="heebo-light">
                      {{ $t("form.coupon.amount.subheading") }}
                    </span>
                  </div>
                </div>
                <div class="col-md-6 my-1  pe-md-0">
                  <div role="group ">
                    <label for="input-live" class="form-label"
                      >{{ $t("form.coupon.expiry_date.label") }}:</label
                    >
                    <span
                      class="float-end text-danger"
                      v-if="error && error['expiry_date']"
                    >
                      {{ error.expiry_date[0] }}
                    </span>
                    <datetime
                      :min-datetime="now.min_date"
                      :placeholder="
                        this.$t('form.coupon.expiry_date.placeholder')
                      "
                      input-class="form-control"
                      type="datetime"
                      use12-hour
                      v-model="formData.expiry_date"
                      value-zone="local"
                    ></datetime>
                    <span class="heebo-light">
                      {{ $t("form.coupon.expiry_date.subheading") }}
                    </span>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 my-1  ps-md-0">
                  <div role="group ">
                    <label for="input-live" class="form-label"
                      >{{ $t("form.coupon.minimum_spend.label") }}:</label
                    >
                    <span
                      class="float-end text-danger"
                      v-if="error && error['minimum_spend']"
                    >
                      {{ error.minimum_spend[0] }}
                    </span>
                    <div class="input-group">
                      <span class="input-group-text mb-3">
                        {{ allActiveSettings.settings.current_currency }}</span
                      >
                      <input
                        class="form-control"
                        type="number"
                        :class="error && error.minimum_spend ? 'error' : ''"
                        v-model="formData.minimum_spend"
                        aria-describedby="input-live-help input-live-feedback"
                        :placeholder="
                          $t('form.coupon.minimum_spend.placeholder')
                        "
                        trim
                      />
                    </div>
                    <span class="heebo-light">
                      {{ $t("form.coupon.minimum_spend.subheading") }}
                    </span>
                  </div>
                </div>
                <div class="col-md-6 my-1  pe-md-0">
                  <div role="group ">
                    <label for="input-live" class="form-label"
                      >{{ $t("form.coupon.maximum_spend.label") }}:</label
                    >
                    <span
                      class="float-end text-danger"
                      v-if="error && error['maximum_spend']"
                    >
                      {{ error.maximum_spend[0] }}
                    </span>
                    <div class="input-group">
                      <span class="input-group-text mb-3">
                        {{ allActiveSettings.settings.current_currency }}</span
                      >
                      <input
                        class="form-control"
                        type="number"
                        :class="error && error.maximum_spend ? 'error' : ''"
                        v-model="formData.maximum_spend"
                        aria-describedby="input-live-help input-live-feedback"
                        :placeholder="
                          $t('form.coupon.maximum_spend.placeholder')
                        "
                        trim
                      />
                    </div>
                    <span class="heebo-light">
                      {{ $t("form.coupon.maximum_spend.subheading") }}
                    </span>
                  </div>
                </div>
              </div>
              <div class="">
                <!-- <div class="col-md-6 my-1">
                  <div role="group ">
                    <div class="d-flex align-items-center">
                      <label class="label form-label me-4 text-capitalize">
                        {{ $t("form.coupon.products.label") }}
                      </label>

                      <div class="form-switch ms-auto">
                        <input
                          class="form-check-input"
                          v-model="formData.exclude_products"
                          :checked="formData.exclude_products ? 'checked' : ''"
                          type="checkbox"
                          id="flexSwitchCheckChecked"
                        />
                      </div>
                      <label
                        v-if="formData.exclude_products"
                        class="label ms-3 form-label text-capitalize"
                      >
                        {{ $t("form.coupon.include.label") }}
                      </label>

                      <label
                        v-if="formData.exclude_products <= 0"
                        class="label ms-3 form-label text-capitalize"
                      >
                        {{ $t("form.coupon.exclude.label") }}
                      </label>
                    </div>
                    <span
                      class="float-end text-danger"
                      v-if="error && error['products']"
                    >
                      {{ error.products[0] }}
                    </span>
                    <AdminSearchSelectable
                      :class="error && error.products ? 'error' : ''"
                      apiMethod="activeProducts"
                      responseKey="products"
                      :initialOptions="allActiveProducts.products"
                      :placeholder="$t('form.coupon.products.placeholder')"
                      v-model="formData.products"
                      multiple
                    />
                    <span class="heebo-light">
                      {{ $t("form.coupon.products.subheading") }}
                    </span>
                  </div>
                </div>
                <div class="col-md-6 my-1">
                  <div role="group ">
                    <div class="d-flex align-items-center">
                      <label class="label form-label me-4 text-capitalize">
                        {{ $t("form.coupon.categories.label") }}
                      </label>

                      <div class="form-switch ms-auto">
                        <input
                          class="form-check-input"
                          v-model="formData.exclude_categories"
                          :checked="
                            formData.exclude_categories ? 'checked' : ''
                          "
                          type="checkbox"
                          id="flexSwitchCheckChecked"
                        />
                      </div>

                      <label
                        v-if="formData.exclude_categories"
                        class="label ms-3 form-label text-capitalize"
                      >
                        {{ $t("form.coupon.include.label") }}
                      </label>

                      <label
                        v-if="formData.exclude_categories <= 0"
                        class="label ms-3 form-label text-capitalize"
                      >
                        {{ $t("form.coupon.exclude.label") }}
                      </label>
                    </div>
                    <span
                      class="float-end text-danger"
                      v-if="error && error['categories']"
                    >
                      {{ error.categories[0] }}
                    </span>
                    <AdminSearchSelectable
                      :class="error && error.categories ? 'error' : ''"
                      apiMethod="activeSelectCategories"
                      responseKey="categories"
                      :initialOptions="allSelectActiveCategories.categories"
                      :placeholder="$t('form.coupon.categories.placeholder')"
                      v-model="formData.categories"
                      multiple
                    />
                    <span class="heebo-light">
                      {{ $t("form.coupon.categories.subheading") }}
                    </span>
                  </div>
                </div> -->
                <div class="row">
                  <div class="col-md-6 my-1 ps-md-0" >
                    <div role="group ">
                      <label for="input-live" class="  form-label">{{ $t("form.coupon.email_restrictions.label") }}:</label>
                      <span class="float-end text-danger"
                            v-if="error && error['email_restrictions']">
                          {{ error.email_restrictions[0] }}
                        </span>

                        <AdminSearchSelectable :class="error && error.email_restrictions ? 'error' : ''" apiMethod="activeCustomers" responseKey="customers" show_key="email"
                          :initialOptions="allActiveCustomers.customers" :placeholder="$t('form.coupon.email_restrictions.placeholder')" v-model="formData.email_restrictions" multiple />

                    <!-- <AdminSearchSelectable
                      :class="error && error.email_restrictions ? 'error' : ''"
                      apiMethod="activeCustomers"
                      responseKey="customers"
                      :initialOptions="allActiveCustomers.customers"
                      :placeholder="
                        $t('form.coupon.email_restrictions.placeholder')
                      "
                      v-model="formData.email_restrictions"
                      multiple
                    /> -->

                    <span class="heebo-light">
                      {{ $t("form.coupon.email_restrictions.subheading") }}
                    </span>
                  </div>
                </div>
                <div class="col-md-6 my-1 pe-md-0">
                  <div role="group ">
                    <label for="input-live" class="form-label"
                      >{{ $t("form.coupon.usage_limit.label") }}:</label
                    >
                    <span
                      class="float-end text-danger"
                      v-if="error && error['usage_limit']"
                    >
                      {{ error.usage_limit[0] }}
                    </span>
                    <input
                      class="form-control"
                      type="number"
                      :class="error && error.usage_limit ? 'error' : ''"
                      v-model="formData.usage_limit"
                      aria-describedby="input-live-help input-live-feedback"
                      :placeholder="$t('form.coupon.usage_limit.placeholder')"
                      trim
                    />
                    <span class="heebo-light">
                      {{ $t("form.coupon.usage_limit.subheading") }}
                    </span>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 my-1  ps-md-0">
                  <div role="group ">
                    <label for="input-live" class="form-label"
                      >{{ $t("form.coupon.user_limit.label") }}:</label
                    >
                    <span
                      class="float-end text-danger"
                      v-if="error && error['user_limit']"
                    >
                      {{ error.user_limit[0] }}
                    </span>
                    <input
                      class="form-control"
                      type="number"
                      :class="error && error.user_limit ? 'error' : ''"
                      v-model="formData.user_limit"
                      aria-describedby="input-live-help input-live-feedback"
                      :placeholder="$t('form.coupon.user_limit.placeholder')"
                      trim
                    />
                    <span class="heebo-light">
                      {{ $t("form.coupon.user_limit.subheading") }}
                    </span>
                  </div>
                </div>
                <!-- <div
                  class="col-md-6 my-1"
                  v-if="
                    $auth.strategy.options.name == 'admin' &&
                    allActiveSettings &&
                    allActiveSettings.settings &&
                    allActiveSettings.settings.generalSettings &&
                    allActiveSettings.settings.generalSettings
                      .is_multi_vendor == '1'
                  "
                >
                  <div role="group">
                    <label for="input-live" class="form-label"
                      >{{ this.$t("form.coupon.vendor.label") }}:</label
                    >
                    <span
                      class="float-end text-danger"
                      v-if="error && error.vendor_id"
                    >
                      {{ error.vendor_id[0] }}
                    </span>

                    <AdminSearchSelectable
                      :class="error && error.vendor_id ? 'error' : ''"
                      apiMethod="activeVendors"
                      responseKey="vendors"
                      :initialOptions="allActiveVendors.vendors"
                      :placeholder="$t('form.coupon.vendor.select_vendor')"
                      v-model="formData.vendor_id"
                    />

                    <span class="heebo-light">
                      {{ $t("form.coupon.vendor.subheading") }}
                    </span>
                  </div>
                </div> -->
                <!-- <div
                  class="
                    col-md-6
                    my-1
                    d-flex
                    justify-content-center
                    flex-column
                  "
                >
                  <div class="d-flex align-items-center">
                    <label class="label form-label me-4 text-capitalize">
                      {{ this.$t("form.coupon.free_shipping.label") }}
                    </label>

                    <div class="form-switch">
                      <input
                        class="form-check-input"
                        v-model="formData.free_shipping"
                        :checked="formData.free_shipping ? 'checked' : ''"
                        type="checkbox"
                        id="flexSwitchCheckChecked"
                      />
                    </div>
                  </div>

                  <span class="heebo-light">
                    {{ $t("form.coupon.free_shipping.subheading") }}
                  </span>
                </div>
                <div
                  class="
                    col-md-6
                    my-1
                    d-flex
                    justify-content-center
                    flex-column
                  "
                >
                  <div class="d-flex align-items-center">
                    <label class="label form-label me-4 text-capitalize">
                      {{ this.$t("form.coupon.exclude_sale_items.label") }}
                    </label>

                    <div class="form-switch">
                      <input
                        class="form-check-input"
                        v-model="formData.exclude_sale_items"
                        :checked="formData.exclude_sale_items ? 'checked' : ''"
                        type="checkbox"
                        id="flexSwitchCheckChecked"
                      />
                    </div>
                  </div>

                  <span class="heebo-light">
                    {{ $t("form.coupon.exclude_sale_items.subheading") }}
                  </span>
                </div> -->
              </div>
              <div class="row">
                <div
                  class="
                    col-md-6
                    my-1
                    d-flex
                    justify-content-center
                    flex-column ps-md-0
                  "
                >
                  <div class="d-flex align-items-center">
                    <label class="label form-label me-4 text-capitalize">
                      {{ this.$t("form.coupon.status.label") }}
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
                    {{ $t("form.coupon.status.subheading") }}
                  </span>
                </div>
                <div
                  class="
                    col-md-6
                    my-1
                    d-flex
                    justify-content-center
                    flex-column ps-md-0
                  "
                >
                  <div class="d-flex align-items-center">
                    <label class="label form-label me-4 text-capitalize">
                      {{ this.$t("form.coupon.is_featured.label") }}
                    </label>

                    <div class="form-switch">
                      <input
                        class="form-check-input"
                        v-model="formData.is_featured"
                        :checked="formData.is_featured ? 'checked' : ''"
                        type="checkbox"
                        id="flexSwitchCheckChecked"
                      />
                    </div>
                  </div>

                  <span class="heebo-light">
                    {{ $t("form.coupon.is_featured.subheading") }}
                  </span>
                </div>
              </div>
              <hr class="text-primary" />
              <div class="row">
                <div class="col-lg-12 pt-3 px-0">
                  <div class="px-0 pt-3">
                    <h2 class="m-0 text-body bold">
                      {{ $t("form.multilanguage") }}
                    </h2>
                    <p>
                      <span class="heebo-light">
                        {{ $t("form.coupon.website_url.subheading") }}
                      </span>
                    </p>
                    <div class="row">
                      <div class="col-lg-12 px-0 d-md-flex">
                        <ul
                          class="nav nav-tabs d-inline-block"
                          id="myTab"
                          role="tablist "
                        >
                          <li
                            class="nav-item"
                            role="presentation"
                            v-for="(
                              language, index
                            ) in allActiveLanguages.languages"
                            :key="index"
                          >
                            <a
                              class="nav-link"
                              :class="index == 0 ? 'active' : ''"
                              :id="language.code + '-tab'"
                              data-bs-toggle="tab"
                              :href="'#' + language.code"
                              role="tab"
                              :aria-controls="language.code"
                              :aria-selected="index == 0 ? 'true' : 'false'"
                              >{{ language.name }}</a
                            >
                          </li>
                        </ul>

                        <div class="tab-content p-4" id="myTabContent">
                          <div
                            class="tab-pane fade"
                            :class="index == 0 ? 'active show' : ''"
                            :key="language.code"
                            v-for="(
                              language, index
                            ) in allActiveLanguages.languages"
                            :id="language.code"
                            role="tabpanel"
                            :aria-labelledby="language.code + '-tab'"
                          >
                            <div class="row">
                              <div class="col-md-12 my-1">
                                <div role="group ">
                                  <label
                                    for="input-live"
                                    class="px-2 form-label"
                                    >{{
                                      $t("form.coupon.description.label")
                                    }}:</label
                                  >
                                  <span
                                    class="float-end text-danger"
                                    v-if="
                                      error &&
                                      error['description.' + language.code]
                                    "
                                  >
                                    {{
                                      error["description." + language.code][0]
                                    }}
                                  </span>
                                  <GlobalCkeditorNuxt
                                    v-model="
                                      formData.description[language.code]
                                    "
                                  />
                                  <span class="px-2 heebo-light">
                                    {{
                                      $t("form.coupon.description.subheading")
                                    }}
                                  </span>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        </div>
        <div class="row">
          <div class="col-md-12 px-4 text-center text-md-end">
            <button
              type="button"
              class="btn btn-primary mb-3 px-3 py-2"
              @click="add"
              name="button"
            >
              {{ this.$t("form.add") }}
            </button>
            <!-- <button
              type="button"
              class="btn btn-success mb-3"
              @click="addAndContinue"
              name="button"
            >
              {{ this.$t("form.add_and_continue") }}
            </button> -->
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
    permission: "coupons.create",
    strategy: "create",
  },
  async fetch() {
    if (!this.allSelectActiveCategories.categories) {
      await this.fetchSelectActiveCategories();
    }
    if (!this.allActiveProducts.products) {
      await this.fetchActiveProducts();
    }
    if (!this.allActiveCustomers.customers) {
      await this.fetchActiveCustomers();
    }
    if (this.$auth.strategy.options.name == "admin") {
      if (!this.allActiveVendors.vendors) {
        await this.fetchActiveVendors();
      }
    }
  },
  data() {
    return {
      discount_type_options: [
        { value: 1, text: this.$t("form.coupon.discount_type.cart_discount") },
        {
          value: 2,
          text: this.$t("form.coupon.discount_type.cart_percentage_discount"),
        },
        // {
        //   value: 3,
        //   text: this.$t("form.coupon.discount_type.product_discount"),
        // },
        // {
        //   value: 4,
        //   text: this.$t(
        //     "form.coupon.discount_type.product_percentage_discount"
        //   ),
        // },
      ],
      formData: {
        code: "",
        description: {},
        is_active: false,
        is_featured: false,
        discount_type: "",
        amount: "",
        expiry_date: "",
        vendor_id: "",
        free_shipping: false,
        minimum_spend: "",
        maximum_spend: "",
        exclude_sale_items: true,
        products: [],
        exclude_products: false,
        categories: [],
        exclude_categories: false,
        email_restrictions: [],
        usage_limit: "",
        user_limit: "",
      },
      error: false,
      isPercentageSelect: false,
    };
  },
  methods: {
    ...mapActions({
      addCoupons: "Coupons/addCoupons",
      fetchActiveCoupons: "General/fetchActiveCoupons",
      fetchSelectActiveCategories: "General/fetchSelectActiveCategories",
      fetchActiveProducts: "General/fetchActiveProducts",
      fetchActiveCustomers: "General/fetchActiveCustomers",
      fetchActiveVendors: "General/fetchActiveVendors",
    }),
    async add() {
      await this.addAndContinue();
      if (!this.error) {
        this.$router.replace(this.localePath("/admin/coupons"));
      }
    },
    async addAndContinue() {
      await this.addCoupons(this.formData).then((res) => {
        // some error occur
        if (res.response) {
          this.error = res.response.data.errors ?? res.response.data;
          this.$toast.error(res.response.data.message);
        } else {
          this.error = false;
          this.formData.name = "";
          this.formData.description = {};
          this.formData.is_active = false;
          this.discount_type = 1;
          this.amount = "";
          this.expiry_date = "";
          this.free_shipping = false;
          this.minimum_spend = "";
          this.maximum_spend = "";
          this.exclude_sale_items = true;
          this.products = [];
          this.exclude_products = false;
          this.categories = [];
          this.exclude_categories = false;
          this.email_restrictions = [];
          this.usage_limit = "";
          this.user_limit = "";
          this.$toast.success(res.message);
          this.fetchActiveCoupons();
        }
      });
    },
  },

  mounted() {},
  computed: {
    now: function () {
      var min_date = new Date().toISOString();
      return {
        min_date: min_date,
      };
    },
    ...mapGetters({
      allActiveLanguages: "General/allActiveLanguages",
      allSelectActiveCategories: "General/allSelectActiveCategories",
      allActiveProducts: "General/allActiveProducts",
      allActiveCustomers: "General/allActiveCustomers",
      allActiveVendors: "General/allActiveVendors",
      allActiveSettings: "General/allActiveSettings",
    }),
  },
  watch: {
    "formData.discount_type": function (val, oldval) {
      if (val == 2 || val == 4) {
        this.isPercentageSelect = true;
      } else {
        this.isPercentageSelect = false;
      }
    },
  },
};
</script>
