<template>
        <section  v-if="!parallax_banner">
             <WebsiteSkeletonTemplate1Parallex/>
        </section>
  <section v-else class="parallex-section" :style="{ 'background-image': `url(/backend${parallax_banner.image.original_media_path})`}" >
      <div class="container">
        <div class="row align-items-center">
          <div class="col">
            <div class="parallex-content">
                <h5 class="text-uppercase fw-bold">{{parallax_banner.name}}</h5>
              <!-- <h2 class="text-uppercase fw-bold">Summer Sale Collections</h2> -->
              <div  class="mb-5">
                  <p v-html="parallax_banner.description"></p>
              </div>
              <div class="counter d-flex justify-content-center mb-5">
                    <div class="py-3 px-lg-4 px-3 me-2"><p class="mb-0">00</p><label for="">days</label></div>
                    <div class="py-3 px-lg-4 px-3 me-2"><p class="mb-0">00</p><label for="">hrs</label></div>
                    <div class="py-3 px-lg-4 px-3 me-2"><p class="mb-0">00</p><label for="">mins</label></div>
                    <div class="py-3 px-lg-4 px-3 me-2"><p class="mb-0">00</p><label for="">secs</label></div>
              </div>
              <nuxt-link v-if="parallax_banner.url_type == 1 && parallax_banner.button_text" :to="parallax_banner.website_url" class="btn btn-white text-uppercase px-3">
              {{parallax_banner.button_text}}
                </nuxt-link>
              <a v-if="parallax_banner.url_type == 2 && parallax_banner.button_text" :href="parallax_banner.website_url" class="btn btn-white text-uppercase px-3">
                {{parallax_banner.button_text}}
              </a>
                <!-- <nuxt-link to="/shop"  class="btn btn-transparent text-white text-uppercase px-3 ms-3">
              Read More
                </nuxt-link> -->

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

