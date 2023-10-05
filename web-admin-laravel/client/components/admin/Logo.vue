<template>
  <div class="brand-image" v-if="allSettings.general_settings && allSettings.general_settings.logo">
       <img
              style="height: 50px"
              alt="Logo"
              :src="`/backend${allSettings.general_settings.logo_dark.original_media_path}`" v-if="Dark"
          />
      <img
              style="height: 50px"
              alt="Logo"
              :src="`/backend${allSettings.general_settings.logo.original_media_path}`" v-else
          />
          <!-- <img :src="`/backend${allSettings.general_settings.logo_dark.original_media_path}`"  class="brand-icon img-fluid"
            style="height: 50px"
            alt="Logo" v-if="Dark">
            <img :src="`/backend${allSettings.general_settings.logo.original_media_path}`"  class="brand-icon img-fluid"
            style="height: 50px"
            alt="Logo" v-else> -->

      </div>
</template>

<script>
import { mapGetters } from "vuex";

export default {
    props:['Dark'],
     data() {
        return {
        };
    },
  computed: {
    ...mapGetters({
      allSettings: 'allDefaultSettings',
    }),
  },
  mounted(){
  },

}
</script>
