<template>
  <nuxt />
</template>

<script>
export default {
  auth:false,
  data(){
    return {
    }
  },
  computed: {

  },
  mounted(){

     if (this.$auth.loggedIn) {
       if(this.$gates.hasRole('vendor')){
         this.$router.replace(this.localePath('/seller/dashboard'))
       }
   }
  },
  methods:{

  },
  created() {

   },
}
</script>
<style lang="scss">
  @import "~/assets/sass/app.scss";
  </style>
