<template>
  <section v-if="!allGenericData" class="hero-slider">
    <WebsiteSkeletonTemplate1Heroslider />
  </section>
  <section v-else class="hero-slider">
    <div v-if="allGenericData.slider_images.length > 0">
      <VueSlickCarousel :key="key" v-bind="settings">
        <div
          v-for="slider_image in allGenericData.slider_images"
          :key="slider_image.id"
        >
          <div class="hero-wrp">
            <nuxt-link
              v-if="slider_image.url_type == 1"
              :to="slider_image.website_url"
            >
              <img
                v-if="slider_image.image"
                :src="`/backend${slider_image.image.original_media_path}`"
                class="hero-img d-block w-100"
                alt="..."
              />
              <img
                v-else
                src="~/assets/images/slider.jpg"
                class="hero-img d-block w-100"
                alt=""
              />
            </nuxt-link>
            <a v-else :href="slider_image.website_url">
              <img
                v-if="slider_image.image"
                :src="`/backend${slider_image.image.original_media_path}`"
                class="hero-img d-block w-100"
                alt="..."
              />
              <img
                v-else
                src="~/assets/images/slider.jpg"
                class="hero-img d-block w-100"
                alt=""
              />
            </a>
            <div class="hero-caption text-left container">
              <h1>
                <div
                  v-if="slider_image.name"
                  class="lef-to-rig text-uppercase fw-light fs-1"
                >
                  {{ slider_image.name }}
                </div>
                <div
                  v-if="slider_image.heading"
                  class="rig-to-lef text-uppercase fw-bold"
                >
                  {{ slider_image.heading }}
                </div>
                <div
                  v-if="slider_image.discount"
                  class="lef-to-rig text-uppercase fw-light"
                >
                  Upto
                  <span class="fw-bold text-primary"
                    >{{ slider_image.discount }}%</span
                  >
                  off
                </div>
              </h1>
              <nuxt-link
                v-if="slider_image.url_type == 1 && slider_image.button_text"
                :to="slider_image.website_url"
              >
                <button
                  class="
                    btn btn-warning
                    rounded
                    text-uppercase
                    mt-3
                    fw-bold
                    px-4
                    py-2
                  "
                >
                  {{ slider_image.button_text }}
                  <span class="align-middle">
                    <fa :icon="['fas', 'caret-right']" class="" /><fa
                      :icon="['fas', 'caret-right']"
                      class=""
                    />
                  </span>
                </button>
              </nuxt-link>
              <a
                v-if="slider_image.url_type == 2 && slider_image.button_text"
                :href="slider_image.website_url"
              >
                <button
                  class="
                    btn btn-warning
                    rounded
                    text-uppercase
                    mt-3
                    fw-bold
                    px-4
                    py-2
                  "
                >
                  {{ slider_image.button_text }}
                  <span class="align-middle">
                    <fa :icon="['fas', 'caret-right']" class="" /><fa
                      :icon="['fas', 'caret-right']"
                      class=""
                    />
                  </span>
                </button>
              </a>
            </div>
          </div>
        </div>
      </VueSlickCarousel>
    </div>
    <!-- <div v-if="allGenericData.slider_images.length > 0">
        <VueSlickCarousel :key="key" v-bind="settings">
        <div v-for="slider_image in allGenericData.slider_images"  :key="slider_image.id">
        <div class="hero-wrp">
          <a href="#" >
            <img src="~/assets/images/slider.jpg" class="hero-img d-block w-100" alt="...">
          <div class="hero-caption d-none d-md-block text-left container">
            <h1>
              <div class="lef-to-rig text-uppercase fw-light">New Arrival</div>
              <div  class="rig-to-lef text-uppercase fw-bold">Women Fasion</div>
              <div class="lef-to-rig text-uppercase fw-light">Upto <span class="fw-bold text-primary">40%</span> off</div>
            </h1>
            <button class="btn btn-warning rounded text-uppercase mt-3 fw-bold px-4 py-2">
              Shop now
              <span class="align-middle">
                <fa :icon="['fas', 'caret-right']" class="" /><fa :icon="['fas', 'caret-right']" class="" />
              </span>
          </button>
          </div>
        </a>
        </div>
        </div>
      </VueSlickCarousel>
      </div> -->
  </section>
</template>
<script>
import { mapGetters } from "vuex";
export default {
  data() {
    return {
      key: 1,
      settings: {
        responsive: [
          {
            breakpoint: 1024,
            settings: {
              slidesToShow: 1,
              arrows: false,
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
  watch: {
    allGenericData() {
      this.key += 1;
    },
  },
};
</script>

<style>
</style>
