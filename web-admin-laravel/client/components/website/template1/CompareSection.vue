<template>
  <section class="compare-section">
        <div class="container">
          <div v-if="this.products.length == 0" class="text-center py-5" >
            <WebsiteTemplate1CompareEmpty />
          </div>

          <div class="row mb-0 mb-sm-4">
            <div class="col d-flex justify-content-end">
              <a class="btn btn-primary reset-btn text-white text-uppercase fw-bold" v-if="products.length > 0 " @click="reset_all()" href="#">{{$t('web.customer.compare.reset_all')}}</a>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-4 col-md-6  mt-4 mt-lg-0">
                <div class="compare-item rounded">
                    <Template1CompareProductCard @removeItem='()=> this.$emit("removeItem",0)' :product="this.products[0]" v-if="this.products[0]"/>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mt-4 mt-lg-0">
                <div class="compare-item rounded">
                    <Template1CompareProductCard @removeItem='()=> this.$emit("removeItem",1)' :product="this.products[1]" v-if="this.products[1]" />
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mt-4 mt-lg-0">
                <div class="compare-item rounded">
                    <Template1CompareProductCard @removeItem='()=> this.$emit("removeItem",2)' :product="this.products[2]" v-if="this.products[2]" />
                </div>
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
      }
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

