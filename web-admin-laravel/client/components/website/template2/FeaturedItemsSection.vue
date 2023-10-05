<template>
         <section v-if="$fetchState.pending">
          <WebsiteSkeletonTemplate2FeaturedItems/>
        </section>

  <section class="featured-items" v-else-if="$fetchState.error">
    <div class="row">
      <div class="col-md-12">
        <AdminLoader />
      </div>
    </div>
  </section>
  <section class="featured-items feature-section" v-else-if="allFeaturedProducts && allFeaturedProducts.length > 0">
      <div class="container">
        <div class="row">
          <div class="col">
            <h2 class="section-heading mb-30 mt-0">{{ this.$t("web.home.featured_items.heading.text1") }}
                <!-- <span>{{ this.$t("web.home.featured_items.heading.text2") }}</span> -->
            </h2>
            <p class="mb-0 section-subheading">{{ this.$t("web.home.featured_items.description") }}</p>
            <div class="catergories mt-50">
                <VueSlickCarousel :key="key" v-bind="settings">
                    <div v-if="allFeaturedProducts" v-for="product in allFeaturedProducts"  :key="product.id">
                        <!-- <Template2NewArrivalProductCard   modal_id="product_detail_quickview" :product="product" /> -->
                      <Component :is="`WebsiteProductCardLayouts${currentlyActiveProductCardLayout}`"  modal_id="product_detail_quickview" :product="product" />

                    </div>
                </VueSlickCarousel>
            </div>
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
  data(){
    return{
      currentlyActiveProductCardLayout:"Layout5",
      key:1,
      product_detail:'',
      settings:{
        "slidesToShow": 4,
        centerPadding: '15px',
        "responsive": [
          {
            "breakpoint": 1024,
            "settings": {
              "arrows": false
            }
          },
          {
            "breakpoint": 991,
            "settings": {
              "slidesToShow": 3
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
      },
      active_category:''
    }
  },
    async fetch(){
      if(!this.allFeaturedProducts){
        await this.fetchFeaturedProducts()
      }
        this.allDefaultSettings.theme_settings.forEach(element => {
        if (element.name == "product_card_web") {
            this.currentlyActiveProductCardLayout = element.value
        }
      });
    },

    methods:{
      ...mapActions({
        fetchFeaturedProducts: 'Web/General/fetchFeaturedProducts'
      }),
      changeActiveCategory(cat){
        this.active_category = cat
        this.key += 1
      },
      changeProductDetail(product){
        this.product_detail = product
      }
    },
    computed:{
      ...mapGetters({
        allFeaturedProducts: 'Web/General/allFeaturedProducts',
        allDefaultSettings:'allDefaultSettings'

      }),
    },
    watch:{
      allFeaturedProducts(){
        this.key+=1
      }
    }
  }
</script>

<style>

</style>
