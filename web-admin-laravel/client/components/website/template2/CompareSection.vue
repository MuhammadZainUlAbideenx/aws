<template>
  <section class="compare-section mt-100">
        <div class="container">
          <div v-if="this.products.length == 0" class="text-center py-5" >
            <WebsiteTemplate2CompareEmpty />
          </div>

          <div class="row mb-0 mb-sm-4 mx-0 mb-50">
            <div class="col d-flex justify-content-end p-3 bg-secondary rounded">
              <a class="btn btn-primary reset-btn text-white text-uppercase fw-bold py-2 px-3" v-if="products.length > 0 " @click="reset_all()" href="#">Reset All</a>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-12 mb-4 mb-lg-0">
                <Template2CompareProductCard @removeItem='()=> this.$emit("removeItem",0)' :product="this.products[0]" v-if="this.products[0]"/>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12 mb-4 mb-lg-0">
                <Template2CompareProductCard @removeItem='()=> this.$emit("removeItem",1)' :product="this.products[1]" v-if="this.products[1]" />
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12">
                <Template2CompareProductCard @removeItem='()=> this.$emit("removeItem",2)' :product="this.products[2]" v-if="this.products[2]" />
            </div>
          </div>
      </div>
  </section>
</template>

<script>
import { mapGetters,mapActions } from "vuex";
export default {
  props:['products'],
   data(){
      return{
      }
    },
    created()
    {
    },
    methods:{
        reset_all(){
            this.$emit('reset');
        }
    },
}
</script>

<style>

</style>
