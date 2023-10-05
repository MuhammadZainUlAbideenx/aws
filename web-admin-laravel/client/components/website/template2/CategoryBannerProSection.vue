<template>
  <section v-if="!allFeaturedCategories">
    <WebsiteSkeletonTemplate2Banner />
  </section>
  <section
    class="banner"
    v-else
  >
     <Component :is="`WebsiteCategorySmartBannerLayouts${currentlyActiveCategorySmartBannerLayout}`" :allFeaturedCategories="allFeaturedCategories" />

  </section>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
export default {
  data() {
    return {
    currentlyActiveCategorySmartBannerLayout:"Layout1",
    };
  },
   async fetch(){
      if(!this.allFeaturedCategories){
        await this.fetchFeaturedCategories();
      }
    },
    mounted()
    {
            this.allDefaultSettings.theme_settings.forEach(element => {
          if (element.name == "smart_category_banner") {
            this.currentlyActiveCategorySmartBannerLayout = element.value
        }
      });
    },
    methods:{
      ...mapActions({
        fetchFeaturedCategories: 'Web/General/fetchFeaturedCategories'
      })
    },
    computed:{
      ...mapGetters({
        allFeaturedCategories: 'Web/General/allFeaturedCategories',
        allDefaultSettings:'allDefaultSettings',

      }),
    },
};
</script>

<style></style>
