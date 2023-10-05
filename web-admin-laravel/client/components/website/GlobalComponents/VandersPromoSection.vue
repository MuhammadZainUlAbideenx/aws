<template>
    <section class="vander-promo-section skeletion-effect" v-if="!allGenericData">
        <div class="container">
            <div class="row">
                <div class="col-12">
                  <div class="banner skeletion-animation light">
                   </div>
            </div>
        </div>
      </div>
    </section>
    <section class="vander-promo-section" v-else-if="allGenericData && allGenericData != null && allGenericData.static_banners && allGenericData.static_banners.shop_page && allGenericData.static_banners.shop_page.length > 0">
        <div class="container">
            <div class="row">
                <div class="col-12">
                  <nuxt-link v-if="shop_banner.url_type == 1" :to="shop_banner.website_url" class="img-wrap overflow-hidden rounded d-flex" >
                    <img v-if="shop_banner.image" :src="`/backend${shop_banner.image.original_media_path}`"  class="w-100 img-fluid">
                  </nuxt-link>
                    <a v-else :href="shop_banner.website_url" class="img-wrap overflow-hidden rounded d-flex">
                      <img v-if="shop_banner.image" :src="`/backend${shop_banner.image.original_media_path}`"  class="w-100 img-fluid">
                    </a>
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
    shop_banner(){
      return this.allGenericData.static_banners.shop_page[0]
    }
  }
}
</script>

<style>

</style>
