<template>
        <a href="#" v-if="allSettings.general_settings.name_or_logo == 1" >
        <img :src="`/backend${allSettings.general_settings.logo_dark.original_media_path}`" class="" alt="..." v-if="this.themeData && this.themeData.dark">
        <img :src="`/backend${allSettings.general_settings.logo.original_media_path}`" class="" alt="..." v-else>
    </a>
    <a href="#"  v-else >
    <h2>{{allSettings.general_settings.web_name}}</h2>
    </a>
</template>

<script>
import { mapGetters,mapActions } from "vuex";

export default {

  data() {
    return {
      themeData: '',
    };
  },
  mounted(){
    this.themeData = JSON.parse(localStorage.getItem('websiteThemeData'))
  },
 computed: {
    ...mapGetters({
      allSettings: 'allDefaultSettings'
    })
    },
}
</script>

<style>

</style>
