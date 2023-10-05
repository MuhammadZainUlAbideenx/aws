<template>

  <!--begin::Body-->
  <section v-if="$fetchState.pending" id="tc_body"
           :v-model="this.themeData.theme"
           class="page-background loader">
           <AdminLoader />
  </section>

  <section v-else id="tc_body"
           :v-model="this.themeData.theme"

           class="page-background header-fixed header-mobile-fixed subheader-enabled aside-enabled aside-fixed  admin-panel">
    <!--begin::Header Mobile-->
    <AdminMobileHeader @show-navbar="themeData.shownav = !themeData.shownav"
                  @show-sidebar="themeData.showsidebar = !themeData.showsidebar" />
    <!--end::Header Mobile-->
    <!--begin::Main-->
    <div class="d-flex flex-column flex-root">
      <!--begin::Page-->
      <div class="d-flex flex-row flex-column-fluid page">
        <!--begin::Aside-->
        <AdminSidebar :class="{ 'aside_on aside-overlay': themeData.showsidebar }" :themeData="themeData" />
        <div class="aside-overlay"></div>
        <!--end::Aside-->
        <!--begin::Wrapper-->
        <div class="d-flex flex-column flex-row-fluid wrapper position-relative" id="tc_wrapper">
          <!--begin::Header-->
          <AdminNavbar  @change_direction="changeThemeDirection" :class="{ 'hidemobilenavbar slide-in-top': themeData.shownav }" />
          <!--end::Header-->
          <!--begin::Content-->

          <nuxt v-if="!$slots.default" />
          <slot />

          <!--end::Content-->

          <!--begin::Footer-->
          <!-- <Footer /> -->
          <!--end::Footer-->
        </div>
        <!--end::Wrapper-->
      </div>
      <!--end::Page-->
    </div>
    <!--end::Main-->

    <ul class="sticky-toolbar nav flex-column bg-primary">
      <li class="nav-item"
          id="kt_demo_panel_toggle"
          data-toggle="tooltip"
          title=""
          data-placement="right"
          data-original-title="Check out more demos"
          @click="openCanvas">
        <a class="btn btn-sm btn-icon text-white" href="#">
                <svg
                  width="20px"
                  height="20px"
                  viewBox="0 0 16 16"
                  class="bi bi-gear fa-spin"
                  fill="currentColor"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    fill-rule="evenodd"
                    d="M8.837 1.626c-.246-.835-1.428-.835-1.674 0l-.094.319A1.873 1.873 0 0 1 4.377 3.06l-.292-.16c-.764-.415-1.6.42-1.184 1.185l.159.292a1.873 1.873 0 0 1-1.115 2.692l-.319.094c-.835.246-.835 1.428 0 1.674l.319.094a1.873 1.873 0 0 1 1.115 2.693l-.16.291c-.415.764.42 1.6 1.185 1.184l.292-.159a1.873 1.873 0 0 1 2.692 1.116l.094.318c.246.835 1.428.835 1.674 0l.094-.319a1.873 1.873 0 0 1 2.693-1.115l.291.16c.764.415 1.6-.42 1.184-1.185l-.159-.291a1.873 1.873 0 0 1 1.116-2.693l.318-.094c.835-.246.835-1.428 0-1.674l-.319-.094a1.873 1.873 0 0 1-1.115-2.692l.16-.292c.415-.764-.42-1.6-1.185-1.184l-.291.159A1.873 1.873 0 0 1 8.93 1.945l-.094-.319zm-2.633-.283c.527-1.79 3.065-1.79 3.592 0l.094.319a.873.873 0 0 0 1.255.52l.292-.16c1.64-.892 3.434.901 2.54 2.541l-.159.292a.873.873 0 0 0 .52 1.255l.319.094c1.79.527 1.79 3.065 0 3.592l-.319.094a.873.873 0 0 0-.52 1.255l.16.292c.893 1.64-.902 3.434-2.541 2.54l-.292-.159a.873.873 0 0 0-1.255.52l-.094.319c-.527 1.79-3.065 1.79-3.592 0l-.094-.319a.873.873 0 0 0-1.255-.52l-.292.16c-1.64.893-3.433-.902-2.54-2.541l.159-.292a.873.873 0 0 0-.52-1.255l-.319-.094c-1.79-.527-1.79-3.065 0-3.592l.319-.094a.873.873 0 0 0 .52-1.255l-.16-.292c-.892-1.64.902-3.433 2.541-2.54l.292.159a.873.873 0 0 0 1.255-.52l.094-.319z"
                  />
                  <path
                    fill-rule="evenodd"
                    d="M8 5.754a2.246 2.246 0 1 0 0 4.492 2.246 2.246 0 0 0 0-4.492zM4.754 8a3.246 3.246 0 1 1 6.492 0 3.246 3.246 0 0 1-6.492 0z"
                  />
                </svg>
              </a>
      </li>
    </ul>

    <AdminOffCanvas @changeDirection="changeDirection"
               @changeMode="changeMode"
               :theme="themeData.theme"
               :dark="themeData.dark"
               @change-color="changeTheme"
               :panelisActive="themeData.panelisActive"
               :rtl="themeData.rtl"
               @close-canvas="themeData.panelisActive = !themeData.panelisActive" />
  </section>
  <!--end::Body-->

