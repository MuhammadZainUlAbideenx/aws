<template>
  <div class="" v-if="maintenance">
      <AdminMaintenanceMode/>
  </div>
  <div v-else class="layout main-site">

     <!-- Loading Components Based on Active -->
     <Component :is="`WebsiteHeaderLayouts${currentlyActiveHeaderLayout}`" :themeData="themeData" @change_direction="changeThemeDirection" />

      <nuxt v-if="!$slots.default" />
        <slot />

    <!-- <WebsiteFooterLayoutsLayout2 /> -->
     <Component :is="`WebsiteFooterLayouts${currentlyActiveFooterLayout}`"  />
    <ul class="sticky-toolbar nav flex-column">
      <li class="nav-item"
          id="kt_demo_panel_toggle"
          data-toggle="tooltip"
          title=""
          data-placement="right"
          data-original-title="Check out more demos"
          @click="openCanvas">
        <a class="btn btn-sm btn-icon text-white" href="#" onclick="return false;">
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

<!-- move to top -->
<div class="scrolltop-wrap">
    <a href="#" role="button" aria-label="Scroll to top">
        <svg height="48" viewBox="0 0 48 48" width="48" style="height:48px" xmlns="http://www.w3.org/2000/svg">
            <path id="scrolltop-bg" d="M0 0h48v48h-48z"></path>
            <path id="scrolltop-arrow" d="M14.83 30.83l9.17-9.17 9.17 9.17 2.83-2.83-12-12-12 12z"></path>
        </svg>
    </a>
  </div>
<!-- move to top end-->

    <WebsiteTemplate2OffCanvas @changeDirection="changeDirection"
      @changeMode="changeMode"
      :theme="themeData.theme"
      :dark="themeData.dark"
      @change-color="changeTheme"
      :panelisActive="themeData.panelisActive"
      :rtl="themeData.rtl"
      @close-canvas="themeData.panelisActive = !themeData.panelisActive" />
      <WebsiteTemplate2ModalProductDetail modal_id="product_detail_quickview"/>


  </div>

</template>

<script>
import feather from 'feather-icons'
import { mapState, mapGetters, mapActions } from "vuex";
import Loading from 'vue-loading-overlay';
 // Import stylesheet
 import 'vue-loading-overlay/dist/vue-loading.css';

export default {
  head:{

  },
  data(){
    return {
      fullPage: true,
      maintenance:false,
      themeData: {
          shownav: false,
          panelisActive: false,
          showsidebar: false,
          dark: false,
          rtl: false,
          theme: 'blue-theme'
        },
         currentlyActiveHeaderLayout:"Layout2",
        currentlyActiveFooterLayout:"Layout2"
    }
  },
  components: {
    Loading
  },
  mounted(){
    const default_language = this.$store.state.default_settings.language
    if(!this.$cookies.get('language') && default_language){
      const check = this.$i18n.locales.find((i) => i.code == default_language.code)
      if(check){
        this.$cookies.set('language',default_language.code)
        this.$cookies.set('i18n_redirected',default_language.code)
        this.$i18n.setLocale(default_language.code)
      }
    }
    feather.replace();
          if (localStorage.getItem('wesiteThemeData')) {
        this.themeData = JSON.parse(localStorage.getItem('wesiteThemeData'))
        const body = document.querySelector('body')
        if (this.themeData.rtl) {
          body.classList.add('rtl')
        } else {
          body.classList.remove('rtl')
        }
      }
      this.allDefaultSettings.theme_settings.forEach(element => {
        if (element.name == "header_layout_web") {
            this.currentlyActiveHeaderLayout = element.value
        }
          if (element.name == "footer_layout_web") {
            this.currentlyActiveFooterLayout = element.value
        }
      });
  },
 created(){

  },
  async fetch(){
    if(this.allDefaultSettings.general_settings.environment == 'maintenance'){
      this.maintenance = true
    }
    else{
      if(!this.allCartItems){
        this.fetchCartItems()
      }
      if(this.$auth.loggedIn && this.$gates.hasRole('customer')  && !this.allWishlistItems){
        await this.fetchWishlistItems()
      }
      if(!this.allGenericData){
        await this.fetchGenericData()
      }
    }
  },
  methods:{
  ...mapActions({
    'fetchGenericData' : 'Web/General/fetchGenericData',
    'fetchWishlistItems': 'Web/Wishlist/fetchWishlistItems',
    'fetchCartItems': 'Web/Cart/fetchCartItems'

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
    },
  },
  computed: {
    ...mapGetters({
      allGenericData: 'Web/General/allGenericData',
      allWishlistItems: 'Web/Wishlist/allWishlistItems',
      allDefaultSettings:'allDefaultSettings',
      allCartItems: 'Web/Cart/allCartItems',

    }),
  },
   created() {
   },
   watch: {
      $route(to, from) {
        this.closeSidebar()
      },
      themeData: {
        deep: true,
        handler() {
          localStorage.setItem('wesiteThemeData', JSON.stringify(this.themeData))
            const body = document.querySelector('body')

          if(this.themeData.dark){
             body.classList.add('dark')
             body.classList.remove('web')
          }else{
             body.classList.remove('dark')
             body.classList.add('web')
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
  @import "~/assets/sass/template2.scss";
</style>
