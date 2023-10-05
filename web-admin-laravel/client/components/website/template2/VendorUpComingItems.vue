<template>

          <section class="upcoming-items skeletion-effect"  v-if="$fetchState.pending">
              <WebsiteSkeletonTemplate1UpComing/>
        </section>
  <section class="featured-items" v-else-if="$fetchState.error">
    <div class="row">
      <div class="col-md-12">
        <AdminLoader />
      </div>
    </div>
  </section>
  <section class="upcoming-items" v-else-if="allVendorsUpcomingProducts && allVendorsUpcomingProducts.length > 0">
      <div class="container">
        <div class="row">
            <div class="col">
                <h2 class="section-heading">{{ this.$t("web.home.upcoming_items.heading.text1") }}<span>{{ this.$t("web.home.upcoming_items.heading.text2") }}</span></h2>
                <p class="section-subheading">{{ this.$t("web.home.upcoming_items.description") }}</p>
                <VueSlickCarousel v-bind="settings">
                    <div v-for="product in allVendorsUpcomingProducts"  :key="product.id">
                      <Template2UpComingItemsProductCard :product="product" />
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
    props: ['allVendorsUpcomingProducts'],
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
                "breakpoint": 1024,
                "settings": {
                "slidesToShow": 4,
                "arrows": false
                }
            },
            {
                "breakpoint": 600,
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
