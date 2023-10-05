<template>
  <section class="shop-page m-0">
    <WebsiteGlobalComponentsBreadCrumb :page="`shop`" v-if="currentlyActiveTemplate == 'Template1'" />
    <WebsiteGlobalComponentsVandersPromoSection :page="`shop`"  v-if="currentlyActiveTemplate == 'Template1'" />
    <Component :is="`Website${currentlyActiveTemplate}ShopPage`" />
    <WebsiteTemplate1NewsLetterSection />
  </section>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
export default {
  auth: false,
  data() {
    return {
      currentlyActiveTemplate: "",
    };
  },
  created() {
    this.currentlyActiveTemplate =
      this.allSettings.general_settings.currently_active_theme;
  },
  head() {
    if (
      this.allSettings &&
      this.allSettings.seo &&
      this.allSettings.seo.shop_page
    ) {
      return this.allSettings.seo.shop_page;
    } else {
      return { title: this.$t("shop") };
    }
  },
  computed: {
    ...mapGetters({
      allSettings: "allDefaultSettings",
    })
  },
};
</script>
