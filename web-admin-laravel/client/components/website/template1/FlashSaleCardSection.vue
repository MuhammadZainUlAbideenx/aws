<template>

  <section class="featured-items" v-if="$fetchState.pending">
    <WebsiteSkeletonTemplate1FlashSaleCard/>
  </section>
  <section class="featured-items" v-else-if="$fetchState.error">
    <div class="row">
      <div class="col-md-12">
        <AdminLoader />
      </div>
    </div>
  </section>
  <section class="flash-sale-products" v-else-if="allFlashSaleProducts && allFlashSaleProducts.length > 0">
        <div class="container">
            <div class="row">
                <div class="col">
                    <h2 class="section-heading">{{ this.$t("web.home.flash_sale.heading.text1") }}<span>{{ this.$t("web.home.flash_sale.heading.text2") }}</span></h2>
                    <p class="section-subheading">{{ this.$t("web.home.flash_sale.description") }}</p>
                    <VueSlickCarousel :key="key" v-bind="settings">
                        <div v-for="product in allFlashSaleProducts"  :key="product.id">
                            <Template1FlashSaleProductCard :product="product" />
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
      if(!this.allFlashSaleProducts){
        await this.fetchFlashSaleProducts()
      }
    },
    methods:{
      ...mapActions({
        fetchFlashSaleProducts: 'Web/General/fetchFlashSaleProducts'
      })
    },
    computed:{
      ...mapGetters({
        allFlashSaleProducts: 'Web/General/allFlashSaleProducts'
      }),
    },
    data(){
      return{
        key:1,
        settings:{
          "slidesToShow": 2,
          "slidesToScroll": 1,
          "autoplay": true,
          "responsive": [
            {
              "breakpoint": 1024,
              "settings": {
                "slidesToShow": 2,
                "arrows": false
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
  watch:{
    allFlashSaleProducts(){
      this.key +=1
    }
  }

}
</script>

<style>

</style>
