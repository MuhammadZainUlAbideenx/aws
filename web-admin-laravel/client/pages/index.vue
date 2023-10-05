<template>
  <section class="home-page">
  <div v-if="currentlyActiveTemplate == 'Template1'">
      <WebsiteTemplate1HeroSliderSection />
      <WebsiteTemplate1StaticCardsSection />
      <WebsiteTemplate1FlashSaleCardSection />
      <WebsiteTemplate1AvailableCoupons />
      <WebsiteTemplate1FeaturedItemsSection />
      <WebsiteTemplate1NewArrivalsSection />
      <WebsiteTemplate1ParallexSection />
      <WebsiteTemplate1FeaturedVendorsSection v-if="allSettings && allSettings.general_settings && allSettings.general_settings.is_multi_vendor && allSettings.general_settings.is_multi_vendor == 1" />
      <WebsiteTemplate1UpComingItems />
      <WebsiteTemplate1Testimonials />
      <WebsiteTemplate1TopBrands />
      <WebsiteTemplate1BlogSection />
      <WebsiteTemplate1PermotionSection />
      <WebsiteTemplate1InstaFeed />
      <WebsiteTemplate1NewsLetterSection />
      <WebsiteTemplate1ModalProductDetail />
      <WebsiteTemplate1ModalNewsLetter />
    </div>
    <div v-if="currentlyActiveTemplate == 'Template2'">
      <WebsiteTemplate2HeroSliderSection />
      <WebsiteTemplate2CategorySliderSection />
      <WebsiteTemplate2AvailableCoupons />
      <WebsiteTemplate2FeaturedItemsSection />
      <WebsiteTemplate2FlashSaleCardSection />
      <WebsiteTemplate2NewArrivalsProducts />
      <WebsiteTemplate2CategoryBannerProSection />

      <WebsiteTemplate2TrendingProductSection />
      <WebsiteTemplate2PermotionSection />
      <WebsiteTemplate2BlogSection />
      <WebsiteTemplate2ModalNewsLetter />
    </div>
  </section>
</template>

<script>
import { mapGetters } from "vuex";
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
      this.allSettings.seo.home_page
    ) {
      return this.allSettings.seo.home_page;
    } else {
      return { title: this.$t("home") };
    }
  },
  data() {
    return {
      title: process.env.appName,
    };
  },
   mounted()
    {

        if ( this.allSettings.general_settings.is_web_chat_enabled) {
                 this.loadAsync(function() {
            });
        }
    },

  methods: {
        loadAsync(callback) {
        var url = `https://static.zdassets.com/ekr/snippet.js?key=${this.allSettings.general_settings.zendesk_api_key}`;
      var s = document.createElement('script');
      s.setAttribute('id', "ze-snippet");
      s.setAttribute('src', url); s.onload = callback;
      document.head.insertBefore(s, document.head.firstElementChild);
    }
    },
  computed: {
    ...mapGetters({
      allSettings: "allDefaultSettings",
    }),
  },

};
</script>
<style scoped>
.top-right {
  position: absolute;
  right: 10px;
  top: 18px;
}

.title {
  font-size: 85px;
}

.laravel {
  color: #2e495e;
}

.nuxt {
  color: #00c48d;
}
</style>
