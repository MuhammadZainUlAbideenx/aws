<template>
        <section  v-if="!parallax_banner">
             <WebsiteSkeletonTemplate1Parallex/>
        </section>
  <section class="parallex-section" :style="{ 'background-image': `url(/backend${parallax_banner.image.original_media_path})`}" v-else>
      <div class="container">
        <div class="row align-items-center">
          <div class="col">
            <div class="parallex-content">
              <h2 class="text-uppercase">{{parallax_banner.name}}</h2>
              <div v-html="parallax_banner.description">
              </div>
              <nuxt-link v-if="parallax_banner.url_type == 1 && parallax_banner.button_text" :to="parallax_banner.website_url" class="btn btn-warning text-uppercase text-dark rounded px-3 fw-bold">
              {{parallax_banner.button_text}}
                </nuxt-link>
              <a v-if="parallax_banner.url_type == 2 && parallax_banner.button_text" :href="parallax_banner.website_url" class="btn btn-warning text-uppercase text-dark rounded px-3 fw-bold">
                {{parallax_banner.button_text}}
              </a>
            </div>
          </div>
        </div>
      </div>
  </section>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  data(){
    return {

    }
  },
  computed: {
    ...mapGetters({
      allGenericData: 'Web/General/allGenericData'
    }),
    parallax_banner(){
      if(this.allGenericData  && this.allGenericData.parallax_banners.length > 0){
        return this.allGenericData.parallax_banners[0]
      }
      return null
    }
  }
}
</script>

<style>

</style>
