<template>
  <section v-if="$fetchState.pending">
    <WebsiteSkeletonTemplate1Vendors />
  </section>
  <section class="featured-items" v-else-if="$fetchState.error">
    <div class="row">
      <div class="col-md-12">
        <AdminLoader />
      </div>
    </div>
  </section>
  <div v-else-if="allFeaturedVendors && allFeaturedVendors.length > 0">
    <WebsiteGlobalComponentsFeaturedVendor
      v-for="vendor in allFeaturedVendors"
      :key="vendor.id"
      :vendor="vendor"
    />
  </div>
  <div v-else></div>
</template>
<script>
import { mapGetters, mapActions } from "vuex";
export default {
  async fetch() {
    if (!this.allFeaturedVendors) {
      await this.fetchFeaturedVendors();
    }
  },
  methods: {
    ...mapActions({
      fetchFeaturedVendors: "Web/General/fetchFeaturedVendors",
    }),
  },
  computed: {
    ...mapGetters({
      allFeaturedVendors: "Web/General/allFeaturedVendors",
    }),
  },
  data() {
    return {};
  },
};
</script>

<style>
</style>
