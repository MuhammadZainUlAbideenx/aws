<template>
        <section class="static-card skeletion-effect" v-if="!allGenericData">
            <div class="container">
                <div class="row">
                    <div class="col-sm-4 col-md-6 col-lg-4"><div class="skeletion-animation text"></div></div>
                    <div class="col-sm-4 col-md-6 col-lg-4"><div class="skeletion-animation"></div></div>
                    <div class="col-sm-4 col-md-6 col-lg-4 d-md-none d-lg-block"><div class="skeletion-animation litext"></div></div>
                </div>
            </div>
        </section>
  <section class="static-card"  v-else-if="allGenericData && allGenericData != null && allGenericData.static_banners && allGenericData.static_banners.home_page && allGenericData.static_banners.home_page.length > 0">
            <div class="container">
         <div class="row">
              <div class="col-sm-4 col-sm-6 col-lg-4" v-for="static_banner in allGenericData.static_banners.home_page.slice(0,3)"  :key="static_banner.id">
                <div class="img-wrap">
                  <nuxt-link v-if="static_banner.url_type == 1" :to="static_banner.website_url">
                    <img v-if="static_banner.image" :src="`/backend${static_banner.image.original_media_path}`" class="w-sm-100 img-fluid">
                  </nuxt-link>
                  <a v-else :href="static_banner.website_url" >
                    <img v-if="static_banner.image" :src="`/backend${static_banner.image.original_media_path}`" class="w-sm-100 img-fluid">
                  </a>
                </div>
              </div>
          </div>
            </div>
  </section>
    <section v-else>

  </section>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  computed: {
    ...mapGetters({
      allGenericData: 'Web/General/allGenericData'
    }),
  }
}
</script>

<style>

</style>
