<template>
  <div class=" card brand-card d-flex justify-content-center align-items-center overflow-hidden">
      <nuxt-link v-if="brand.image" :to="'/shop?brand='+brand.id" class="w-100"><img  :src="`/backend${brand.image.original_media_path}`" class="img-fluid" alt="..."></nuxt-link>
      <nuxt-link v-else :to="'/shop?brand='+brand.id"><img   class="img-fluid" src="~/assets/images/logo-1.jpg" alt="..."></nuxt-link>
  </div>
</template>
<style media="screen">

</style>
<script type="text/javascript">
  export default {
    props:['brand'],
    data(){
      return{
      }
    },
  methods:{
  },
  computed:{
  }
}
</script>
