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
          :to="localePath('/seller/dashboard')"
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
                  :to="localePath('/seller/languages')"
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
                        :to="localePath('/seller/media')"
                        class="d-inline-flex align-items-center rounded"
                        >{{ this.$t("sidebar.media") }}
                      </nuxt-link>
                    </li>
                    <li class="py-2" v-permission="'media_settings.index'">
                      <nuxt-link
                        to="/seller/media/settings"
                        class="d-inline-flex align-items-center rounded"
                        >{{ this.$t("sidebar.media_setting") }}</nuxt-link
                      >
                    </li>
                  </ul>
                </div>
              </li>
              <li class="nav-item accordion-item">
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
                    <li class="py-2">
                      <nuxt-link
                        :to="localePath('/seller/products')"
                        class="d-inline-flex align-items-center rounded"
                        >{{ this.$t("sidebar.product") }}</nuxt-link
                      >
                    </li>
                    <li class="py-2">
                      <nuxt-link
                        :to="localePath('/seller/reviews')"
                        class="d-inline-flex align-items-center rounded"
                        >{{ this.$t("sidebar.review") }}</nuxt-link
                      >
                    </li>
                    <!-- <li class="py-2">
                      <nuxt-link
                        :to="localePath('/seller/reviews')"
                        class="d-inline-flex align-items-center rounded"
                        >{{ this.$t("sidebar.review") }}</nuxt-link
                      >
                    </li>
                    <li class="py-2">
                      <nuxt-link
                        :to="localePath('/seller/faqs')"
                        class="d-inline-flex align-items-center rounded"
                        >{{ this.$t("sidebar.faq") }}</nuxt-link
                      >
                    </li> -->
                  </ul>
                </div>
              </li>
              <!-- vendors-sidebar -->
              <li class="nav-item" @click="close_collapse">
                <nuxt-link :to="localePath('/seller/orders')" class="nav-link">
                  <span class="svg-icon nav-icon">
                    <fa :icon="['fas', 'layer-group']" fixed-width class="" />
                  </span>
                  <span class="nav-text">
                    {{ this.$t("sidebar.order") }}
                  </span>
                </nuxt-link>
              </li>

              <!----report starts ---->
              <li class="nav-item accordion-item">
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
                    <li class="py-2">
                      <nuxt-link
                        :to="localePath('/seller/reports/orders')"
                        class="d-inline-flex align-items-center rounded"
                        >{{ this.$t("sidebar.order") }}</nuxt-link
                      >
                    </li>
                    <li class="py-2">
                      <nuxt-link
                        :to="localePath('/seller/reports/sales')"
                        class="d-inline-flex align-items-center rounded"
                        >{{ this.$t("sidebar.reports.sale") }}</nuxt-link
                      >
                    </li>
                    <li class="py-2">
                      <nuxt-link
                        :to="localePath('/seller/reports/products')"
                        class="d-inline-flex align-items-center rounded"
                        >{{ this.$t("sidebar.reports.product") }}</nuxt-link
                      >
                    </li>
                  </ul>
                </div>
              </li>
              <!----report ends---->
              <!----RIDER starts ---->
              <li
                class="nav-item accordion-item"
                v-if="allSettings.general_settings.is_rider_shipping == 1"
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
                    <li class="py-2">
                      <nuxt-link
                        :to="localePath('/seller/riders')"
                        class="d-inline-flex align-items-center rounded"
                        >{{ this.$t("sidebar.rider") }}</nuxt-link
                      >
                    </li>
                    <li class="py-2">
                      <nuxt-link
                        :to="localePath('/seller/rider_payout_requests')"
                        class="d-inline-flex align-items-center rounded"
                        >{{
                          this.$t("sidebar.rider_payout_requests.label")
                        }}</nuxt-link
                      >
                    </li>
                     <li class="py-2">
                      <nuxt-link
                        :to="localePath('/seller/rider_shipping')"
                        class="d-inline-flex align-items-center rounded"
                      >
                        {{ this.$t("sidebar.rider_shipping.label") }}
                      </nuxt-link>
                    </li>
                    <li class="py-2">
                      <nuxt-link
                        :to="localePath('/seller/live_chat')"
                        class="d-inline-flex align-items-center rounded"
                      >
                        {{ this.$t("sidebar.live_chat.label") }}
                      </nuxt-link>
                    </li>
                  </ul>
                </div>
              </li>
              <!----RIDER ends---->
              <li class="nav-item" @click="close_collapse">
                <nuxt-link :to="localePath('/seller/wallet')" class="nav-link">
                  <span class="svg-icon nav-icon">
                    <fa :icon="['fas', 'wallet']" fixed-width class="" />
                  </span>
                  <span class="nav-text">
                    {{ this.$t("sidebar.wallet") }}
                  </span>
                </nuxt-link>
              </li>
              <!--settings-general-statrt-->
              <li class="nav-item accordion-item">
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
                    <li class="py-2">
                      <nuxt-link
                        :to="localePath('/seller/store_settings')"
                        class="d-inline-flex align-items-center rounded"
                        >{{ this.$t("sidebar.store_setting") }}</nuxt-link
                      >
                    </li>
                    <!-- <li class="py-2" >
                      <nuxt-link
                        :to="localePath('/seller/seo_pages')"
                        class="d-inline-flex align-items-center rounded"
                        >{{ this.$t("sidebar.seo_page") }}</nuxt-link
                      >
                    </li> -->
                  </ul>
                </div>
              </li>
              <!--settings-general-end-->
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