</template>

<script>
  import feather from 'feather-icons'
  import { mapGetters, mapActions } from 'vuex'

  export default {
    head: {
      link: [
        {
          rel: 'stylesheet',
          href: 'https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css'
        },
        {
          rel: 'stylesheet',
          href: 'https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700'
        }
      ],
      script: []
    },
    data() {
      return {
        countUpdated:1,
        barsStatus: false,
        themeData: {
          shownav: false,
          panelisActive: false,
          showsidebar: false,
          dark: false,
          rtl: false,
          theme: 'blue-theme'
        }
      }
    },
    computed: {},
    mounted() {
      this.$watch('$route', this.closeSidebar, { immediate: true })
      if (localStorage.getItem('adminThemeData')) {
        this.themeData = JSON.parse(localStorage.getItem('adminThemeData'))
        const body = document.querySelector('body')
        if (this.themeData.rtl) {
          body.classList.add('rtl')
        } else {
          body.classList.remove('rtl')
        }
      }
    },
    updated(){
      if(this.countUpdated <= 2){
        feather.replace()
        this.countUpdated = this.countUpdated +1
      }
    },
    methods: {
      ...mapActions({
        fetchActiveLanguages: 'General/fetchActiveLanguages',
        fetchActiveSettings: 'General/fetchActiveSettings',
      }),
      changeThemeDirection(dir){
        if(dir == 'rtl'){
          this.themeData.rtl = true
        }
        else{
          this.themeData.rtl = false
        }
      },
      closeSidebar() {
        if (window.matchMedia('only screen and (max-width: 992px)').matches) {
          this.themeData.showsidebar = false
          this.themeData.shownav = false
        }
      },
      openCanvas() {
        this.themeData.panelisActive = !this.themeData.panelisActive
      },
      changeDirection() {
        this.themeData.rtl = !this.themeData.rtl
        const body = document.querySelector('body')
        if (this.themeData.rtl) {
          body.classList.add('rtl')
        } else {
          body.classList.remove('rtl')
        }
      },

      changeTheme(event, color) {
        this.themeData.theme = color
      },
      changeMode() {
        this.themeData.dark = !this.themeData.dark
      }
    },
    async fetch() {
      await this.fetchActiveLanguages();
      await this.fetchActiveSettings();
    },
    fetchOnServer:false,
    watch: {
      $route(to, from) {
        this.closeSidebar()
      },
      themeData: {
        deep: true,
        handler() {
          localStorage.setItem('adminThemeData', JSON.stringify(this.themeData))
            const body = document.querySelector('body')

          if(this.themeData.dark){
             body.classList.add('dark')
             body.classList.remove('admin')
          }else{
             body.classList.remove('dark')
             body.classList.add('admin')
          }

              body.classList.remove('red-theme')
              body.classList.remove('green-theme')
              body.classList.remove('blue-theme')
              body.classList.add(this.themeData.theme ? this.themeData.theme:'')

        }
      }
    }
  }

</script>
<style lang="scss">
  @import "~/assets/sass/app.scss";
</style>
