<template>
  <section v-if="$fetchState.pending">
          <WebsiteSkeletonTemplate1NewArrival/>
  </section>
  <section class="featured-items" v-else-if="$fetchState.error">
    <div class="row">
      <div class="col-md-12">
        <AdminLoader />
      </div>
    </div>
  </section>
  <section class="new-arrivals" v-else-if="categoriesWhichHaveProducts && categoriesWhichHaveProducts.length > 0">
      <div class="container">
        <div class="row">
            <div class="col">
                <h2 class="section-heading">{{ this.$t("web.home.new_arrival_products.heading.text1") }}<span>{{ this.$t("web.home.new_arrival_products.heading.text2") }}</span></h2>
                <p class="section-subheading">{{ this.$t("web.home.new_arrival_products.description") }}</p>
            </div>
        </div>
        <div class="row categories-section" v-for="category in categoriesWhichHaveProducts"  :key="category.id">
            <div class="col-lg-3 col-sm-6">
                <div class="new-arrival-static-banner h-100 rounded text-center p-4 pt-0 text-dark text-uppercase">
                    <div class="img-wrap">
                        <img v-if="category.icon" :src="`/backend${category.icon.original_media_path}`" class="w-sm-100 img-fluid">
                        <img v-else src="~/assets/images/phone-img.png" alt="">
                    </div>
                    <h3 class="fw-bold mt-3">{{category.name}}</h3>
                    <h5 class="fw-bold">{{category.products.length}} {{$t("products")}}</h5>
                    <nuxt-link :to="{path:'/shop',query:{category:category.slug}}" class="btn btn-light fw-bold rounded mt-2 px-3">
                      {{ $t("view_all_items") }}
                    </nuxt-link>
                </div>
            </div>
            <div class="col-lg-9 col-sm-6 d-flex flex-row flex-column justify-content-between">
                <VueSlickCarousel v-bind="settings">
                  <div v-for="product in category.products"  :key="product.id">
                    <Template1NewArrivalProductCard :product="product" class="mb-3"/>
                    </div>
                </VueSlickCarousel>
            </div>
        </div>
      </div>
  </section>
    <section v-else>

  </section>
</template>

<script>
import { mapGetters,mapActions } from "vuex";

export default {
  async fetch(){
    if(!this.allNewArrivalProducts){
      await this.fetchNewArrivalProducts()
    }
  },
  methods:{
    ...mapActions({
      fetchNewArrivalProducts: 'Web/General/fetchNewArrivalProducts'
    })
  },
  computed:{
    ...mapGetters({
      allNewArrivalProducts: 'Web/General/allNewArrivalProducts'
    }),
    categoriesWhichHaveProducts(){
      if(this.allNewArrivalProducts){
        return this.allNewArrivalProducts.filter((category) => category.products.length > 0)
      }
      return []
    }
  },
    data(){
    return{
      settings:{
        "infinite": true,
        "slidesToShow": 3,
        "rows": 2,
        "slidesPerRow": 1,
        "responsive": [
          {
            "breakpoint": 1199,
            "settings": {
              "slidesToShow": 2
            }
          },
          {
            "breakpoint": 991,
            "settings": {
              "slidesToShow": 1
            }
          },
          {
            "breakpoint": 575,
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

}
</script>

<style>

</style>
