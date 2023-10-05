<template>
  <div class="brand-image">
       <img
              style="height: 50px"
              alt="Logo"
              src="~/assets/images/nictus-logo-white.png" v-if="Dark"
          />
      <img
              style="height: 50px"
              alt="Logo"
              src="~/assets/images/nictus-logo.png" v-else
          />

          <!-- <img :src="`/backend${llSettings.general_settings.logo_dark.original_media_path}`"  class="brand-icon img-fluid"
            style="height: 50px"
            alt="Logo" v-if="Dark">
            <img :src="`/backend${llSettings.general_settings.logo.original_media_path}`"  class="brand-icon img-fluid"
            style="height: 50px"
            alt="Logo" v-else> -->

      </div>
</template>

<script>
export default {
    props:['Dark']
}
</script>
