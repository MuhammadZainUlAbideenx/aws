<template>
         <section v-if="$fetchState.pending">
          <WebsiteSkeletonTemplate1FeaturedItems/>
        </section>

  <section class="featured-items" v-else-if="$fetchState.error">
    <div class="row">
      <div class="col-md-12">
        <AdminLoader />
      </div>
    </div>
  </section>
  <section class="featured-items" v-else-if="categoriesWhichHaveProducts && categoriesWhichHaveProducts.length > 0">
      <div class="container">
        <div class="row">
          <div class="col">
            <h2 class="section-heading">{{ this.$t("web.home.featured_items.heading.text1") }}<span>{{ this.$t("web.home.featured_items.heading.text2") }}</span></h2>
            <p class="section-subheading">{{ this.$t("web.home.featured_items.description") }}</p>
            <div class="catergories">
              <ul class="nav nav-tabs border-0 d-block mb-4" id="myTab" role="tablist">
                <li class="nav-item" role="presentation" v-for="(category,index) in categoriesWhichHaveProducts"  :key="category.id">
                  <button class="nav-link" v-bind:class="{'active': active_category == category.slug ? true:false }" @click="changeActiveCategory(category.slug)"  type="button" role="tab">{{category.slug}}</button>
                </li>
              </ul>
              <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" role="tabpanel" aria-labelledby="home-tab">
                  <VueSlickCarousel class="slider-center" :key="key" v-bind="settings">
                    <div v-if="activeCategory" v-for="product in activeCategory.products"  :key="product.id">
                      <!-- <Template1FeaturedProductCard   modal_id="product_detail_quickview" :product="product" /> -->
            <Component :is="`WebsiteProductCardLayouts${currentlyActiveProductCardLayout}`" modal_id="product_detail_quickview" :product="product" />

                    </div>
                  </VueSlickCarousel>
                </div>
              </div>
            </div>
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
  data(){
    return{
      key:1,
      currentlyActiveProductCardLayout:"Layout1",
      product_detail:'',
      settings:{
        "slidesToShow": 4,
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
      if(!this.allFeaturedProductsCategoryWise){
        await this.fetchFeaturedProductsCategoryWise()
      }
        this.allDefaultSettings.theme_settings.forEach(element => {
        if (element.name == "product_card_web") {
            this.currentlyActiveProductCardLayout = element.value
        }
      });
    },

    methods:{
      ...mapActions({
        fetchFeaturedProductsCategoryWise: 'Web/General/fetchFeaturedProductsCategoryWise'
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
        allFeaturedProductsCategoryWise: 'Web/General/allFeaturedProductsCategoryWise',
        allDefaultSettings:'allDefaultSettings'
      }),
      categoriesWhichHaveProducts(){
        if(this.allFeaturedProductsCategoryWise){
          return this.allFeaturedProductsCategoryWise.filter((category) => category.products.length > 0)
        }
        return []
      },
      activeCategory(){
        if(!this.active_category){
          if(this.categoriesWhichHaveProducts){
            this.active_category = this.categoriesWhichHaveProducts[0].slug
            return this.categoriesWhichHaveProducts.find((category) => category.slug == this.active_category)
          }
          else{
            return []
          }
        }
        else{
          return this.categoriesWhichHaveProducts.find((category) => category.slug == this.active_category)
        }
      }
    },
    watch:{
      allFeaturedProductsCategoryWise(){
        this.key+=1
      }
    }
  }
</script>

<style>

</style>
