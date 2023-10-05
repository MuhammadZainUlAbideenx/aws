<template>

  <div id="kt_color_panel"
       v-bind:class="{ offcanvas_on: panelisActive }"
       class="offcanvas offcanvas-right kt-color-panel">
    <div class="offcanvas-header d-flex flex-row align-items-center justify-content-between py-2 px-4">
      <h5 class="fw-bold m-0">{{ this.$t("offcanvas.Theme_config") }}</h5>
      <a href="#" onclick="return false;"
         class="close-icon btn-close"
         id="kt_color_panel_close"
         @click="closeCanvas">
        </a>
    </div>
    <hr />
    <div class="offcanvas-content">
      <!-- Theme options starts -->
      <div id="customizer-theme-layout" class="customizer-theme-layout">
        <div class="theme-dark py-2 px-4 d-flex justify-content-between align-items-center">
          <h5 class="mb-0">{{ this.$t("offcanvas.Dark_mode") }}</h5>
          <div class="form-switch">
            <input class="form-check-input"
                    @change="changeMode()"
                    :checked="dark ? 'checked' : ''"
                    type="checkbox"
                    id="flexSwitchCheckChecked2" />
          </div>
        </div>
        <hr />
        <div class="theme-rtl py-2 px-4 d-flex justify-content-between align-items-center">
          <h5 class="mb-0">{{ this.$t("offcanvas.RTL_layout") }}</h5>
          <div class="form-switch">
            <input class="form-check-input"
                  @change="changeDirection()"
                  :checked="rtl ? 'checked' : ''"
                  type="checkbox"
                  id="flexSwitchCheckChecked" />
          </div>
        </div>
        <hr />
      </div>

      <!-- Theme options starts -->
      <div id="customizer-theme-colors" class="customizer-theme-colors py-2 px-4">
        <h5 class="mb-3">{{ this.$t("offcanvas.Theme_colors") }}</h5>
        <ul class="list-inline unstyled-list d-flex flex-row align-items-center mb-0">
          <li class="color-box">
            <div @click="colorpick($event, 'blue-theme')"
                 :class="{ highlight: theme == 'blue-theme' }"
                 id="color-theme-blue"
                 class="d-flex flex-row flex-rows"
                 style="background-color: blue"></div>
          </li>
          <li class="color-box">
            <div @click="colorpick($event, 'red-theme')"
                 :class="{ highlight: theme == 'red-theme' }"
                 id="color-theme-red"
                 class="d-flex flex-row flex-row"
                 style="background-color: red"></div>
          </li>
          <li class="color-box">
            <div @click="colorpick($event, 'green-theme')"
                 :class="{ highlight: theme == 'green-theme' }"
                 id="color-theme-green"
                 class="d-flex flex-row flex-row"
                 style="background-color: green"></div>
          </li>
        </ul>
      </div>
    </div>
  </div>

</template>

<script>

  export default {
    props: ['panelisActive', 'rtl', 'dark', 'theme'],
    data() {
      return {}
    },
    methods: {
      closeCanvas() {
        this.$emit('close-canvas')
      },
      colorpick(event, color) {
        this.$emit('change-color', event, color)
      },
      changeDirection() {
        this.$emit('changeDirection')
      },
      changeMode() {
        this.$emit('changeMode')
      }
    }
  }

</script>

<style>
</style>
