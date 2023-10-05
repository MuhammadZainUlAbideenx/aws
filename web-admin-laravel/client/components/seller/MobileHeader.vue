<template>

  <div id="tc_header_mobile" class="header-mobile align-items-center header-mobile-fixed bg-gradient">
    <!--begin::Logo-->
    <a href="index.html" class="brand-logo ">
          <img style="height: 40px" alt="Logo" src="~/assets/images/fav.png" />
          <span class="brand-text fw-bold">
            Invictus Product
            </span>
        </a>
    <!--end::Logo-->
    <!--begin::Toolbar-->
    <div class="d-flex align-items-center">
      <button class="btn p-0 ml-2"
              id="tc_header_mobile_topbar_toggle"
              v-on:click="openSubMenu($event)">
            <span class="svg-icon svg-icon-xl">
              <svg
                width="20px"
                height="20px"
                viewBox="0 0 16 16"
                class="bi bi-person-fill"
                fill="currentColor"
                xmlns="http://www.w3.org/2000/svg">
                <path
                  fill-rule="evenodd"
                  d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"
                />
              </svg>
            </span>
          </button>
      <button class="btn p-0 "
              id="tc_aside_mobile_toggle"
              v-on:click="opensidebar($event)">
            <svg
              width="20px"
              height="20px"
              viewBox="0 0 16 16"
              class="bi bi-justify-right"
              fill="currentColor"
              xmlns="http://www.w3.org/2000/svg">
              <path
                fill-rule="evenodd"
                d="M6 12.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm-4-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5z"
              />
            </svg>
          </button>
    </div>
    <!--end::Toolbar-->
  </div>

</template>

<script>

  export default {
    components: {},
    created() {},
    data() {
      return {}
    },

    computed: {
      availableLocales() {
        return this.$i18n.locales.filter(i => i.code !== this.$i18n.locale)
      }
    },

    methods: {
      openSubMenu(event) {
        this.$emit('show-navbar')
      },
      opensidebar(event) {
        this.$emit('show-sidebar')
      }
    }
  }

</script>

<style>
</style>
