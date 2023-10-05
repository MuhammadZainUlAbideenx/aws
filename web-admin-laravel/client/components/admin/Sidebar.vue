<template>
  <div
    class="
      aside
      bg-gradient
      aside-left aside-fixed
      d-flex
      flex-column flex-row-auto
      shadow
      animate__animated animate__fadeInLeft
    "
    id="tc_aside"
    @mouseover="aside_Min"
    @mouseleave="aside_close"
  >
    <!--begin::Brand-->
    <div class="aside-inner h-100">
      <div class="brand flex-column-auto py-4" id="tc_brand">
        <!--begin::Logo-->

        <nuxt-link
          :to="localePath('/admin/dashboard')"
          class="
            brand-logo
            font-size-h4
            text-uppercase text-decoration-none
            fw-bold
            heebo-bold
          "
          v-if="allSettings.general_settings.name_or_logo == 1"
        >
          <img
            src="~/assets/images/Nictus-logo-w.png"
            class="brand-icon img-fluid"
            style="height: 50px"
            alt="Logo"
          />
          <AdminLogo :Dark="this.themeData.dark" />
        </nuxt-link>
        <nuxt-link to="/" v-else>
          <h2 class="text-center mb-0">
            {{ allSettings.general_settings.web_name }}
          </h2>
        </nuxt-link>
        <!--end::Logo-->
      </div>
      <!--end::Brand-->
      <!--begin::Aside Menu-->
      <div
        class="aside-menu-wrapper flex-column-fluid overflow-auto h-100"
        id="tc_aside_menu_wrapper"
      >
        <!--begin::Menu Container-->
        <div
          id="tc_aside_menu"
          class="aside-menu mb-3"
          data-menu-vertical="1"
          data-menu-scroll="1"
          data-menu-dropdown-timeout="500"
        >
          <!--begin::Menu Nav-->
          <ul class="nav flex-column">
            <div class="accordion" id="accordionExample">
              <li
                class="nav-item"
                v-permission="'languages.index'"
                @click="close_collapse"
              >
                <nuxt-link
                  :to="localePath('/admin/languages')"
                  class="nav-link"
                >
                  <span class="svg-icon nav-icon">
                    <fa
                      :icon="['fas', 'globe-americas']"
                      fixed-width
                      class=""
                    />
                  </span>
                  <span class="nav-text">
                    {{ this.$t("sidebar.language") }}
                  </span>
                </nuxt-link>
              </li>
              <li class="nav-item accordion-item">
                <div
                  class="nav-link collapsed"
                  data-bs-toggle="collapse"
                  data-bs-target="#media-collapse"
                  aria-expanded="false"
                  aria-current="true"
                >
                  <span class="svg-icon nav-icon">
                    <fa :icon="['fas', 'photo-video']" fixed-width class="" />
                  </span>
                  <span class="nav-text">{{
                    this.$t("sidebar.media_library")
                  }}</span>
                  <fa
                    :icon="['fas', 'chevron-down']"
                    fixed-width
                    class="rotate-90"
                  />
                </div>
                <div
                  data-bs-parent="#accordionExample"
                  class="accordion-collapse collapse rounded bg-light"
                  id="media-collapse"
                >
                  <ul class="pb-1 ps-5">
                    <li class="py-2">
                      <nuxt-link
                        :to="localePath('/admin/media')"
                        class="d-inline-flex align-items-center rounded"
                        >{{ this.$t("sidebar.media") }}
                      </nuxt-link>
                    </li>
                    <li class="py-2" v-permission="'media_settings.index'">
                      <nuxt-link
                        to="/admin/media/settings"
                        class="d-inline-flex align-items-center rounded"
                        >{{ this.$t("sidebar.media_setting") }}</nuxt-link
                      >
                    </li>
                  </ul>
                </div>
              </li>
              <li
                class="nav-item accordion-item"
                v-permission:any="
                  'manufacturers.index|products.index|tax_classes.index|units.index|categories.index|reviews.index|brands.index'
                "
              >
                <div
                  class="nav-link collapsed"
                  data-bs-toggle="collapse"
                  data-bs-target="#catalog-collapse"
                  aria-expanded="false"
                  aria-current="true"
                >
                  <span class="svg-icon nav-icon">
                    <fa :icon="['fas', 'boxes']" fixed-width class="" />
                  </span>
                  <span class="nav-text">{{
                    this.$t("sidebar.product_catalog")
                  }}</span>
                  <fa
                    :icon="['fas', 'chevron-down']"
                    fixed-width
                    class="rotate-90"
                  />
                </div>
                <div
                  data-bs-parent="#accordionExample"
                  class="accordion-collapse collapse rounded bg-light"
                  id="catalog-collapse"
                >
                  <ul class="pb-1 ps-5">
                    <li class="py-2" v-permission="'manufacturers.index'">
                      <nuxt-link
                        :to="localePath('/admin/manufacturers')"
                        class="d-inline-flex align-items-center rounded"
                        >{{ this.$t("sidebar.manufacturer") }}</nuxt-link
                      >
                    </li>
                    <li class="py-2" v-permission="'brands.index'">
                      <nuxt-link
                        :to="localePath('/admin/brands')"
                        class="d-inline-flex align-items-center rounded"
                        >{{ this.$t("sidebar.brand") }}</nuxt-link
                      >
                    </li>
                    <li class="py-2" v-permission="'units.index'">
                      <nuxt-link
                        :to="localePath('/admin/units')"
                        class="d-inline-flex align-items-center rounded"
                        >{{ this.$t("sidebar.unit") }}</nuxt-link
                      >
                    </li>
                    <li class="py-2" v-permission="'categories.index'">
                      <nuxt-link
                        :to="localePath('/admin/categories')"
                        class="d-inline-flex align-items-center rounded"
                        >{{ this.$t("sidebar.category") }}</nuxt-link
                      >
                    </li>
                    <li class="py-2" v-permission="'attributes.index'">
                      <nuxt-link
                        :to="localePath('/admin/attributes')"
                        class="d-inline-flex align-items-center rounded"
                        >{{ this.$t("sidebar.attribute") }}</nuxt-link
                      >
                    </li>
                    <!-- <li class="py-2" v-permission="'attribute_values.index'">
                      <nuxt-link
                        :to="localePath('/admin/attribute_values')"
                        class="d-inline-flex align-items-center rounded"
                        >{{ this.$t("sidebar.attribute_value") }}</nuxt-link
                      >
                    </li> -->
                    <li class="py-2" v-permission="'products.index'">
                      <nuxt-link
                        :to="localePath('/admin/products')"
                        class="d-inline-flex align-items-center rounded"
                        >{{ this.$t("sidebar.product") }}</nuxt-link
                      >
                    </li>
                    <!-- <li class="py-2" v-permission="'inventories.index'">
                      <nuxt-link
                        :to="localePath('/admin/inventories')"
                        class="d-inline-flex align-items-center rounded"
                        >{{ this.$t("sidebar.inventory") }}</nuxt-link
                      >
                    </li> -->
                    <li class="py-2" v-permission="'reviews.index'">
                      <nuxt-link
                        :to="localePath('/admin/reviews')"
                        class="d-inline-flex align-items-center rounded"
                        >{{ this.$t("sidebar.review") }}</nuxt-link
                      >
                    </li>
                    <li class="py-2" v-permission="'review_statuses.index'">
                      <nuxt-link
                        :to="localePath('/admin/review_statuses')"
                        class="d-inline-flex align-items-center rounded"
                        >{{ this.$t("sidebar.review_status") }}</nuxt-link
                      >
                    </li>
                    <li class="py-2" v-permission="'faqs.index'">
                      <nuxt-link
                        :to="localePath('/admin/faqs')"
                        class="d-inline-flex align-items-center rounded"
                        >{{ this.$t("sidebar.faq") }}</nuxt-link
                      >
                    </li>
                  </ul>
                </div>
              </li>
              <!-- vendors-sidebar -->
              <li
                class="nav-item accordion-item"
                v-permission:any="'vendors.index|commissions.update'"
                v-if="
                  allActiveSettings &&
                  allActiveSettings.settings &&
                  allActiveSettings.settings.generalSettings &&
                  allActiveSettings.settings.generalSettings.is_multi_vendor ==
                    '1'
                "
              >
                <div
                  class="nav-link collapsed"
                  data-bs-toggle="collapse"
                  data-bs-target="#catalog-vendors-collapse"
                  aria-expanded="false"
                  aria-current="true"
                >
                  <span class="svg-icon nav-icon">
                    <fa :icon="['fas', 'store']" fixed-width class="" />
                  </span>
                  <span class="nav-text">{{ this.$t("sidebar.vendor") }}</span>
                  <fa
                    :icon="['fas', 'chevron-down']"
                    fixed-width
                    class="rotate-90"
                  />
                </div>
                <div
                  data-bs-parent="#accordionExample"
                  class="accordion-collapse collapse rounded bg-light"
                  id="catalog-vendors-collapse"
                >
                  <ul class="pb-1 ps-5">
                    <li class="py-2" v-permission="'vendors.index'">
                      <nuxt-link
                        :to="localePath('/admin/vendors')"
                        class="d-inline-flex align-items-center rounded"
                        >{{ this.$t("sidebar.vendor") }}</nuxt-link
                      >
                    </li>
                    <li class="py-2" v-permission="'commissions.update'">
                      <nuxt-link
                        :to="localePath('/admin/commissions')"
                        class="d-inline-flex align-items-center rounded"
                        >{{ this.$t("sidebar.commission") }}</nuxt-link
                      >
                    </li>
                    <li
                      class="py-2"
                      v-permission="'payout_requests.index'"
                      @click="close_collapse"
                    >
                      <nuxt-link
                        :to="localePath('/admin/payout_requests')"
                        class="d-inline-flex align-items-center rounded"
                      >
                        {{ this.$t("sidebar.payout_requests.label") }}
                      </nuxt-link>
                    </li>
                  </ul>
                </div>
              </li>

              <li class="nav-item accordion-item" v-permission="'orders.index'">
                <div
                  class="nav-link collapsed"
                  data-bs-toggle="collapse"
                  data-bs-target="#catalog-orders-collapse"
                  aria-expanded="false"
                  aria-current="true"
                >
                  <span class="svg-icon nav-icon">
                    <fa :icon="['fas', 'layer-group']" fixed-width class="" />
                  </span>
                  <span class="nav-text">{{ this.$t("sidebar.order") }}</span>
                  <fa
                    :icon="['fas', 'chevron-down']"
                    fixed-width
                    class="rotate-90"
                  />
                </div>
                <div
                  data-bs-parent="#accordionExample"
                  class="accordion-collapse collapse rounded bg-light"
                  id="catalog-orders-collapse"
                >
                  <ul class="pb-1 ps-5">
                    <li class="py-2" v-permission="'orders.index'">
                      <nuxt-link
                        :to="localePath('/admin/orders')"
                        class="d-inline-flex align-items-center rounded"
                        >{{ this.$t("sidebar.order") }}</nuxt-link
                      >
                    </li>
                    <li class="py-2" v-permission="'order_statuses.index'">
                      <nuxt-link
                        :to="localePath('/admin/order_statuses')"
                        class="d-inline-flex align-items-center rounded"
                        >{{ this.$t("sidebar.order_status") }}</nuxt-link
                      >
                    </li>
                  </ul>
                </div>
              </li>
              <li
                class="nav-item accordion-item"
                v-permission="'reports.index'"
              >
                <div
                  class="nav-link collapsed"
                  data-bs-toggle="collapse"
                  data-bs-target="#catalog-reports-collapse"
                  aria-expanded="false"
                  aria-current="true"
                >
                  <span class="svg-icon nav-icon">
                    <fa :icon="['fas', 'file-contract']" fixed-width class="" />
                  </span>
                  <span class="nav-text">{{
                    this.$t("sidebar.reports.label")
                  }}</span>
                  <fa
                    :icon="['fas', 'chevron-down']"
                    fixed-width
                    class="rotate-90"
                  />
                </div>
                <div
                  data-bs-parent="#accordionExample"
                  class="accordion-collapse collapse rounded bg-light"
                  id="catalog-reports-collapse"
                >
                  <ul class="pb-1 ps-5">
                    <li class="py-2" v-permission="'orders.index'">
                      <nuxt-link
                        :to="localePath('/admin/reports/orders')"
                        class="d-inline-flex align-items-center rounded"
                        >{{ this.$t("sidebar.order") }}</nuxt-link
                      >
                    </li>
                    <li class="py-2" v-permission="'sales.index'">
                      <nuxt-link
                        :to="localePath('/admin/reports/sales')"
                        class="d-inline-flex align-items-center rounded"
                        >{{ this.$t("sidebar.reports.sale") }}</nuxt-link
                      >
                    </li>
                    <li class="py-2" v-permission="'customers.index'">
                      <nuxt-link
                        :to="localePath('/admin/reports/customers')"
                        class="d-inline-flex align-items-center rounded"
                        >{{ this.$t("sidebar.reports.customer") }}</nuxt-link
                      >
                    </li>
                    <li class="py-2" v-permission="'products.index'">
                      <nuxt-link
                        :to="localePath('/admin/reports/products')"
                        class="d-inline-flex align-items-center rounded"
                        >{{ this.$t("sidebar.reports.product") }}</nuxt-link
                      >
                    </li>
                  </ul>
                </div>
              </li>

              <li
                class="nav-item"
                v-permission="'shipping_methods.index'"
                @click="close_collapse"
              >
                <nuxt-link
                  :to="localePath('/admin/shipping_methods')"
                  class="nav-link"
                >
                  <span class="svg-icon nav-icon">
                    <fa :icon="['fas', 'shipping-fast']" fixed-width class="" />
                  </span>
                  <span class="nav-text">
                    {{ this.$t("sidebar.shipping_method") }}
                  </span>
                </nuxt-link>
              </li>
              <li
                class="nav-item"
                v-permission="'payment_methods.index'"
                @click="close_collapse"
              >
                <nuxt-link
                  :to="localePath('/admin/payment_methods')"
                  class="nav-link"
                >
                  <span class="svg-icon nav-icon">
                    <fa :icon="['fas', 'credit-card']" fixed-width class="" />
                  </span>
                  <span class="nav-text">
                    {{ this.$t("sidebar.payment_method") }}
                  </span>
                </nuxt-link>
              </li>

              <li
                class="nav-item"
                v-permission="'currencies.index'"
                @click="close_collapse"
              >
                <nuxt-link
                  :to="localePath('/admin/currencies')"
                  class="nav-link"
                >
                  <span class="svg-icon nav-icon">
                    <fa :icon="['fas', 'dollar-sign']" fixed-width class="" />
                  </span>
                  <span class="nav-text">
                    {{ this.$t("sidebar.currency") }}
                  </span>
                </nuxt-link>
              </li>
              <!-- countries-sidebar -->
              <li
                class="nav-item accordion-item"
                v-permission:any="
                  'countries.index|zones.index|states.index|cities.index|tax_classes.index|tax_rates.index'
                "
              >
                <div
                  class="nav-link collapsed"
                  data-bs-toggle="collapse"
                  data-bs-target="#catalog-tax_location-collapse"
                  aria-expanded="false"
                  aria-current="true"
                >
                  <span class="svg-icon nav-icon">
                    <fa
                      :icon="['fas', 'map-marker-alt']"
                      fixed-width
                      class=""
                    />
                  </span>
                  <span class="nav-text">{{
                    this.$t("sidebar.tax_location")
                  }}</span>
                  <fa
                    :icon="['fas', 'chevron-down']"
                    fixed-width
                    class="rotate-90"
                  />
                </div>
                <div
                  data-bs-parent="#accordionExample"
                  class="accordion-collapse collapse rounded bg-light"
                  id="catalog-tax_location-collapse"
                >
                  <ul class="pb-1 ps-5">
                    <li class="py-2" v-permission="'countries.index'">
                      <nuxt-link
                        :to="localePath('/admin/countries')"
                        class="d-inline-flex align-items-center rounded"
                        >{{ this.$t("sidebar.country") }}</nuxt-link
                      >
                    </li>
                    <li class="py-2" v-permission="'zones.index'">
                      <nuxt-link
                        :to="localePath('/admin/zones')"
                        class="d-inline-flex align-items-center rounded"
                        >{{ this.$t("sidebar.zone") }}</nuxt-link
                      >
                    </li>
                    <li class="py-2" v-permission="'states.index'">
                      <nuxt-link
                        :to="localePath('/admin/states')"
                        class="d-inline-flex align-items-center rounded"
                        >{{ this.$t("sidebar.state") }}</nuxt-link
                      >
                    </li>
                    <li class="py-2" v-permission="'cities.index'">
                      <nuxt-link
                        :to="localePath('/admin/cities')"
                        class="d-inline-flex align-items-center rounded"
                        >{{ this.$t("sidebar.city") }}</nuxt-link
                      >
                    </li>
                    <li class="py-2" v-permission="'tax_classes.index'">
                      <nuxt-link
                        :to="localePath('/admin/tax_classes')"
                        class="d-inline-flex align-items-center rounded"
                        >{{ this.$t("sidebar.tax_class") }}</nuxt-link
                      >
                    </li>
                    <li class="py-2" v-permission="'tax_rates.index'">
                      <nuxt-link
                        :to="localePath('/admin/tax_rates')"
                        class="d-inline-flex align-items-center rounded"
                        >{{ this.$t("sidebar.tax_rate") }}</nuxt-link
                      >
                    </li>
                  </ul>
                </div>
              </li>
              <!--settings-general-statrt-->
              <li
                class="nav-item accordion-item"
                v-permission:any="
                  'settings.index|store_settings.index|facebook_settings.index|google_settings.index|social_login_settings.index'
                "
              >
                <div
                  class="nav-link collapsed"
                  data-bs-toggle="collapse"
                  data-bs-target="#catalog-settings_general-collapse"
                  aria-expanded="false"
                  aria-current="true"
                >
                  <span class="svg-icon nav-icon">
                    <fa :icon="['fas', 'cog']" fixed-width class="" />
                  </span>
                  <span class="nav-text">{{
                    this.$t("sidebar.settings_general")
                  }}</span>
                  <fa
                    :icon="['fas', 'chevron-down']"
                    fixed-width
                    class="rotate-90"
                  />
                </div>
                <div
                  data-bs-parent="#accordionExample"
                  class="accordion-collapse collapse rounded bg-light"
                  id="catalog-settings_general-collapse"
                >
                  <ul class="pb-1 ps-5">
                    <li class="py-2" v-permission="'settings.index'">
                      <nuxt-link
                        :to="localePath('/admin/settings')"
                        class="d-inline-flex align-items-center rounded"
                        >{{ this.$t("sidebar.setting") }}</nuxt-link
                      >
                    </li>
                  </ul>
                </div>
              </li>
              <!--settings-general-end-->
                   <!--theme-settings-statrt-->
              <li
                class="nav-item accordion-item"
                v-permission:any="
                  'settings.index|store_settings.index|facebook_settings.index|google_settings.index|social_login_settings.index'
                "
              >
                <div
                  class="nav-link collapsed"
                  data-bs-toggle="collapse"
                  data-bs-target="#catalog-theme_settings-collapse"
                  aria-expanded="false"
                  aria-current="true"
                >
                  <span class="svg-icon nav-icon">
                    <fa :icon="['fas', 'cog']" fixed-width class="" />
                  </span>
                  <span class="nav-text">{{
                    this.$t("sidebar.theme_settings")
                  }}</span>
                  <fa
                    :icon="['fas', 'chevron-down']"
                    fixed-width
                    class="rotate-90"
                  />
                </div>
                <div
                  data-bs-parent="#accordionExample"
                  class="accordion-collapse collapse rounded bg-light"
                  id="catalog-theme_settings-collapse"
                >
                  <ul class="pb-1 ps-5">
                    <li class="py-2" v-permission="'theme_settings.index'">
                      <nuxt-link
                        :to="localePath('/admin/theme_settings')"
                        class="d-inline-flex align-items-center rounded"
                        >{{ this.$t("sidebar.theme_settings") }}</nuxt-link
                      >
                    </li>
                  </ul>
                </div>
              </li>
              <!--theme-settings-end-->
              <!--settings-website-statrt-->
              <li
                class="nav-item accordion-item"
                v-permission:any="
                  'slider_images.index|static_banners.index|parallax_banners.index|content_pages.index|seo_pages.index|main_settings.index'
                "
              >
                <div
                  class="nav-link collapsed"
                  data-bs-toggle="collapse"
                  data-bs-target="#catalog-settings_website-collapse"
                  aria-expanded="false"
                  aria-current="true"
                >
                  <span class="svg-icon nav-icon">
                    <fa :icon="['fas', 'laptop']" fixed-width class="" />
                  </span>
                  <span class="nav-text">{{
                    this.$t("sidebar.settings_website")
                  }}</span>
                  <fa
                    :icon="['fas', 'chevron-down']"
                    fixed-width
                    class="rotate-90"
                  />
                </div>
                <div
                  data-bs-parent="#accordionExample"
                  class="accordion-collapse collapse rounded bg-light"
                  id="catalog-settings_website-collapse"
                >
                  <ul class="pb-1 ps-5">
                    <li class="py-2" v-permission="'main_settings.index'">
                      <nuxt-link
                        :to="localePath('/admin/main_settings')"
                        class="d-inline-flex align-items-center rounded"
                        >{{ this.$t("sidebar.main_setting") }}</nuxt-link
                      >
                    </li>
                    <li class="py-2" v-permission="'slider_images.index'">
                      <nuxt-link
                        :to="localePath('/admin/slider_images')"
                        class="d-inline-flex align-items-center rounded"
                        >{{ this.$t("sidebar.slider_image") }}</nuxt-link
                      >
                    </li>
                    <li class="py-2" v-permission="'static_banners.index'">
                      <nuxt-link
                        :to="localePath('/admin/static_banners')"
                        class="d-inline-flex align-items-center rounded"
                        >{{ this.$t("sidebar.static_banner") }}</nuxt-link
                      >
                    </li>
                    <li class="py-2" v-permission="'parallax_banners.index'">
                      <nuxt-link
                        :to="localePath('/admin/parallax_banners')"
                        class="d-inline-flex align-items-center rounded"
                        >{{ this.$t("sidebar.parallax_banner") }}</nuxt-link
                      >
                    </li>
                    <li class="py-2" v-permission="'content_pages.index'">
                      <nuxt-link
                        :to="localePath('/admin/content_pages')"
                        class="d-inline-flex align-items-center rounded"
                        >{{ this.$t("sidebar.content_page") }}</nuxt-link
                      >
                    </li>
                    <li class="py-2" v-permission="'seo_pages.index'">
                      <nuxt-link
                        :to="localePath('/admin/seo_pages')"
                        class="d-inline-flex align-items-center rounded"
                        >{{ this.$t("sidebar.seo_page") }}</nuxt-link
                      >
                    </li>
                  </ul>
                </div>
              </li>
              <!--settings-website-end-->


              <!--settings-application-statrt-->
              <li
                class="nav-item accordion-item"
                v-permission:any="
                  'application_banners.index|application_slider_images.index|application_api.index|content_application_pages.index|splash_screens.index|application_parallax_banners.index|api_protection_settings.index'
                "
              >
                <div
                  class="nav-link collapsed"
                  data-bs-toggle="collapse"
                  data-bs-target="#catalog-settings_application-collapse"
                  aria-expanded="false"
                  aria-current="true"
                >
                  <span class="svg-icon nav-icon">
                    <fa :icon="['fas', 'mobile-alt']" fixed-width class="" />
                  </span>
                  <span class="nav-text">{{
                    this.$t("sidebar.settings_application")
                  }}</span>
                  <fa
                    :icon="['fas', 'chevron-down']"
                    fixed-width
                    class="rotate-90"
                  />
                </div>
                <div
                  data-bs-parent="#accordionExample"
                  class="accordion-collapse collapse rounded bg-light"
                  id="catalog-settings_application-collapse"
                >
                  <ul class="pb-1 ps-5">
                    <li class="py-2" v-permission="'application_banners.index'">
                      <nuxt-link
                        :to="localePath('/admin/application_banners')"
                        class="d-inline-flex align-items-center rounded"
                        >{{ this.$t("sidebar.application_banner") }}</nuxt-link
                      >
                    </li>
                    <li
                      class="py-2"
                      v-permission="'application_parallax_banners.index'"
                    >
                      <nuxt-link
                        :to="localePath('/admin/application_parallax_banners')"
                        class="d-inline-flex align-items-center rounded"
                        >{{
                          this.$t("sidebar.application_parallax_banner")
                        }}</nuxt-link
                      >
                    </li>
                    <li
                      class="py-2"
                      v-permission="'application_slider_images.index'"
                    >
                      <nuxt-link
                        :to="localePath('/admin/application_slider_images')"
                        class="d-inline-flex align-items-center rounded"
                        >{{
                          this.$t("sidebar.application_slider_image")
                        }}</nuxt-link
                      >
                    </li>
                    <li
                      class="py-2"
                      v-permission="'content_application_pages.index'"
                    >
                      <nuxt-link
                        :to="localePath('/admin/content_application_pages')"
                        class="d-inline-flex align-items-center rounded"
                        >{{
                          this.$t("sidebar.content_application_page")
                        }}</nuxt-link
                      >
                    </li>
                    <li
                      class="py-2"
                      v-permission="'api_protection_settings.index'"
                    >
                      <nuxt-link
                        :to="localePath('/admin/api_protection_settings')"
                        class="d-inline-flex align-items-center rounded"
                        >{{
                          this.$t("sidebar.api_protection_setting")
                        }}</nuxt-link
                      >
                    </li>
                  </ul>
                </div>
              </li>
              <!--settings-application-end-->
              <li
                class="nav-item"
                v-permission="'coupons.index'"
                @click="close_collapse"
              >
                <nuxt-link :to="localePath('/admin/coupons')" class="nav-link">
                  <span class="svg-icon nav-icon">
                    <fa :icon="['fas', 'receipt']" fixed-width class="" />
                  </span>
                  <span class="nav-text">
                    {{ this.$t("sidebar.coupon") }}
                  </span>
                </nuxt-link>
              </li>
              <!-- rider sidebar starts -->
              <li
                class="nav-item accordion-item"
                v-permission="'riders.index'"
                v-if="
                  allSettings.general_settings.is_rider_shipping == 1"
              >
                <div
                  class="nav-link collapsed"
                  data-bs-toggle="collapse"
                  data-bs-target="#catalog-riders-collapse"
                  aria-expanded="false"
                  aria-current="true"
                >
                  <span class="svg-icon nav-icon">
                    <fa :icon="['fas', 'shipping-fast']" fixed-width class="" />
                  </span>
                  <span class="nav-text">{{ this.$t("sidebar.rider") }}</span>
                  <fa
                    :icon="['fas', 'chevron-down']"
                    fixed-width
                    class="rotate-90"
                  />
                </div>
                <div
                  data-bs-parent="#accordionExample"
                  class="accordion-collapse collapse rounded bg-light"
                  id="catalog-riders-collapse"
                >
                  <ul class="pb-1 ps-5">
                    <li class="py-2" v-permission="'riders.index'">
                      <nuxt-link
                        :to="localePath('/admin/riders')"
                        class="d-inline-flex align-items-center rounded"
                        >{{ this.$t("sidebar.rider") }}</nuxt-link
                      >
                    </li>
                    <li
                      class="py-2"
                      v-permission="'rider_payout_requests.index'" v-if="
                  allActiveSettings &&
                  allActiveSettings.settings &&
                  allActiveSettings.settings.generalSettings &&
                  allActiveSettings.settings.generalSettings.is_multi_vendor ==
                    '0'"
                    >
                      <nuxt-link
                        :to="localePath('/admin/rider_payout_requests')"
                        class="d-inline-flex align-items-center rounded"
                        >{{
                          this.$t("sidebar.rider_payout_requests.label")
                        }}</nuxt-link
                      >
                    </li>
                     <li
                      class="py-2"
                      v-permission="'rider_shipping.index'" v-if="
                  allActiveSettings &&
                  allActiveSettings.settings &&
                  allActiveSettings.settings.generalSettings &&
                  allActiveSettings.settings.generalSettings.is_multi_vendor ==
                    '0'"
                    >
                      <nuxt-link
                        :to="localePath('/admin/rider_shipping')"
                        class="d-inline-flex align-items-center rounded"
                        >{{
                          this.$t("sidebar.rider_shipping.label")
                        }}</nuxt-link
                      >
                    </li>
                    <li class="py-2" v-permission="'live_chat.index'" v-if="
                  allActiveSettings &&
                  allActiveSettings.settings &&
                  allActiveSettings.settings.generalSettings &&
                  allActiveSettings.settings.generalSettings.is_multi_vendor ==
                    '0'">
                      <nuxt-link
                        :to="localePath('/admin/live_chat')"
                        class="d-inline-flex align-items-center rounded"
                      >
                        {{ this.$t("sidebar.live_chat.label") }}
                      </nuxt-link>
                    </li>
                  </ul>
                </div>
              </li>
              <!-- rider sidebar ends -->
              <li
                class="nav-item"
                v-permission="'newsletters.index'"
                @click="close_collapse"
              >
                <nuxt-link
                  :to="localePath('/admin/newsletters')"
                  class="nav-link"
                >
                  <span class="svg-icon nav-icon">
                    <fa :icon="['fas', 'newspaper']" fixed-width class="" />
                  </span>
                  <span class="nav-text">
                    {{ this.$t("sidebar.newsletter") }}
                  </span>
                </nuxt-link>
              </li>
              <li
                class="nav-item"
                v-permission="'contact_forms.index'"
                @click="close_collapse"
              >
                <nuxt-link
                  :to="localePath('/admin/contact_forms')"
                  class="nav-link"
                >
                  <span class="svg-icon nav-icon">
                    <fa :icon="['fas', 'file-contract']" fixed-width class="" />
                  </span>
                  <span class="nav-text">
                    {{ this.$t("sidebar.contact_form") }}
                  </span>
                </nuxt-link>
              </li>
              <!-- blog start  -->
              <li
                class="nav-item accordion-item"
                v-permission:any="'news_categories.index|newses.index'"
              >
                <div
                  class="nav-link collapsed"
                  data-bs-toggle="collapse"
                  data-bs-target="#blog-collapse"
                  aria-expanded="false"
                  aria-current="true"
                >
                  <span class="svg-icon nav-icon">
                    <fa :icon="['fas', 'blog']" fixed-width class="" />
                  </span>
                  <span class="nav-text">{{ this.$t("sidebar.blog") }}</span>
                  <fa
                    :icon="['fas', 'chevron-down']"
                    fixed-width
                    class="rotate-90"
                  />
                </div>
                <div
                  data-bs-parent="#accordionExample"
                  class="collapse rounded bg-light"
                  id="blog-collapse"
                >
                  <ul class="pb-1 ps-5">
                    <li class="py-2" v-permission="'news_categories.index'">
                      <nuxt-link
                        :to="localePath('/admin/news_categories')"
                        class="d-inline-flex align-items-center rounded"
                        >{{ this.$t("sidebar.news_category") }}</nuxt-link
                      >
                    </li>
                    <li class="py-2" v-permission="'newses.index'">
                      <nuxt-link
                        :to="localePath('/admin/news')"
                        class="d-inline-flex align-items-center rounded"
                        >{{ this.$t("sidebar.news") }}</nuxt-link
                      >
                    </li>
                  </ul>
                </div>
              </li>
              <!-- blog end -->
                    <!-- Footer Pages Start  -->
                    <li
                class="nav-item accordion-item"
              >
                <div
                  class="nav-link collapsed"
                  data-bs-toggle="collapse"
                  data-bs-target="#pages-collapse"
                  aria-expanded="false"
                  aria-current="true"
                >
                  <span class="svg-icon nav-icon">
                    <fa :icon="['fas', 'file-contract']" fixed-width class="" />
                  </span>
                  <span class="nav-text">{{ this.$t("sidebar.pages") }}</span>
                  <fa
                    :icon="['fas', 'chevron-down']"
                    fixed-width
                    class="rotate-90"
                  />
                </div>
                <div
                  data-bs-parent="#accordionExample"
                  class="collapse rounded bg-light"
                  id="pages-collapse"
                >
                  <ul class="pb-1 ps-5">
                    <li class="py-2">
                      <nuxt-link
                        :to="localePath('/admin/about_us')"
                        class="d-inline-flex align-items-center rounded"
                        >{{ this.$t("sidebar.about_us") }}</nuxt-link
                      >
                    </li>
                    <li class="py-2">
                      <nuxt-link
                        :to="localePath('/admin/term_condition')"
                        class="d-inline-flex align-items-center rounded"
                        >{{ this.$t("sidebar.term_condition") }}</nuxt-link
                      >
                    </li>
                    <li class="py-2">
                      <nuxt-link
                        :to="localePath('/admin/privacy_policy')"
                        class="d-inline-flex align-items-center rounded"
                        >{{ this.$t("sidebar.privacy_policy") }}</nuxt-link
                      >
                    </li>
                    <li class="py-2">
                      <nuxt-link
                        :to="localePath('/admin/refund_policy')"
                        class="d-inline-flex align-items-center rounded"
                        >{{ this.$t("sidebar.refund_policy") }}</nuxt-link
                      >
                    </li>
                  </ul>
                </div>
              </li>
              <!-- Footer Pages End -->
              <li
                class="nav-item accordion-item"
                v-permission:any="'roles.index|customers.index|admins.index'"
              >
                <div
                  class="nav-link collapsed"
                  data-bs-toggle="collapse"
                  data-bs-target="#users-collapse"
                  aria-expanded="false"
                  aria-current="true"
                >
                  <span class="svg-icon nav-icon">
                    <fa :icon="['fas', 'users']" fixed-width class="" />
                  </span>
                  <span class="nav-text">{{
                    this.$t("sidebar.user_catalog")
                  }}</span>
                  <fa
                    :icon="['fas', 'chevron-down']"
                    fixed-width
                    class="rotate-90"
                  />
                </div>
                <div
                  data-bs-parent="#accordionExample"
                  class="collapse rounded bg-light"
                  id="users-collapse"
                >
                  <ul class="pb-1 ps-5" v-permission="'roles.index'">
                    <li class="py-2">
                      <nuxt-link
                        :to="localePath('/admin/roles')"
                        class="d-inline-flex align-items-center rounded"
                        >{{ this.$t("sidebar.role") }}</nuxt-link
                      >
                    </li>
                    <li class="py-2" v-permission="'admins.index'">
                      <nuxt-link
                        :to="localePath('/admin/admins')"
                        class="d-inline-flex align-items-center rounded"
                        >{{ this.$t("sidebar.admin") }}</nuxt-link
                      >
                    </li>
                    <li class="py-2" v-permission="'customers.index'">
                      <nuxt-link
                        :to="localePath('/admin/customers')"
                        class="d-inline-flex align-items-center rounded"
                        >{{ this.$t("sidebar.customer") }}</nuxt-link
                      >
                    </li>
                  </ul>
                </div>
              </li>
            </div>
          </ul>
          <!--end::Menu Nav-->
        </div>
        <!--end::Menu Container-->
      </div>
      <!--end::Aside Menu-->
    </div>
  </div>
</template>
<script>
import { mapGetters } from "vuex";
// import LocaleDropdown from './LocaleDropdown'
export default {
  props: ["themeData"],
  components: {
    // LocaleDropdown
  },
  created() {},
  data() {
    return {};
  },

  computed: {
    ...mapGetters({
      allActiveSettings: "General/allActiveSettings",
      allSettings: "allDefaultSettings",
    }),
  },
  methods: {
    aside_Min: function () {
      const body = document.querySelector("body");
      if (body.classList.contains("aside-minimize")) {
        //  const body = document.querySelector("body");
        body.classList.add("aside-minimize-hover");
      }
    },

    aside_close: function () {
      const body = document.querySelector("body");
      body.classList.remove("aside-minimize-hover");
    },

    close_collapse: function () {
      var collapseElementList = document.querySelectorAll(".nav-link");
      for (let index = 0; index < collapseElementList.length; index++) {
        collapseElementList[index].classList.add("collapsed");
      }
      var collapseElementList = document.querySelectorAll(".collapse");
      for (let index = 0; index < collapseElementList.length; index++) {
        collapseElementList[index].classList.remove("show");
      }
    },
  },
};
</script>

<style scoped>
</style>
