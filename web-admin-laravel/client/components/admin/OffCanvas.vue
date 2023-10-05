<template>

  <div id="kt_color_panel"
       v-bind:class="{ offcanvas_on: panelisActive }"
       class="offcanvas shadow offcanvas-right kt-color-panel py-5">
        <div
         class="btn btn-sm btn-icon btn-primary btn-hover-primary"
         id="kt_color_panel_close"
         @click="closeCanvas">
          <svg
            width="30px"
            height="30px"
            viewBox="0 0 16 16"
            class="bi bi-x"
            fill="currentColor"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              fill-rule="evenodd"
              d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"
            />
          </svg>
        </div>
    <div class="offcanvas-header pt-5 px-5">
      <h4 class="font-size-h4 font-weight-bold m-0">{{ this.$t("offcanvas.Theme_config") }}</h4>

    </div>
    <hr />
    <div class="offcanvas-content">
      <!-- Theme options starts -->
      <div id="customizer-theme-layout" class="customizer-theme-layout">

          <div class="d-flex justify-content-between align-items-center px-5">
              <h5 class="mt-1">{{ this.$t("offcanvas.Dark_mode") }}</h5>
              <div class="form-switch">
                <input class="form-check-input"
                       @change="changeMode()"
                       :checked="dark ? 'checked' : ''"
                       type="checkbox"
                       id="flexSwitchCheckChecked2" />
        </div>
          </div>


        <hr />
         <div class="d-flex justify-content-between align-items-center px-5">
              <h5 class="mt-1">{{ this.$t("offcanvas.RTL_layout") }}</h5>
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
      <div id="customizer-theme-colors" class="customizer-theme-colors px-5">
        <h5>{{ this.$t("offcanvas.Theme_colors") }}</h5>
        <ul class="list-inline unstyled-list d-flex">
          <li class="color-box me-2">
            <div @click="colorpick($event, 'blue-theme')"
                 :class="{ highlight: theme == 'blue-theme' }"
                 id="color-theme-blue"
                 class="d-flex rounded w-20px h-20px shadow"
                 style="background: rgb(2,0,36);
                background: linear-gradient(125deg, #0560c5 50%,  #e88d07 50%);"></div>
          </li>
          <li class="color-box me-2">
            <div @click="colorpick($event, 'red-theme')"
                 :class="{ highlight: theme == 'red-theme' }"
                 id="color-theme-red"
                 class="d-flex rounded w-20px h-20px shadow"
                 style="background: rgb(2,0,36);
                background: linear-gradient(125deg, red 50%,  #29bab6 50%);"></div>
          </li>
          <li class="color-box me-2">
            <div @click="colorpick($event, 'green-theme')"
                 :class="{ highlight: theme == 'green-theme' }"
                 id="color-theme-green"
                 class="d-flex rounded w-20px h-20px shadow"
                  style="background: rgb(2,0,36);
                background: linear-gradient(125deg, green 50%,  yellow 50%);"></div>
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
