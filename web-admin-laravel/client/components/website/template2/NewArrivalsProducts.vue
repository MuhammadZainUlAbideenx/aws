<template>
  <section v-if="$fetchState.pending">
    <WebsiteSkeletonTemplate2NewArrival />
  </section>
  <section class="featured-items" v-else-if="$fetchState.error">
    <div class="row">
      <div class="col-md-12">
        <AdminLoader />
      </div>
    </div>
  </section>
  <section
    class="new-arrivals"
    v-else-if="
      allLatestProducts && allLatestProducts.length > 0
    "
  >
    <div class="container">
      <div class="row">
        <div class="col-12 text-center">
          <h2 class="section-heading mb-1 mt-0 text-capitalize">
            {{$t('web.home.new_arrival_products.heading.text1')}}
          </h2>
          <span class="w-100 d-block mb-4 text-end px-3">

            <nuxt-link to="/new-arrival-products" class="text-primary">{{$t('web.home.new_arrival_products.show_all')}}</nuxt-link>
            </span>
        </div>
      </div>
      <div class="categories-section">
        <div class="row">
          <div class="col-lg-3 col-md-6 mb-4 mb-xl-0" v-for="product in allLatestProducts.slice(0,4)" :key="product.id">
            <!-- <Template2NewArrivalProductCard class="" :product="product"/> -->
            <Component :is="`WebsiteProductCardLayouts${currentlyActiveProductCardLayout}`" :product="product" />
          </div>
        </div>
      </div>
    </div>
  </section>
  <div v-else></div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";

export default {
  async fetch() {
    if (!this.allLatestProducts) {
      await this.fetchLatestProducts();
    }
     this.allDefaultSettings.theme_settings.forEach(element => {
        if (element.name == "product_card_web") {
            this.currentlyActiveProductCardLayout = element.value
        }
      });
  },
  methods: {
    ...mapActions({
     fetchLatestProducts: "Web/General/fetchLatestProducts",
    }),
  },
  computed: {
    ...mapGetters({
       allLatestProducts: "Web/General/allLatestProducts",
        allDefaultSettings:'allDefaultSettings'

    }),
  },
  data() {
    return {
      currentlyActiveProductCardLayout:"Layout2",

    };
  },
};
</script>


<style></style>
