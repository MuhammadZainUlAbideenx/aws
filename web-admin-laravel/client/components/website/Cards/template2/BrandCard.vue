<template>
  <div class="brand-card d-flex justify-content-center align-items-center">
     <img v-if="brand.image" :src="`/backend${brand.image.original_media_path}`" class="img-fluid" alt="brand">
     <img v-else  class="img-fluid" src="~/assets/images/logo-1.jpg" alt="brand">
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
