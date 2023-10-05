<template>
        <section v-if="!allGenericData">
              <WebsiteSkeletonTemplate1Testimonial/>
        </section>
  <section v-else-if="allGenericData.reviews && allGenericData.reviews.length > 0" class="testimonials bg-secondary">
    <div class="container">
      <div class="row">
        <div class="col">
          <h2 class="section-heading">{{ this.$t("web.home.customers.heading.text1") }}<span>{{ this.$t("web.home.customers.heading.text2") }}</span></h2>
          <p class="section-subheading">{{ this.$t("web.home.customers.description") }}</p>
        </div>
      </div>

      <div class="row">
        <div class="col">
          <VueSlickCarousel v-bind="settings">
            <div v-for="review in allGenericData.reviews"  :key="review.id">
              <Template1CustomerReviewCard :review="review" />
            </div>
          </VueSlickCarousel>
        </div>
      </div>
    </div>
  </section>
    <section v-else>

  </section>
</template>

<script>
import { mapGetters } from "vuex";

export default {
  data(){
    return{
      settings:{
        // "infinite": true,
        "centerMode": true,
        "centerPadding": '0px',
        "slidesToShow": 3,
        "speed": 500,
        "responsive": [
          {
            "breakpoint": 991,
            "settings": {
              "slidesToShow": 3,
              "centerPadding": "0%"
            }
          },
          {
            "breakpoint": 767,
            "settings": {
              "slidesToShow": 1,
              "centerPadding": "10%"
            }
          }
        ]
      }
    }
  },
  computed: {
    ...mapGetters({
      allGenericData: 'Web/General/allGenericData'
    }),
  }
}
</script>

<style>

</style>
