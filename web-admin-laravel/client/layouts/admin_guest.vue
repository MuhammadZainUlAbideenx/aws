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
       if(this.$gates.hasRole('admin') || this.$gates.hasRole('super_admin')){
         this.$router.replace(this.localePath('/admin/dashboard'))
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
