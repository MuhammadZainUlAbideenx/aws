<template>
  <Component :is="`Website${currentlyActiveTemplate}SetGuestLayout`" />
</template>

<script>
import { mapGetters } from "vuex";

export default {
  auth: false,
  data() {
    return {
      currentlyActiveTemplate: "",
    };
  },
  computed: {},
  mounted() {
    if (this.$auth.loggedIn) {
      if (this.$auth.$storage.getUniversal("redirect")) {
        this.$router.replace(this.$auth.$storage.getUniversal("redirect"));
        this.$auth.$storage.removeUniversal("redirect");
      } else if (!this.$gates.hasRole("customer")) {
      } else if (this.$gates.hasRole("customer")) {
        if (this.$gates.hasRole("customer")) {
          this.$router.replace(this.localePath("/customer/profile"));
        }
      } else {
        if (
          this.$gates.hasPermission("admin") &&
          this.$auth.strategy.options.name == "admin"
        ) {
          this.$router.replace(this.localePath("/admin/dashboard"));
        } else if (
          this.$gates.hasRole("vendor") &&
          this.$auth.strategy.options.name == "vendor"
        ) {
          this.$router.replace(this.localePath("/vendor/dashboard"));
        }
      }
    }
  },
  methods: {},
  created() {
    this.currentlyActiveTemplate =
      this.allSettings.general_settings.currently_active_theme;
  },
  computed: {
    ...mapGetters({
      allSettings: "allDefaultSettings",
    }),
  },
};
</script>
