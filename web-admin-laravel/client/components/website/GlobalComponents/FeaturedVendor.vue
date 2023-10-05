<template>
  <section class="mart-sectioin new-arrivals">
      <div class="container">
          <div class="row">
              <div class="col-12">
                  <div class="mart-bg-wrap">
                      <img v-if="cover_image" class="mart-bg" :src="`/backend${cover_image.original_media_path}`":alt="cover_image.alt_text">
                      <img v-else class="mart-bg" src="~assets/images/mart-section-bg.png" alt="">
                      <div  class="mart-logo-wrap img-wrap">
                        <img v-if="store_logo && store_logo.thumbnails && store_logo.thumbnails.medium" class="img-fluid" :src="`/backend${store_logo.thumbnails.medium.thumbnail}`":alt="store_logo.alt_text" >
                        <img v-else src="~assets/images/mart-section-logo.png" class="img-fluid" alt="">
                      </div>
                  </div>
              </div>
              <div class="col-12">
                  <nuxt-link :to="`/store/${vendor.store.slug}`">
                      <h2 class="section-heading">{{vendor.store ? vendor.store.name:''}}</h2>
                  </nuxt-link>
                  <p class="section-subheading" v-html="vendor.store ? vendor.store.description:''"></p>
                  <VueSlickCarousel v-bind="settings">
                      <div v-for="product in vendor.products"  :key="product.id">
                      <Template1MartProductsCard :product="product" />
                      </div>
                  </VueSlickCarousel>
              </div>
          </div>
      </div>
  </section>
</template>
<style media="screen">

</style>
<script type="text/javascript">
  export default {
    props:['vendor'],
    data(){
        return{
        settings:{
            "infinite": true,
            "slidesToShow": 4,
            "speed": 500,
            "rows": 2,
            "slidesPerRow": 1,
            "responsive": [
            {
                "breakpoint": 1200,
                "settings": {
                "slidesToShow": 2
                }
            },
            {
                "breakpoint": 767,
                "settings": {
                "slidesToShow": 2
                }
            },
            {
                "breakpoint": 480,
                "settings": {
                "slidesToShow": 1,
                "slidesToScroll": 1
                }
            }
            ]
        }
        }
    },
  methods:{
  },
  computed:{
    cover_image(){
      if(this.vendor && this.vendor.store && this.vendor.store.cover_image){
        return this.vendor.store.cover_image
      }
      else{
        return null
      }
    },
    store_logo(){
      if(this.vendor && this.vendor.store && this.vendor.store.store_logo){
        return this.vendor.store.store_logo
      }
      else{
        return null
      }
    }

  }
}
</script>
