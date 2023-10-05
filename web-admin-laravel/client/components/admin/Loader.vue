<template>
  <div class="text-center" v-if="allSettings.general_settings && allSettings.general_settings.loader">
    <img :src="`/backend${allSettings.general_settings.loader.original_media_path}`" alt="" width="135px" height="135px" />
  </div>
  <div class="text-center" v-else>

    <img src="~/assets/images/loader.gif" alt="" width="135px" height="135px">
  </div>
</template>
<script>
import { mapGetters, mapActions } from "vuex";
  export default {
    computed: {
    ...mapGetters({
      allSettings: "allDefaultSettings",
    }),
}
  }
</script>
