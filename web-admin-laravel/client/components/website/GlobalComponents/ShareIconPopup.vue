<template>
  <i onclick="return false;" v-tooltip="{ content: $t('share') }" class="icon-cont share-icon">
    <fa :icon="['fas', 'share']" />
    <div class="share-popup">
    <ul>
      <li><fa :icon="['fas', 'envelope']" /></li>
      <li><fa :icon="['fab', 'facebook-f']" /></li>
      <li><fa :icon="['fab', 'twitter']" /></li>
      <li><fa :icon="['fab', 'linkedin-in']" /></li>
      <li><fa :icon="['fab', 'youtube']" /></li>
    </ul>
  </div>
  </i>
</template>

<script>
import { mapGetters,mapActions } from "vuex";
export default {
}
</script>

<style>

</style>
