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
          <h2 class="m-0 text-body bold">
            {{ this.$t("form.product.edit_product") }}
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
                <nuxt-link :to="localePath('/seller/products')">{{
                  this.$t("sidebar.product")
                }}</nuxt-link>
              </li>
              <li class="breadcrumb-item active">
                {{ this.$t("form.edit") }}
              </li>
            </ol>
            <p class="text-body-secondary">
              {{ this.$t("form.product.edit_description") }}
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
        <div class="row">
          <div class="col-lg-12">
            <div class="card gutter-b border-0">
              <div class="card-body">
                <!-- Steps start for simple products -->
                <ul
                  class="nav nav-pills order-profile-tabs my-4 mb-5"
                  id="pills-tab"
                  role="tablist"
                  v-if="formData.product_type == 1"
                >
                  <li
                    class="nav-item col-md-6 col-12 mb-md-0 mb-4"
                    role="presentation"
                  >
                    <button
                      class="w-100 p-md-0 pe-none active"
                      id="pills-home-tab"
                      data-bs-toggle="pill"
                      data-bs-target="#pills-home"
                      type="button"
                      role="tab"
                      aria-controls="pills-home"
                      aria-selected="true"
                    >
                      <div
                        class="product-border-top-nav position-relative mb-3"
                      >
                        <div
                          class="
                            barIconBg
                            position-absolute
                            d-flex
                            align-items-center
                            justify-content-center
                          "
                        >
                          <span class="text-white fw-bold">1</span>
                        </div>
                      </div>
                    </button>
                    <div
                      class="
                        text-dark
                        order-head
                        fw-bold
                        float-end
                        product-step-name
                      "
                    >
                      {{$t('columns.product_info')}}
                    </div>
                  </li>
                  <li
                    class="nav-item col-md-6 col-12 mb-md-0 mb-4"
                    role="presentation"
                  >
                    <button
                      class="w-100 p-md-0 pe-none"
                      id="pills-home-tab"
                      data-bs-toggle="pill"
                      data-bs-target="#pills-home"
                      type="button"
                      role="tab"
                      aria-controls="pills-home"
                      aria-selected="true"
                    >
                      <div
                        class="product-border-top-nav position-relative mb-3"
                      >
                        <div
                          class="
                            barIconBg
                            position-absolute
                            d-flex
                            align-items-center
                            justify-content-center
                          "
                        >
                          <span class="fw-bold">2</span>
                          <!-- <fa :icon="['fas', 'check']" fixed-width class="barIcon" /> -->
                        </div>
                      </div>
                      <!-- <span class="text-dark order-head"> General Information</span> -->
                    </button>
                    <span
                      class="
                        text-dark
                        order-head
                        fw-bold
                        float-end
                        product-step-name
                      "
                      >  {{$t('media_upload')}}</span
                    >
                  </li>
                  <!-- <li
                    class="nav-item col-md-4 col-12 mb-md-0 mb-4"
                    role="presentation"
                  >
                    <button
                      class="w-100 p-md-0 pe-none"
                      id="pills-profile-tab"
                      data-bs-toggle="pill"
                      data-bs-target="#pills-profile"
                      type="button"
                      role="tab"
                      aria-controls="pills-profile"
                      aria-selected="false"
                    >
                      <div
                        class="product-border-top-nav position-relative mb-3"
                      ></div>
                    </button>
                  </li> -->
                </ul>
                <!-- Steps ends for simple products-->
                <!-- Steps start for variable products -->
                <ul
                  class="nav nav-pills order-profile-tabs my-4 mb-5"
                  id="pills-tab"
                  role="tablist"
                  v-if="formData.product_type == 2"
                >
                  <li
                    class="nav-item col-md-4 col-12 mb-md-0 mb-4"
                    role="presentation"
                  >
                    <button
                      class="w-100 p-md-0 pe-none active"
                      id="pills-home-tab"
                      data-bs-toggle="pill"
                      data-bs-target="#pills-home"
                      type="button"
                      role="tab"
                      aria-controls="pills-home"
                      aria-selected="true"
                    >
                      <div
                        class="product-border-top-nav position-relative mb-3"
                      >
                        <div
                          class="
                            barIconBg
                            position-absolute
                            d-flex
                            align-items-center
                            justify-content-center
                          "
                        >
                          <span class="text-white fw-bold">1</span>
                        </div>
                      </div>
                      <!-- <span class="text-dark order-head"> General Information</span> -->
                    </button>
                    <div
                      class="
                        text-dark
                        order-head
                        fw-bold
                        float-end
                        product-step-name
                      "
                    >
                     {{$t('columns.product_info')}}
                    </div>
                  </li>
                  <li
                    class="nav-item col-md-4 col-12 mb-md-0 mb-4"
                    role="presentation"
                  >
                    <button
                      class="w-100 p-md-0 pe-none"
                      id="pills-home-tab"
                      data-bs-toggle="pill"
                      data-bs-target="#pills-home"
                      type="button"
                      role="tab"
                      aria-controls="pills-home"
                      aria-selected="true"
                    >
                      <div
                        class="product-border-top-nav position-relative mb-3"
                      >
                        <div
                          class="
                            barIconBg
                            position-absolute
                            d-flex
                            align-items-center
                            justify-content-center
                          "
                        >
                          <span class="fw-bold">2</span>
                          <!-- <fa :icon="['fas', 'check']" fixed-width class="barIcon" /> -->
                        </div>
                      </div>
                      <!-- <span class="text-dark order-head"> General Information</span> -->
                    </button>
                    <span
                      class="
                        text-dark
                        order-head
                        fw-bold
                        float-end
                        product-step-name
                      "
                      > {{$t('media_upload')}}</span
                    >
                  </li>
                  <li
                    class="nav-item col-md-4 col-12 mb-md-0 mb-4"
                    role="presentation"
                  >
                    <button
                      class="w-100 p-md-0 pe-none"
                      id="pills-profile-tab"
                      data-bs-toggle="pill"
                      data-bs-target="#pills-profile"
                      type="button"
                      role="tab"
                      aria-controls="pills-profile"
                      aria-selected="false"
                    >
                      <div
                        class="product-border-top-nav position-relative mb-3"
                      >
                        <div
                          class="
                            barIconBg
                            position-absolute
                            d-flex
                            align-items-center
                            justify-content-center
                          "
                        >
                          <span class="fw-bold">3</span>
                          <!-- <fa :icon="['fas', 'check']" fixed-width class="barIcon" /> -->
                        </div>
                      </div>
                    </button>
                    <span
                      class="
                        text-dark
                        order-head
                        fw-bold
                        float-end
                        product-step-name
                      "
                      > {{$t('add_attributes')}}</span
                    >
                  </li>
                  <!-- <li
                    class="nav-item col-md-3 col-12 mb-md-0 mb-4"
                    role="presentation"
                  >
                    <button
                      class="w-100 p-md-0 pe-none"
                      id="pills-profile-tab"
                      data-bs-toggle="pill"
                      data-bs-target="#pills-profile"
                      type="button"
                      role="tab"
                      aria-controls="pills-profile"
                      aria-selected="false"
                    >
                      <div
                        class="product-border-top-nav position-relative mb-3"
                      ></div>
                    </button>
                  </li> -->
                </ul>
                <!-- Steps ends for variable products-->
                <div class="row">
                  <div class="col-md-6 my-1 ps-md-0">
                    <div role="group">
                      <label for="input-live" class="form-label">{{
                        this.$t("form.product.product_type.label")
                      }}</label>
                      <span
                        class="float-end text-danger"
                        v-if="error && error.product_type"
                      >
                        {{ error.product_type[0] }}
                      </span>
                      <v-select
                        class=""
                        :placeholder="
                          this.$t('form.product.product_type.placeholder')
                        "
                        v-model="formData.product_type"
                        :reduce="(opt) => opt.value"
                        label="product_type"
                        :options="product_type_options"
                        @input="updateIsVariable"
                      >
                        <template slot="no-options">
                          {{ $t("form.search_select.no_options") }}
                        </template>
                        <template slot="option" slot-scope="option">
                          <div class="d-center">
                            {{ option.text }}
                          </div>
                        </template>
                        <template slot="selected-option" slot-scope="option">
                          <div class="selected d-center">
                            {{ option.text }}
                          </div>
                        </template>
                      </v-select>
                      <span class="heebo-light">
                        {{ $t("form.product.product_type.subheading") }}
                      </span>
                    </div>
                  </div>
                  <div class="col-md-6 my-1 pe-md-0">
                    <div role="group">
                      <label for="input-live" class="form-label"
                        >{{
                          this.$t("form.product.manufacturer.label")
                        }}:</label
                      >
                      <span
                        class="float-end text-danger"
                        v-if="error && error.manufacturer_id"
                      >
                        {{ error.manufacturer_id[0] }}
                      </span>
                      <AdminSearchSelectable
                        :class="error && error.manufacturer_id ? 'error' : ''"
                        apiMethod="activeManufacturers"
                        responseKey="manufacturers"
                        :initialOptions="allActiveManufacturers.manufacturers"
                        :placeholder="
                          this.$t('form.product.manufacturer.placeholder')
                        "
                        :sleectedOptions="selected_manufacturer"
                        v-model="formData.manufacturer_id"
                      />
                      <span class="heebo-light">
                        {{ $t("form.product.manufacturer.subheading") }}
                      </span>
                    </div>
                  </div>
                  <div class="col-md-6 my-1 ps-md-0">
                    <div role="group">
                      <label for="input-live" class="form-label"
                        >{{ this.$t("form.product.brand.label") }}:</label
                      >
                      <span
                        class="float-end text-danger"
                        v-if="error && error.brand_id"
                      >
                        {{ error.brand_id[0] }}
                      </span>
                      <AdminSearchSelectable
                        :class="error && error.brand_id ? 'error' : ''"
                        apiMethod="activeBrands"
                        responseKey="brands"
                        :initialOptions="allActiveBrands.brands"
                        :placeholder="this.$t('form.product.brand.placeholder')"
                        :selectedOptions="selected_brand"
                        v-model="formData.brand_id"
                      />
                      <span class="heebo-light">
                        {{ $t("form.product.brand.subheading") }}
                      </span>
                    </div>
                  </div>
                  <div class="col-md-6 my-1 pe-md-0">
                    <div role="group">
                      <label class="label form-label">
                        {{ this.$t("form.product.available_date.label") }}
                      </label>
                      <span
                        class="float-end text-danger"
                        v-if="error && error.available_date"
                      >
                        {{ error.available_date[0] }}
                      </span>
                      <datetime
                        :min-datetime="now.min_date"
                        :placeholder="
                          this.$t('form.product.available_date.placeholder')
                        "
                        input-class="form-control"
                        type="datetime"
                        use12-hour
                        v-model="formData.available_date"

                      ></datetime>

                      <span class="px-2 heebo-light">
                        {{ $t("form.product.available_date.subheading") }}
                      </span>
                    </div>
                  </div>
                  <div
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
                        >{{ this.$t("form.product.vendor.label") }}:</label
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
                        :placeholder="
                          this.$t('form.product.vendor.placeholder')
                        "
                        :selectedOptions="selected_vendor"
                        v-model="formData.vendor_id"
                        v-on:input="vendorChange"
                      />
                      <span class="heebo-light">
                        {{ $t("form.product.vendor.subheading") }}
                      </span>
                    </div>
                  </div>
                  <div class="col-md-6 mb-3 ps-md-0" v-if="formData.product_type != 2">
                    <div role="group">
                      <label for="input-live" class="form-label"
                        >{{ this.$t("form.product.sku.label") }}:</label
                      >
                      <span
                        class="float-end text-danger"
                        v-if="error && error.sku"
                      >
                        {{ error.sku[0] }}
                      </span>
                      <input
                        :class="error && error.sku ? 'error' : ''"
                        class="form-control"
                        type="text"
                        aria-describedby="input-live-help input-live-feedback"
                        v-model="formData.sku"
                        :placeholder="this.$t('form.product.sku.placeholder')"
                        trim
                      />
                      <span class="heebo-light">
                        {{ $t("form.product.sku.subheading") }}
                      </span>
                    </div>
                  </div>
                </div>

                <hr />
                <div class="row">
                  <div class="col-md-12 my-1">
                    <div role="group">
                      <label for="input-live" class="form-label"
                        >{{ this.$t("form.product.categories.label") }}:</label
                      >
                      <span
                        class="float-end text-danger"
                        v-if="error && error.categories"
                      >
                        {{ error.categories[0] }}
                      </span>
                    </div>

                    <GlobalNestedCategories
                      class="nested-categories"
                      :key="key"
                      @checkParent="checkAllParent"
                      :parent="null"
                      :categories_array="formData.categories"
                      :value="formData.categories"
                      @input="handleCategories"
                      :categories="categories"
                    />
                  </div>
                </div>
                <hr />
                <div class="row">
                  <div
                    class="
                      col-md-6
                      my-1
                      d-flex
                      justify-content-center
                      flex-column
                      ps-md-0
                    "
                  >
                    <div class="d-flex align-items-center">
                      <label class="label form-label me-4 text-capitalize">
                        {{ this.$t("form.product.is_feature.label") }}
                      </label>

                      <div class="form-switch">
                        <input
                          class="form-check-input"
                          v-model="formData.is_feature"
                          :checked="formData.is_feature ? 'checked' : ''"
                          type="checkbox"
                          id="flexSwitchCheckChecked"
                        />
                      </div>
                    </div>

                    <span class="heebo-light">
                      {{ $t("form.product.is_feature.subheading") }}
                    </span>
                  </div>
                  <div
                    class="
                      col-md-6
                      my-1
                      d-flex
                      justify-content-center
                      flex-column
                      pe-md-0
                    "
                      v-if="formData.product_type != 2"
                  >
                    <div class="d-flex align-items-center">
                      <label class="label form-label me-4 text-capitalize">
                        {{ this.$t("form.product.status.label") }}
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
                      {{ $t("form.product.status.subheading") }}
                    </span>
                  </div>
                </div>
                <div class="row">
                  <div
                    class="col-md-6 my-1 ps-md-0"
                    v-if="formData.product_type != 2"
                  >
                    <div role="group">
                      <label for="input-live" class="form-label"
                        >{{
                          this.$t("form.product.product_price.label")
                        }}:</label
                      >
                      <span
                        class="float-end text-danger"
                        v-if="error && error.price"
                      >
                        {{ error.price[0] }}
                      </span>
                      <input
                        :class="error && error.price ? 'error' : ''"
                        class="form-control"
                        type="number"
                        aria-describedby="input-live-help input-live-feedback"
                        v-model="formData.price"
                        :placeholder="
                          this.$t('form.product.product_price.placeholder')
                        "
                        trim
                      />
                      <span class="heebo-light">
                        {{ $t("form.product.product_price.subheading") }}
                      </span>
                    </div>
                  </div>
                  <div
                    class="col-md-6 my-1 pe-md-0"
                    v-if="formData.product_type != 2"
                  >
                    <div role="group">
                      <label for="input-live" class="form-label"
                        >{{
                          this.$t("form.product.product_stock.label")
                        }}:</label
                      >
                      <span
                        class="float-end text-danger"
                        v-if="error && error.stock"
                      >
                        {{ error.stock[0] }}
                      </span>
                      <input
                        :class="error && error.stock ? 'error' : ''"
                        class="form-control"
                        type="number"
                        aria-describedby="input-live-help input-live-feedback"
                        v-model="formData.stock"
                        :placeholder="
                          this.$t('form.product.product_stock.placeholder')
                        "
                        trim
                      />
                      <span class="heebo-light">
                        {{ $t("form.product.product_stock.subheading") }}
                      </span>
                    </div>
                  </div>
                  <div class="col-md-6 my-1 ps-md-0">
                    <div role="group">
                      <label for="input-live" class="form-label"
                        >{{ this.$t("form.product.tax_class.label") }}:</label
                      >
                      <span
                        class="float-end text-danger"
                        v-if="error && error.tax_class_id"
                      >
                        {{ error.tax_class_id[0] }}
                      </span>
                      <AdminSearchSelectable
                        :class="error && error.tax_class_id ? 'error' : ''"
                        apiMethod="activeTaxClass"
                        responseKey="tax_classes"
                        :initialOptions="allActiveTaxClasses.tax_classes"
                        :placeholder="
                          this.$t('form.product.tax_class.placeholder')
                        "
                        :selectedOptions="selected_tax_class"
                        v-model="formData.tax_class_id"
                      />
                      <span class="heebo-light">
                        {{ $t("form.product.tax_class.subheading") }}
                      </span>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6 my-1 ps-md-0">
                    <div role="group">
                      <label for="input-live" class="form-label"
                        >{{ this.$t("form.product.min_order.label") }}:</label
                      >
                      <span
                        class="float-end text-danger"
                        v-if="error && error.min_order"
                      >
                        {{ error.min_order[0] }}
                      </span>
                      <input
                        :class="error && error.min_order ? 'error' : ''"
                        class="form-control"
                        type="number"
                        aria-describedby="input-live-help input-live-feedback"
                        v-model="formData.min_order"
                        :placeholder="
                          this.$t('form.product.min_order.placeholder')
                        "
                        trim
                         min="1"
                         oninput="this.value = this.value.replace(/[^1-9.]/g, '').replace(/(\..*)\./g, '$1');"
                      />
                      <span class="heebo-light">
                        {{ $t("form.product.min_order.subheading") }}
                      </span>
                    </div>
                  </div>
                  <div class="col-md-6 my-1 pe-md-0">
                    <div role="group">
                      <label for="input-live" class="form-label"
                        >{{ this.$t("form.product.max_order.label") }}:</label
                      >
                      <span
                        class="float-end text-danger"
                        v-if="error && error.max_order"
                      >
                        {{ error.max_order[0] }}
                      </span>
                      <input
                        :class="error && error.max_order ? 'error' : ''"
                        class="form-control"
                        type="number"
                        aria-describedby="input-live-help input-live-feedback"
                        v-model="formData.max_order"
                        :placeholder="
                          this.$t('form.product.max_order.placeholder')
                        "
                        trim
                      />
                      <span class="heebo-light">
                        {{ $t("form.product.max_order.subheading") }}
                      </span>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6 my-1 ps-md-0">
                    <div role="group">
                      <label for="input-live" class="form-label"
                        >{{
                          this.$t("form.product.product_weight.label")
                        }}:</label
                      >
                      <span
                        class="float-end text-danger"
                        v-if="error && error.weight"
                      >
                        {{ error.weight[0] }}
                      </span>
                      <div class="row">
                        <div class="col-md-6 ps-0">
                          <input
                            :class="error && error.weight ? 'error' : ''"
                            class="form-control"
                            aria-describedby="input-live-help input-live-feedback"
                            v-model="formData.weight"
                            type="number"
                            :placeholder="
                              this.$t('form.product.product_weight.placeholder')
                            "
                            trim
                          />
                          <span class="heebo-light">
                            {{ $t("form.product.product_weight.subheading") }}
                          </span>
                        </div>
                        <div class="col-md-6 pe-0">
                          <AdminSearchSelectable
                            :class="error && error.unit_id ? 'error' : ''"
                            apiMethod="activeUnits"
                            responseKey="units"
                            :initialOptions="allActiveUnits.units"
                            :placeholder="
                              this.$t('form.product.unit.placeholder')
                            "
                            :selectedOptions="selected_unit"
                            v-model="formData.unit_id"
                          />
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6 my-1 pe-md-0">
                    <div role="group">
                      <label for="input-live" class="form-label"
                        >{{
                          this.$t("form.product.product_modal.label")
                        }}:</label
                      >
                      <span
                        class="float-end text-danger"
                        v-if="error && error.modal"
                      >
                        {{ error.modal[0] }}
                      </span>
                      <input
                        :class="error && error.modal ? 'error' : ''"
                        class="form-control"
                        aria-describedby="input-live-help input-live-feedback"
                        v-model="formData.modal"
                        :placeholder="
                          this.$t('form.product.product_modal.placeholder')
                        "
                        trim
                      />
                      <span class="heebo-light">
                        {{ $t("form.product.product_modal.subheading") }}
                      </span>
                    </div>
                  </div>
                  <div class="col-md-6 my-1 pe-md-0">
                    <div role="group">
                      <label for="input-live" class="form-label"
                        >{{
                          this.$t("form.product.shipping_weight.label")
                        }}:</label
                      >
                      <span
                        class="float-end text-danger"
                        v-if="error && error.shipping_weight"
                      >
                        {{ error.shipping_weight[0] }}
                      </span>
                      <input
                        :class="error && error.shipping_weight ? 'error' : ''"
                        class="form-control"
                        aria-describedby="input-live-help input-live-feedback"
                        v-model="formData.shipping_weight"
                        :placeholder="
                          this.$t('form.product.shipping_weight.placeholder')
                        "
                        trim
                      />
                      <span class="heebo-light">
                        {{ $t("form.product.shipping_weight.subheading") }}
                      </span>
                    </div>
                  </div>
                </div>
                <div class="row" v-if="formData.product_type != 2">
                  <div class="col-md-6 my-1 d-flex flex-column ps-md-0">
                    <div class="d-flex align-items-center">
                      <label class="label form-label me-4 text-capitalize">
                        {{ this.$t("form.product.flash_sale.label") }}
                      </label>

                      <div class="form-switch">
                        <input
                          class="form-check-input"
                          v-model="formData.flash_sale.exists"
                          :checked="formData.flash_sale.exists ? 'checked' : ''"
                          type="checkbox"
                          id="flexSwitchCheckChecked"
                          @change="onChangeFlash"
                        />
                      </div>
                    </div>
                    <span class="px-1 heebo-light">
                      {{ $t("form.product.flash_sale.subheading") }}
                    </span>
                    <div v-if="formData.flash_sale.exists">
                      <div class="mt-3">
                        <label class="label form-label">
                          {{
                            this.$t(
                              "form.product.flash_sale.flash_sale_price.label"
                            )
                          }}
                        </label>
                        <span
                          class="float-end text-danger"
                          v-if="error && error['flash_sale.product_price']"
                        >
                          {{ error["flash_sale.product_price"][0] }}
                        </span>
                        <input
                          :class="
                            error && error['flash_sale.product_price']
                              ? 'error'
                              : ''
                          "
                          class="form-control"
                          type="number"
                          aria-describedby="input-live-help input-live-feedback"
                          v-model="formData.flash_sale.product_price"
                          :placeholder="
                            this.$t(
                              'form.product.flash_sale.flash_sale_price.placeholder'
                            )
                          "
                          trim
                        />
                        <span class="heebo-light">
                          {{
                            $t(
                              "form.product.flash_sale.flash_sale_price.subheading"
                            )
                          }}
                        </span>
                      </div>
                      <div class="mt-3">
                        <label class="label form-label">
                          {{
                            this.$t("form.product.flash_sale.start_date.label")
                          }}
                        </label>
                        <span
                          class="float-end text-danger"
                          v-if="error && error['flash_sale.start_date']"
                        >
                          {{ error["flash_sale.start_date"][0] }}
                        </span>
                        <datetime
                          :min-datetime="now.flash_start_date"
                          :placeholder="
                            this.$t(
                              'form.product.flash_sale.start_date.placeholder'
                            )
                          "
                          input-class="form-control"
                          type="datetime"
                          use12-hour
                          v-model="formData.flash_sale.start_date"
                        ></datetime>

                        <span class="heebo-light">
                          {{
                            $t("form.product.flash_sale.start_date.subheading")
                          }}
                        </span>
                      </div>
                      <div class="mt-3">
                        <label class="label form-label">
                          {{
                            this.$t("form.product.flash_sale.expire_date.label")
                          }}
                        </label>
                        <span
                          class="float-end text-danger"
                          v-if="error && error['flash_sale.expire_date']"
                        >
                          {{ error["flash_sale.expire_date"][0] }}
                        </span>
                        <datetime
                          :min-datetime="now.flash_end_date"
                          :placeholder="
                            this.$t(
                              'form.product.flash_sale.expire_date.placeholder'
                            )
                          "
                          input-class="form-control"
                          type="datetime"
                          use12-hour
                          v-model="formData.flash_sale.expire_date"
                        ></datetime>

                        <span class="heebo-light">
                          {{
                            $t("form.product.flash_sale.expire_date.subheading")
                          }}
                        </span>
                      </div>
                      <div class="mt-3">
                        <div class="d-flex align-items-center">
                          <label class="label form-label pe-4 text capitalize">
                            {{
                              this.$t("form.product.flash_sale.status.label")
                            }}
                          </label>

                          <div class="form-switch d-flex align-items-center">
                            <input
                              class="form-check-input"
                              v-model="formData.flash_sale.is_active"
                              :checked="
                                formData.flash_sale.is_active ? 'checked' : ''
                              "
                              type="checkbox"
                              id="flexSwitchCheckChecked"
                            />
                          </div>
                        </div>

                        <span class="heebo-light">
                          {{ $t("form.product.flash_sale.status.subheading") }}
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6 my-1 d-flex flex-column pe-md-0">
                    <div class="d-flex align-items-center">
                      <label class="label form-label me-4 text-capitalize">
                        {{ this.$t("form.product.special_sale.label") }}
                      </label>

                      <div class="form-switch">
                        <input
                          class="form-check-input"
                          v-model="formData.special_sale.exists"
                          :checked="
                            formData.special_sale.exists ? 'checked' : ''
                          "
                          type="checkbox"
                          id="flexSwitchCheckChecked"
                          @change="onChangeSpecial"
                        />
                      </div>
                    </div>

                    <span class="heebo-light">
                      {{ $t("form.product.special_sale.subheading") }}
                    </span>
                    <div v-if="formData.special_sale.exists">
                      <div class="mt-3">
                        <label class="label form-label">
                          {{
                            this.$t(
                              "form.product.special_sale.special_price.label"
                            )
                          }}
                        </label>
                        <span
                          class="float-end text-danger"
                          v-if="error && error['special_sale.special_price']"
                        >
                          {{ error["special_sale.special_price"][0] }}
                        </span>
                        <input
                          :class="
                            error && error['special_sale.special_price']
                              ? 'error'
                              : ''
                          "
                          class="form-control"
                          type="number"
                          aria-describedby="input-live-help input-live-feedback"
                          v-model="formData.special_sale.special_price"
                          :placeholder="
                            this.$t(
                              'form.product.special_sale.special_price.placeholder'
                            )
                          "
                          trim
                        />
                        <span class="heebo-light">
                          {{
                            $t(
                              "form.product.special_sale.special_price.subheading"
                            )
                          }}
                        </span>
                      </div>
                      <div class="mt-3">
                        <label class="label form-label">
                          {{
                            this.$t(
                              "form.product.special_sale.expire_date.label"
                            )
                          }}
                        </label>
                        <span
                          class="float-end text-danger"
                          v-if="error && error['special_sale.expire_date']"
                        >
                          {{ error["special_sale.expire_date"][0] }}
                        </span>
                        <datetime
                          :min-datetime="now.special_sale_end_date"
                          :placeholder="
                            this.$t(
                              'form.product.special_sale.expire_date.placeholder'
                            )
                          "
                          input-class="form-control"
                          type="datetime"
                          use12-hour
                          v-model="formData.special_sale.expire_date"
                        ></datetime>

                        <span class="heebo-light">
                          {{
                            $t(
                              "form.product.special_sale.expire_date.subheading"
                            )
                          }}
                        </span>
                      </div>
                      <div class="mt-3">
                        <div class="d-flex align-items-center">
                          <label class="label form-label me-4 text-capitalize">
                            {{
                              this.$t("form.product.special_sale.status.label")
                            }}
                          </label>

                          <div class="form-switch d-flex align-items-center">
                            <input
                              class="form-check-input"
                              v-model="formData.special_sale.is_active"
                              :checked="
                                formData.special_sale.is_active ? 'checked' : ''
                              "
                              type="checkbox"
                              id="flexSwitchCheckChecked"
                            />
                          </div>
                        </div>

                        <span class="heebo-light">
                          {{
                            $t("form.product.special_sale.status.subheading")
                          }}
                        </span>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 my-1 ps-md-0">
                  <div role="group">
                    <label for="input-live" class="form-label"
                      >{{ this.$t("form.related_products.label") }}:</label
                    >
                    <span
                      class="float-end text-danger"
                      v-if="error && error.related_products_id"
                    >
                      {{ error.related_products[0] }}
                    </span>
                    <AdminSearchSelectable
                      multiple
                      :class="error && error.related_products ? 'error' : ''"
                      apiMethod="activeProducts"
                      responseKey="products"
                      :initialOptions="allActiveProducts.products"
                      :placeholder="
                        this.$t('form.related_products.placeholder')
                      "
                      :selectedOptions="selected_related_products"
                      v-model="formData.related_products"
                    />
                    <span class="heebo-light">
                      {{ $t("form.related_products.subheading") }}
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
                          {{ $t("form.product.form_description") }}
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
                                <div class="col-md-6 my-1">
                                  <div role="group ">
                                    <label for="input-live" class="form-label"
                                      >{{
                                        $t("form.product.name.label")
                                      }}:</label
                                    >
                                    <span
                                      class="float-end text-danger"
                                      v-if="
                                        error && error['name.' + language.code]
                                      "
                                    >
                                      {{ error["name." + language.code][0] }}
                                    </span>
                                    <input
                                      class="form-control"
                                      :class="
                                        error && error['name.' + language.code]
                                          ? 'error'
                                          : ''
                                      "
                                      v-model="formData.name[language.code]"
                                      aria-describedby="input-live-help input-live-feedback"
                                      :placeholder="
                                        $t('form.product.name.placeholder')
                                      "
                                      trim
                                    />
                                    <span class="heebo-light">
                                      {{ $t("form.product.name.subheading") }}
                                    </span>
                                  </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-md-12 my-1">
                                  <div role="group ">
                                    <label for="input-live" class="form-label"
                                      >{{
                                        $t(
                                          "form.product.short_description.label"
                                        )
                                      }}:</label
                                    >
                                    <span
                                      class="float-end text-danger"
                                      v-if="
                                        error &&
                                        error[
                                          'short_description.' + language.code
                                        ]
                                      "
                                    >
                                      {{
                                        error[
                                          "short_description." + language.code
                                        ][0]
                                      }}
                                    </span>
                                    <GlobalCkeditorNuxt
                                      v-model="
                                        formData.short_description[
                                          language.code
                                        ]
                                      "
                                    />
                                    <span class="heebo-light">
                                      {{
                                        $t(
                                          "form.product.short_description.subheading"
                                        )
                                      }}
                                    </span>
                                  </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-md-12 my-1">
                                  <div role="group ">
                                    <label for="input-live" class="form-label"
                                      >{{
                                        $t("form.product.description.label")
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
                                    <span class="heebo-light">
                                      {{
                                        $t(
                                          "form.product.description.subheading"
                                        )
                                      }}
                                    </span>
                                  </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-md-12 my-1">
                                  <div role="group ">
                                    <label for="input-live" class="form-label"
                                      >{{
                                        $t("form.product.refund_policy.label")
                                      }}:</label
                                    >
                                    <span
                                      class="float-end text-danger"
                                      v-if="
                                        error &&
                                        error['refund_policy.' + language.code]
                                      "
                                    >
                                      {{
                                        error[
                                          "refund_policy." + language.code
                                        ][0]
                                      }}
                                    </span>
                                    <GlobalCkeditorNuxt
                                      v-model="
                                        formData.refund_policy[language.code]
                                      "
                                    />
                                    <span class="heebo-light">
                                      {{
                                        $t(
                                          "form.product.refund_policy.subheading"
                                        )
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
            <div class="row">
              <div class="col-md-12 px-4 text-center text-md-end">
                <button
                  type="button"
                  :disabled="disabled"
                  class="btn btn-secondary mb-3 px-3 py-2"
                  @click="update"
                  name="button"
                >
                  {{ this.$t("form.update") }}
                </button>
                <!-- <button type="button" :disabled="disabled"
                            class="btn btn-success mb-3"
                            @click="updateAndContinue"
                            name="button">
                        {{ this.$t("form.update_and_continue") }}
                      </button> -->
                <button
                  type="button"
                  :disabled="disabled"
                  class="btn btn-success mb-3 px-3 py-2"
                  @click="updateAndNext"
                  name="button"
                >
                  {{ this.$t("form.add_and_continue") }}
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- /.content -->

    <!-- /.content -->
  </div>
</template>
<script >
import { mapGetters, mapActions } from "vuex";
import productMixin from "~/mixins/productMixin.js";
import nestedCategoryMixin from "~/mixins/nestedCategoryMixin.js";

export default {
  layout: "vendor",
  middleware: "vendor",
  mixins: [productMixin, nestedCategoryMixin],
  data() {
    return {
      disabled: false,
    };
  },
  async fetch() {
    //   if(!this.allActiveCategories.categories){
    //   await this.fetchActiveCategories();
    //   }
    if (!this.allActiveManufacturers.manufacturers) {
      await this.fetchActiveManufacturers();
    }
    if (!this.allActiveBrands.brands) {
      await this.fetchActiveBrands();
    }
    if (!this.allActiveTaxClasses.tax_classes) {
      await this.fetchActiveTaxClasses();
    }
    if (!this.allActiveUnits.units) {
      await this.fetchActiveUnits();
    }
    if (!this.allActiveProducts.products) {
      await this.fetchActiveProducts();
    }
    if (this.$auth.strategy.options.name == "admin") {
      if (!this.allActiveVendors.vendors) {
        await this.fetchActiveVendors();
      }
    }
    //   this.categories = this.allActiveCategories.categories
    const { data } = await this.$sellerRepositories.products.show(
      this.$route.params.id
    );
    // get and update data
    this.formData.name = data.nameTranslations;
    this.formData.short_description = data.shortDescriptionTranslations;
    this.formData.description = data.descriptionTranslations;
     if(data.refundPolicyTranslations == "" || data.refundPolicyTranslations == null){
        this.formData.refund_policy = {}
    }else{
        this.formData.refund_policy = data.refundPolicyTranslations;
    }
    this.formData.categories = data.categories;
    this.formData.weight = data.weight;
    this.formData.price = data.price;
    this.formData.stock = data.stock;
    this.formData.sku = data.sku;
    this.formData.modal = data.modal;
    this.formData.shipping_weight = data.shipping_weight;
    this.formData.min_order = data.min_order;
    this.formData.max_order = data.max_order;
    this.formData.available_date = data.available_date;
    this.formData.product_type = data.product_type;
    this.formData.is_feature = data.is_feature;
    this.formData.is_active = data.is_active;
    if (data.related_products) {
      this.selected_related_products = data.related_products_without_all
        ? data.related_products_without_all
        : [];
      this.formData.related_products = data.related_products.map((a) => a.id);
    }

    if (data.unit) {
      this.selected_unit = data.unit.name;
      this.formData.unit_id = data.unit.id;
    }
    if (data.manufacturer) {
      this.selected_manufacturer = data.manufacturer.name;
      this.formData.manufacturer_id = data.manufacturer.id;
    }
    if (data.brand) {
      this.selected_brand = data.brand;
      this.formData.brand_id = data.brand.id;
    }
    if (data.tax_class) {
      this.selected_tax_class = data.tax_class.name;
      this.formData.tax_class_id = data.tax_class.id;
    }
    // if(data.vendor){
    //   this.selected_vendor = data.vendor.name
    //   this.formData.vendor_id = data.vendor.id
    // }
    if (data.flash_sale) {
      this.formData.flash_sale.exists = true;
      this.formData.flash_sale.start_date = data.flash_sale.start_date;
      this.formData.flash_sale.expire_date = data.flash_sale.expire_date;
      this.formData.flash_sale.product_price = data.flash_sale.product_price;
      this.formData.flash_sale.description = data.flash_sale.description;
      this.formData.flash_sale.is_active = data.flash_sale.is_active;
    }
    if (data.special_sale) {
      this.formData.special_sale.exists = true;
      this.formData.special_sale.expire_date = data.special_sale.expire_date;
      this.formData.special_sale.special_price =
        data.special_sale.special_price;
      this.formData.special_sale.is_active = data.special_sale.is_active;
    }
    // if(this.formData.vendor_id && this.formData.vendor_id != null && this.formData.vendor_id != 1){
    //   const categories = await this.$generalService.vendorCategories(this.formData.vendor_id)
    //   this.categories = categories.data
    // }
  },
  updated() {
    this.categoryMark();
  },
  computed: {
    now: function () {
      var min_date = new Date().toISOString();
      if (this.formData.available_date != "") {
        var flash_start_date = new Date(
          this.formData.available_date
        ).toISOString();
        var flash_end_date = new Date(
          this.formData.available_date
        ).toISOString();
        var special_sale_end_date = new Date(
          this.formData.available_date
        ).toISOString();
      } else {
        var flash_start_date = new Date().toISOString();
        var flash_end_date = new Date().toISOString();
        var special_sale_end_date = new Date().toISOString();
      }
      if (this.formData.flash_sale.start_date != "") {
        flash_end_date = new Date(
          this.formData.flash_sale.start_date
        ).toISOString();
      }
      if (
        Date.parse(this.formData.available_date) >
        Date.parse(this.formData.flash_sale.start_date)
      ) {
        this.formData.flash_sale.start_date = "";
        this.formData.flash_sale.expire_date = "";
      }
      if (
        Date.parse(this.formData.available_date) >
        Date.parse(this.formData.special_sale.expire_date)
      ) {
        this.formData.special_sale.expire_date = "";
      }
      if (
        Date.parse(this.formData.flash_sale.start_date) >
        Date.parse(this.formData.flash_sale.expire_date)
      ) {
        this.formData.flash_sale.expire_date = "";
      }
      return {
        flash_start_date: flash_start_date,
        flash_end_date: flash_end_date,
        min_date: min_date,
        special_sale_end_date: special_sale_end_date,
      };
    },
  },
  methods: {
    ...mapActions({
      updateProducts: "Seller/Products/updateProducts",
    }),
    async updateAndNext() {
      await this.updateAndContinue();
      if (!this.error) {
        this.$router.replace(
          this.localePath(
            "/seller/products/edit/" + this.$route.params.id + "/step2"
          )
        );
      }
    },
    async update() {
      await this.updateAndContinue();
      if (!this.error) {
        this.$router.replace(this.localePath("/seller/products"));
      }
    },
    async updateAndContinue() {
      this.disabled = true;
      await this.updateProducts({
        formData: this.formData,
        id: this.$route.params.id,
      }).then((res) => {
        // some error occur
        if (res.response) {
          this.error = res.response.data.errors ?? res.response.data;
          this.$toast.error(res.response.data.message);
        } else if (res.state == "fail") {
          this.$toast.error(res.message);
        } else {
          this.fetchActiveProducts();
          this.error = false;
          this.$toast.success(res.message);
        }
      });
      this.disabled = false;
    },
    onChangeFlash() {
      this.formData.special_sale.exists = false;
    },
    updateIsVariable() {
      if (this.formData.product_type == 2) {
        this.is_variable = 0;
        this.formData.price = 0;
        this.formData.flash_sale.exists = false;
        this.formData.special_sale.exists = false;
        this.formData.stock = 1;
      } else {
        this.is_variable = 1;
      }
    },
    onChangeSpecial() {
      this.formData.flash_sale.exists = false;
    },
  },
  async mounted() {
    const categories = await this.$generalService.vendorCategories(
      this.$auth.user.id
    );
    if (categories) {
      this.categories = categories.data[0].categories;
    }
  },
};
</script>
