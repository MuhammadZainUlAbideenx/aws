<template>
  <nuxt />
</template>

<script>
import { mapState, mapGetters, mapActions } from "vuex";

export default {
  head: {},
  data() {
    return {
      fullPage: true,
      maintenance: false,
      themeData: {
        shownav: false,
        panelisActive: false,
        showsidebar: false,
        dark: false,
        rtl: false,
        theme: "blue-theme",
      },
    };
  },

  mounted() {
    const default_language = this.$store.state.default_settings.language;
    if (!this.$cookies.get("language") && default_language) {
      const check = this.$i18n.locales.find(
        (i) => i.code == default_language.code
      );
      if (check) {
        this.$cookies.set("language", default_language.code);
        this.$cookies.set("i18n_redirected", default_language.code);
        this.$i18n.setLocale(default_language.code);
      }
    }

    if (localStorage.getItem("wesiteThemeData")) {
      this.themeData = JSON.parse(localStorage.getItem("wesiteThemeData"));
      const body = document.querySelector("body");
      if (this.themeData.rtl) {
        body.classList.add("rtl");
      } else {
        body.classList.remove("rtl");
      }
    }
  },

  async fetch() {
    if (this.allDefaultSettings.general_settings.environment == "maintenance") {
      this.maintenance = true;
    } else {
      if (!this.allGenericData) {
        await this.fetchGenericData();
      }
    }
  },
  methods: {
    ...mapActions({
      fetchGenericData: "Web/General/fetchGenericData",
    }),
  },
  computed: {
    ...mapGetters({
      allGenericData: "Web/General/allGenericData",
      allDefaultSettings: "allDefaultSettings",
    }),
  },
  watch: {
    themeData: {
      deep: true,
      handler() {
        localStorage.setItem("wesiteThemeData", JSON.stringify(this.themeData));
        const body = document.querySelector("body");

        if (this.themeData.dark) {
          body.classList.add("dark");
          body.classList.remove("web");
        } else {
          body.classList.remove("dark");
          body.classList.add("web");
        }

        body.classList.remove("red-theme");
        body.classList.remove("green-theme");
        body.classList.remove("blue-theme");
        body.classList.add(this.themeData.theme ? this.themeData.theme : "");
      },
    },
  },
};
</script>
<style lang="scss">
@import "~/assets/sass/template2.scss";
</style>
