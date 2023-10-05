<template>
  <section v-if="!allGenericData">
    <WebsiteSkeletonTemplate2Banner />
  </section>
  <section
    class="banner"
    v-else-if="
      allGenericData && allGenericData.static_banners.home_page.length > 0
    "
  >
    <div class="container">
      <div class="row">
        <div
          class="col-lg-6"
          v-for="banner in allGenericData.static_banners.home_page"
          :key="banner.id"
        >
          <div class="position-relative text-white banner-detail">
            <img
              :src="`backend${banner.image.original_media_path}`"
              alt="banner"
              class="img-fluid w-100"
            />
            <div
              class="
              banner-alignment
              ps-md-3 ps-2
              pe-md-3 pe-2
              "
            >
              <!-- <h3 class="mb-1">Constructions</h3> -->
              <h2 class="fw-bold mb-1">{{banner.name}}</h2>

              <nuxt-link
                class="btn btn-black text-white rounded-0 py-1"
                v-if="banner.url_type == 1"
                :to="banner.website_url"
              >
                {{$t('web.customer.orders.filter.view_details')}}
              </nuxt-link>
              <a
                v-else
                class="btn btn-black text-white rounded-0 py-1"
                :href="banner.website_url"
              >
                {{$t('web.customer.orders.filter.view_details')}}
              </a>
            </div>
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
  fetch() {},
  data() {
    return {
      settings: {
        slidesToShow: 2,
        slidesToScroll: 1,
        autoplay: true,
        arrows: false,
        responsive: [
          {
            breakpoint: 1024,
            settings: {
              slidesToShow: 2,
            },
          },
          {
            breakpoint: 600,
            settings: {
              slidesToShow: 1,
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
  computed: {
    ...mapGetters({
      allGenericData: "Web/General/allGenericData",
    }),
  },
};
</script>

<style></style>
