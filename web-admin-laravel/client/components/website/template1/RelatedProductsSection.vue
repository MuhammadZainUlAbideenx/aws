<template>
   <section class="col-12 featured-items">
     <div class="container">
        <div class="row">
          <div class="col-12">
            <h2 class="section-heading">{{$t('web.customer.compare.related_products.label')}}</h2>
            <p class="section-subheading">{{$t('web.customer.compare.related_products.description')}}</p>
              <VueSlickCarousel :key="key" v-bind="settings">
                <div v-for="product in products"  :key="product.id">
                  <Template1FeaturedProductCard  modal_id="product_detail_quickview"  :product="product" />
                </div>
              </VueSlickCarousel>
          </div>
        </div>
     </div>
    </section>
</template>

<script>

export default {
  props:['products'],
  data(){
    return{
      key:1,
      product_detail:'',
      settings:{
        "slidesToShow": 4,
        "responsive": [
          {
            "breakpoint": 992,
            "settings": {
              "slidesToShow": 3
            }
          },
          {
            "breakpoint": 768,
            "settings": {
              "slidesToShow": 2
            }
          },
          {
            "breakpoint": 576,
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

    },

    methods:{
      changeProductDetail(product){
        this.product_detail = product
      }
    },
    computed:{
    },
    watch:{
      products(){
        this.key += 1
      }
    }
  }
</script>

<style>

</style>
