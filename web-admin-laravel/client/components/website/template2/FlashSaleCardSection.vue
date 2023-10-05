<template>
  <section class="featured-items" v-if="$fetchState.pending">
    <WebsiteSkeletonTemplate2FlashSaleCard />
  </section>
  <section class="featured-items" v-else-if="$fetchState.error">
    <div class="row">
      <div class="col-md-12">
        <AdminLoader />
      </div>
    </div>
  </section>
  <section
    class="flash-sale-products bg-light"
    v-else-if="allFlashSaleProducts && allFlashSaleProducts.length > 0"
  >
    <div class="container mt-100 mb-100">
      <div class="row justify-content-center">
        <div class="col-xl-4 col-md-6 p-md-20 mb-3 mb-xl-0 fisrt-flash" v-if="allFlashSaleProducts[0]">
           <Template2FlashSaleProductCard :product="allFlashSaleProducts[0]" />
        </div>
        <div class="col-xl-4 col-md-12 middle-section mb-3 mb-lg-0 d-flex justify-content-between flex-column">
            <div v-if="allFlashSaleProducts[1]" class="mb-3 mb-md-0 col-xl-12 col-md-6 p-md-20  pb-xl-2">
                <Template2FlashSaleProductCard  :product="allFlashSaleProducts[1]" />
            </div>
             <div v-if="allFlashSaleProducts[2]" class="mb-0 col-xl-12 col-md-6 p-md-20  pt-xl-2">
                <Template2FlashSaleProductCard  :product="allFlashSaleProducts[2]" />
            </div>
        </div>
        <div class="col-xl-4 col-md-6 p-md-20 mb-3 mb-xl-0" v-if="allFlashSaleProducts[3]">
             <Template2FlashSaleProductCard :product="allFlashSaleProducts[3]" />
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
    if (!this.allFlashSaleProducts) {
      await this.fetchFlashSaleProducts();
    }
  },
  methods: {
    ...mapActions({
      fetchFlashSaleProducts: "Web/General/fetchFlashSaleProducts",
    }),
  },
  computed: {
    ...mapGetters({
      allFlashSaleProducts: "Web/General/allFlashSaleProducts",
    }),
  },
  data() {
    return {
      key: 1,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 1,
        autoplay: true,
        responsive: [
          {
            breakpoint: 1024,
            settings: {
              slidesToShow: 2,
              arrows: false,
            },
          },
          {
            breakpoint: 480,
            settings: {
              slidesToShow: 1,
              slidesToScroll: 1,
            },
          },
        ],
      },
    };
  },
  watch: {
    allFlashSaleProducts() {
      this.key += 1;
    },
  },
};
</script>

<style>
</style>
