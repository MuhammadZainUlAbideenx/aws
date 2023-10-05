<template>
  <Component :is="`Website${currentlyActiveTemplate}Layout`" />
</template>

<script>
import { mapGetters } from "vuex";
export default {
     data() {
    return {
      currentlyActiveTemplate: "",
        }
    },
    created()
    {
         this.currentlyActiveTemplate = this.allSettings.general_settings.currently_active_theme
    },
     computed: {
    ...mapGetters({
      allSettings: 'allDefaultSettings'
    })
    },
}
</script>
