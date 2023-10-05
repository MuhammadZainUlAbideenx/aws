<template>
  <section class="top-brands skeletion-effect" v-if="!allGenericData">
    <WebsiteSkeletonTemplate1TopBrands />
  </section>
  <section
    class="top-brands"
    v-else-if="allGenericData.brands && allGenericData.brands.length > 0"
  >
    <div class="container">
      <div class="row">
        <div class="col">
          <h2 class="section-heading">
            {{ this.$t("web.home.brands.heading.text1")
            }}<span>{{ this.$t("web.home.brands.heading.text2") }}</span>
          </h2>
          <p class="section-subheading">
            {{ this.$t("web.home.brands.description") }}
          </p>
        </div>
      </div>
      <div class="row brands">
        <div class="col">
          <VueSlickCarousel v-bind="settings">
            <div v-for="brand in allGenericData.brands" :key="brand.id">
              <Template1BrandCard :brand="brand" />
            </div>
          </VueSlickCarousel>
        </div>
      </div>
    </div>
  </section>
  <section v-else></section>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  data() {
    return {
      settings: {
        infinite: true,
        slidesToShow: 5,
        rows: 2,
        slidesPerRow: 1,
        responsive: [
          {
            breakpoint: 991,
            settings: {
              slidesToShow: 4,
            },
          },
          {
            breakpoint: 600,
            settings: {
              slidesToShow: 2,
            },
          },
          {
            breakpoint: 480,
            settings: {
              slidesToShow: 2,
              slidesToScroll: 1,
            },
          },
        ],
      },
    };
  },
  computed: {
    ...mapGetters({
      allGenericData: "Web/General/allGenericData",
    }),
  },
};
</script>

<style>
</style>
