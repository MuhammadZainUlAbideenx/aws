<template>
  <section class="vender-profle-page" v-if="$fetchState.pending">
    <Component :is="`WebsiteSkeleton${currentlyActiveTemplate}VendorDetail`" />
  </section>
  <section class="vender-profle-page m-0 vender-custom" v-else-if="detail">
    <WebsiteGlobalComponentsBreadCrumb :page="`store_detail`" />
    <WebsiteGlobalComponentsFeaturedVendorProfile :vendor="detail.vendor" @updateFollowCount="updateFollowCount" />
    <!-- <WebsiteGlobalComponentsSubNavSection /> -->
    <Component
      :is="`Website${currentlyActiveTemplate}VendorNewArrivalsSection`"
      :allNewArrivalProducts="detail.new_arrival_products"
    />
    <Component
      :is="`Website${currentlyActiveTemplate}VendorTrendingItems`"
      :allVendorsTrendingProducts="detail.trending_products"
    />
    <WebsiteGlobalComponentsVandersPromoSection />
    <Component
      :is="`Website${currentlyActiveTemplate}VendorUpComingItems`"
      :allVendorsUpcomingProducts="detail.upcoming_products"
    />
    <!-- <WebsiteTemplate1NewsLetterSection /> -->
  </section>
  <section v-else>
    <Component :is="`Website${currentlyActiveTemplate}Error404`" />
  </section>
</template>

<script>
import { mapGetters, mapActions } from "vuex";

export default {
  auth: false,
  data() {
    return {
      currentlyActiveTemplate: "",
      key: 1,
      detail: "",
      seo: {},
    };
  },
  created() {
    this.currentlyActiveTemplate =
      this.allSettings.general_settings.currently_active_theme;
  },
  async fetch() {
    const { data } = await this.$webService.vendorDetail(
      this.$route.params.slug
    );
    if (data) {
      this.detail = data;
    }
  },
  methods:{
    updateFollowCount(follow_status)
    {
        if (follow_status) {
            this.detail.vendor.total_follower= this.detail.vendor.total_follower+1
        }
        else
        {
           this.detail.vendor.total_follower = this.detail.vendor.total_follower-1
        }
    }
  },
  computed: {
    ...mapGetters({
      allSettings: "allDefaultSettings",
    }),
  },
};
</script>

<style>
</style>
