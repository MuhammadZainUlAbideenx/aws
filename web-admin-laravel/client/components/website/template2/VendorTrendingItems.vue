<template>

          <section class="upcoming-items skeletion-effect"  v-if="$fetchState.pending">
             <WebsiteSkeletonTemplate1Upcoming/>
        </section>
  <section class="featured-items" v-else-if="$fetchState.error">
    <div class="row">
      <div class="col-md-12">
        <AdminLoader />
      </div>
    </div>
  </section>
  <section class="upcoming-items feature-section" v-else-if="allVendorsTrendingProducts && allVendorsTrendingProducts.length > 0">
      <div class="container">
        <div class="row">
            <div class="col">
                <h2 class="section-heading">{{ this.$t("web.home.trending_items.heading.text1") }}<span>{{ this.$t("web.home.trending_items.heading.text2") }}</span></h2>
                <p class="section-subheading">{{ this.$t("web.home.trending_items.description") }}</p>
                <VueSlickCarousel v-bind="settings">
                    <div v-for="product in allVendorsTrendingProducts"  :key="product.id">
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
    props: ['allVendorsTrendingProducts'],

  async fetch(){

  },
  methods:{

  },
  computed:{

  },
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
                "breakpoint": 991,
                "settings": {
                "slidesToShow": 3,
                "arrows": false
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
    }

}
</script>

<style>

</style>
