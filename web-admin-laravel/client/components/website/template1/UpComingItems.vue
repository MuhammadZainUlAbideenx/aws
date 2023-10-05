<template>

          <section v-if="$fetchState.pending">
            <WebsiteSkeletonTemplate1UpComing/>
        </section>
  <section class="featured-items" v-else-if="$fetchState.error">
    <div class="row">
      <div class="col-md-12">
        <AdminLoader />
      </div>
    </div>
  </section>
  <section class="upcoming-items" v-else-if="allUpcomingProducts && allUpcomingProducts.length > 0">
      <div class="container">
        <div class="row">
            <div class="col">
                <h2 class="section-heading">{{ this.$t("web.home.upcoming_items.heading.text1") }}<span>{{ this.$t("web.home.upcoming_items.heading.text2") }}</span></h2>
                <p class="section-subheading">{{ this.$t("web.home.upcoming_items.description") }}</p>
                <VueSlickCarousel :key="key" v-bind="settings">
                    <div v-for="product in allUpcomingProducts"  :key="product.id">
                      <Template1UpComingItemsProductCard :product="product" />
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
    if(!this.allUpcomingProducts){
      await this.fetchUpcomingProducts()
    }
  },
  methods:{
    ...mapActions({
      fetchUpcomingProducts: 'Web/General/fetchUpcomingProducts'
    })
  },
  computed:{
    ...mapGetters({
      allUpcomingProducts: 'Web/General/allUpcomingProducts'
    }),
  },
  watch:{
    allUpcomingProducts(){
      this.key+=1
    }
  },
    data(){
        return{
          key:1,
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
