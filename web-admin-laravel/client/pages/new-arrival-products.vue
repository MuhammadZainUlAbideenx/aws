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
          <h2 class="section-heading mb-4 mt-0 text-capitalize">
           {{$t('new_arrival_products')}}
          </h2>
        </div>
      </div>
      <div class="categories-section">
        <div class="row">
          <div class="mb-3 review-gird">
              <WebsiteGlobalComponentsGrigListView
                :grid_class="grid_class"
                @changeGridClass="changeGridClass"
              />
          </div>
          <div class="mb-4 col-md-6" :class="grid_class" v-for="product in allLatestProducts" :key="product.id">
            <Template2NewArrivalProductCard   :product="product"/>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section v-else></section>
</template>

<script>
import { mapGetters, mapActions } from "vuex";

export default {
    auth: false,
  async fetch() {
    if (!this.allLatestProducts) {
      await this.fetchLatestProducts();
    }
  },
  methods: {
    ...mapActions({
     fetchLatestProducts: "Web/General/fetchLatestProducts",
    }),
       changeGridClass(grid_class) {
      this.grid_class = grid_class;
    },
  },
  computed: {
    ...mapGetters({
       allLatestProducts: "Web/General/allLatestProducts",
    }),
  },
  data() {
    return {
          grid_class: "col-lg-3 last-col-3",
    };
  },
};
</script>


<style></style>

