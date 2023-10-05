<template>
  <Footer>
    <div class="footer_layout_one">
      <div class="footer" v-if="allFooterData">
        <div class="container">
          <div class="row border-bottom py-5">
            <div
              class="col-md-3 col-6 mb-4 mb-md-0"
              v-if="allFooterData.categories.length > 0"
            >
              <h5>{{ this.$t("web.home.footer.categories") }}</h5>
              <ul>
                <li v-for="category in allFooterData.categories">
                  <nuxt-link
                    :to="{ path: '/shop', query: { category: category.slug } }"
                    >{{ category.name }}</nuxt-link
                  >
                </li>
              </ul>
            </div>
            <div class="col-md-3 col-6 mb-4 mb-md-0">
              <h5>{{ this.$t("web.home.footer.content_pages") }}</h5>
              <ul>
                <li v-for="content_page in allFooterData.content_pages">
                  <nuxt-link :to="`/page/${content_page.slug}`">{{
                    content_page.name
                  }}</nuxt-link>
                </li>
              </ul>
            </div>
            <div class="col-md-3 col-6">
              <h5>{{ this.$t("web.home.footer.quick_links.heading") }}</h5>
              <ul>
                <li
                  v-if="
                    allDefaultSettings &&
                    allDefaultSettings.general_settings &&
                    allDefaultSettings.general_settings.is_multi_vendor == 1
                  "
                >
                  <nuxt-link to="/stores">{{
                    this.$t("web.home.navbar.stores")
                  }}</nuxt-link>
                </li>
                <li>
                  <nuxt-link to="/shop">{{
                    this.$t("web.home.navbar.shop")
                  }}</nuxt-link>
                </li>
                <li>
                  <nuxt-link to="/brands">{{
                    this.$t("web.home.navbar.brands")
                  }}</nuxt-link>
                </li>
                <li>
                  <nuxt-link to="/blog">{{
                    this.$t("web.home.navbar.blog")
                  }}</nuxt-link>
                </li>
              </ul>
            </div>
            <div class="col-md-3 col-6">
              <h5>{{ this.$t("web.home.footer.contact.heading") }}</h5>
              <ul>
                <li>
                  <nuxt-link to="/contact">{{
                    this.$t("web.home.navbar.contact")
                  }}</nuxt-link>
                </li>
                <li>
                  <nuxt-link to="/aboutus">{{
                    this.$t("web.home.navbar.about")
                  }}</nuxt-link>
                </li>
                <li>
                  <nuxt-link to="/termcondition">{{ $t("term_condition") }}</nuxt-link>
                </li>
                <li>
                  <nuxt-link to="/refundpolicy">{{ $t("refund_policy") }}</nuxt-link>
                </li>
                <li>
                  <nuxt-link to="/privacypolicy">{{ $t("privacy_policy") }}</nuxt-link>
                </li>
              <li>
                  <nuxt-link to="/blog">
                  Blog</nuxt-link>
                </li>
              </ul>
            </div>
          </div>

          <div class="row py-5">
            <div class="col-lg-8 col-md-7 col-sm-8 col-7">
              <p class="pe-5">
                {{ this.$t("web.home.footer.copyright.description") }}
              </p>
            </div>
            <div class="col-lg-4 col-md-5 col-sm-4 col-5 text-end">
              <img
                src="~/assets/images/mastercard.png"
                alt=""
                class="px-2 mb-3 mb-md-0"
              />
              <img
                src="~/assets/images/paypal.png"
                alt=""
                class="px-2 mb-3 mb-md-0"
              />
              <img src="~/assets/images/visa.png" alt="" class="px-2" />
              <img src="~/assets/images/aE.png" alt="" class="px-2" />
            </div>
          </div>
        </div>
        <div class="copyright">
          <div class="container">
            <div class="row py-3">
              <div class="col-sm-6">
                {{ this.allDefaultSettings.general_settings.copyright_text }}
              </div>
              <div class="col-sm-6 text-end">
                <a
                  class="text-white"
                  :href="this.allDefaultSettings.general_settings.facebook_url"
                  v-if="this.allDefaultSettings.general_settings.facebook_url"
                >
                  <i data-feather="facebook"></i>
                </a>
                <a
                  class="text-white"
                  :href="this.allDefaultSettings.general_settings.linked_in_url"
                  v-if="this.allDefaultSettings.general_settings.linked_in_url"
                >
                  <i data-feather="linkedin"></i>
                </a>
                <a
                  class="text-white"
                  :href="this.allDefaultSettings.general_settings.instagram"
                  v-if="this.allDefaultSettings.general_settings.instagram"
                >
                  <i data-feather="instagram"></i>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </Footer>
</template>

<script>
import { mapGetters, mapActions } from "vuex";

export default {
  components: {
  },
  async fetch() {
    if (!this.allFooterData) {
      await this.fetchFooterData();
    }
  },

  data() {
    return {
      appName: process.env.appName,
    };
  },

  computed: mapGetters({
    allFooterData: "Web/General/allFooterData",
    allDefaultSettings: "allDefaultSettings",
  }),

  methods: {
    ...mapActions({
      fetchFooterData: "Web/General/fetchFooterData",
    }),
  },
};
</script>

<style scoped>
</style>
