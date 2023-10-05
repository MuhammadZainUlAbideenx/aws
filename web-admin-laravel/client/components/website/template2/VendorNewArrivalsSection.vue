<template>

    <section class="new-arrivals skeletion-effect" v-if="$fetchState.pending">
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
            <div class="col-sm-3">
                <div class="new-arrival-static-banner h-100 rounded text-center p-4 text-white text-uppercase">
                    <div class="img-wrap">
                        <img v-if="category.icon" :src="`/backend${category.icon.original_media_path}`" class="w-sm-100 img-fluid">
                        <img v-else src="~/assets/images/phone-img.png" alt="">
                    </div>
                    <h3 class="fw-bold">{{category.name}}</h3>
                    <h5 class="fw-bold">{{category.products.length}} {{$t("products")}}</h5>
                    <button class="btn btn-light fw-bold rounded mt-2 px-3">
                        {{$t("view_all_items")}}
                    </button>
                </div>
            </div>
            <div class="col-sm-9 d-flex flex-row flex-column justify-content-between">
                <VueSlickCarousel v-bind="settings">
                  <div v-for="product in category.products"  :key="product.id">
                    <Template2NewArrivalProductCard :product="product" />
                    </div>
                </VueSlickCarousel>
            </div>
        </div>
      </div>
  </section>
    <div v-else>

  </div>
</template>

<script>
import { mapGetters,mapActions } from "vuex";

export default {
    props: ['allNewArrivalProducts'],
  async fetch(){

  },
  methods:{

  },
  computed:{

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
            "breakpoint": 1024,
            "settings": {
              "slidesToShow": 2,
              "arrows": false
            }
          },
          {
            "breakpoint": 600,
            "settings": {
              "slidesToShow": 1
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
