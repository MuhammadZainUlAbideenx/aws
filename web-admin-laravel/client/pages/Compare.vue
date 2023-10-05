<template>
<div v-if="$fetchState.pending || loading">
     <WebsiteGlobalComponentsBreadCrumb :page="`compare`"/>
      <Component :is="`WebsiteSkeleton${currentlyActiveTemplate}ComparePage`" />
    </div>
  <section v-else class="compare-page m-0">
    <WebsiteGlobalComponentsBreadCrumb :page="`compare`" />
     <Component :is="`Website${currentlyActiveTemplate}CompareSection`" :products="allCompareProducts && allCompareProducts.products ? allCompareProducts.products:[]" @removeItem="removeSingleItem" @reset='reset()' />
         <Component :is="`Website${currentlyActiveTemplate}RelatedProductsSection`" :products="allCompareProducts && allCompareProducts.related_products ? allCompareProducts.related_products:[]" v-if="allCompareProducts && allCompareProducts.related_products &&  allCompareProducts.related_products.length > 0" />
    <WebsiteTemplate1NewsLetterSection />
  </section>
</template>

<script>
import { mapGetters,mapActions } from "vuex";
export default {
  auth:false,
  data() {
    return{
         currentlyActiveTemplate: "",
      key:1,
      detail:'',
      seo:{},
      loading:true
    }
  },
   created()
  {
    this.currentlyActiveTemplate = this.allSettings.general_settings.currently_active_theme
  },
  head(){
    return this.seo
  },
  async fetch(){
  },
  async mounted(){
    this.loading = true
    var compare_products = JSON.parse(localStorage.getItem('compare_products'));
    if(!compare_products)
    {
        compare_products = []
        this.loading = false

    }
    if(compare_products.length > 0)
    {
      if(!this.allCompareProducts){
        await this.fetchCompareProducts({compare_ids:compare_products}).then(() => {
        }).catch()
      }
      this.loading = false
    }
  },
  methods:{
    ...mapActions({
        fetchCompareProducts: 'Web/General/fetchCompareProducts'

    }),
      async reset(){
            localStorage.removeItem('compare_products');
            this.$store.commit('Web/General/updateCompareProducts', null)
            this.$toast.success(this.$t('products_removed_from_compare_list'));
      },
      async removeSingleItem(i)
      {
          var product = this.allCompareProducts.products[i];
          var compare_products =   JSON.parse(localStorage.getItem('compare_products'));
          var filtered = compare_products.filter((val) => {return val != product.id})
          localStorage.setItem('compare_products',JSON.stringify(filtered))

          this.$toast.success(this.$t('products_removed_from_compare_list'));
          if(filtered.length > 0)
        {
            this.fetchCompareProducts({compare_ids:filtered})
        }
        else{
          this.$store.commit('Web/General/updateCompareProducts', null)
        }
      }
  },
  computed: {
    ...mapGetters({
      allCompareProducts: 'Web/General/allCompareProducts',
       allSettings: 'allDefaultSettings'
    }),
  }
};
</script>

<style>
</style>
