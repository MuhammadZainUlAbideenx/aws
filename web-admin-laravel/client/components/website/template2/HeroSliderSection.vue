<template>
  <section v-if="!allGenericData" class="hero-slider">
    <WebsiteSkeletonTemplate2Heroslider />
  </section>
  <!-- <section v-else class="hero-slider">
    <div
      id="carouselExampleCaptions"
      class="carousel slide"
      data-bs-ride="carousel"
    >
      <div class="carousel-indicators">
        <button
          type="button"
          data-bs-target="#carouselExampleCaptions"
          data-bs-slide-to="0"
          class="active"
          aria-current="true"
          aria-label="Slide 1"
        ></button>
        <button
          type="button"
          data-bs-target="#carouselExampleCaptions"
          data-bs-slide-to="1"
          aria-label="Slide 2"
        ></button>
        <button
          type="button"
          data-bs-target="#carouselExampleCaptions"
          data-bs-slide-to="2"
          aria-label="Slide 3"
        ></button>
      </div>
      <div class="carousel-inner">
        <div class="carousel-item active">
          <div class="hero-section d-flex align-items-center">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-9 col-9 d-flex justify-content-between">
                        <img src="~/assets/images/fashion-women.png" class="w-50 h-auto" alt="">
                        <div class="d-flex flex-column align-items-end pt-5">
                            <h3>New Arrivals</h3>
                            <h2>Just<span>for</span></h2>
                            <h4>you</h4>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-3 col-3 d-flex justify-content-between">
                        <div class="d-none d-lg-flex flex-column w-50 py-5 px-4">
                            <span class="ms-auto">
                                <a href="#">
                                    <img src="~/assets/images/card-01.png" alt="">
                                </a>
                            </span>
                            <span class="mt-n1 ps-4">
                                <a href="#">
                                    <img src="~/assets/images/card-02.png" alt="">
                                </a>
                            </span>
                        </div>
                        <img src="~/assets/images/fashion-man.png" alt="" class="w-lg-50 h-auto py-5">
                    </div>
                </div>
            </div>
          </div>
        </div>
        <div class="carousel-item">
          <div class="hero-section d-flex align-items-center">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-9 col-9 d-flex justify-content-between">
                        <img src="~/assets/images/fashion-women.png" class="w-50 h-auto" alt="">
                        <div class="d-flex flex-column align-items-end pt-5">
                            <h3>New Arrivals</h3>
                            <h2>Just<span>for</span></h2>
                            <h4>you</h4>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-3 col-3 d-flex justify-content-between">
                        <div class="d-none d-lg-flex flex-column w-50 py-5 px-4">
                            <span class="ms-auto">
                                <a href="#">
                                    <img src="~/assets/images/card-01.png" alt="">
                                </a>
                            </span>
                            <span class="mt-n1 ps-4">
                                <a href="#">
                                    <img src="~/assets/images/card-02.png" alt="">
                                </a>
                            </span>
                        </div>
                        <img src="~/assets/images/fashion-man.png" alt="" class="w-lg-50 h-auto py-5">
                    </div>
                </div>
            </div>
          </div>
        </div>
        <div class="carousel-item">
          <div class="hero-section d-flex align-items-center">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-9 col-9 d-flex justify-content-between">
                        <img src="~/assets/images/fashion-women.png" class="w-50 h-auto" alt="">
                        <div class="d-flex flex-column align-items-end pt-5">
                            <h3>New Arrivals</h3>
                            <h2>Just<span>for</span></h2>
                            <h4>you</h4>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-3 col-3 d-flex justify-content-between">
                        <div class="d-none d-lg-flex flex-column w-50 py-5 px-4">
                            <span class="ms-auto">
                                <a href="#">
                                    <img src="~/assets/images/card-01.png" alt="">
                                </a>
                            </span>
                            <span class="mt-n1 ps-4">
                                <a href="#">
                                    <img src="~/assets/images/card-02.png" alt="">
                                </a>
                            </span>
                        </div>
                        <img src="~/assets/images/fashion-man.png" alt="" class="w-lg-50 h-auto py-5">
                    </div>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section> -->
    <section v-else class="hero-slider">
    <div v-if="allGenericData.slider_images.length > 0" class="container">
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
              <div class="hero-section">
                <div
                  v-if="slider_image.name"
                  class="fadin text-uppercase fw-light fs-1"
                >
                  <h3>{{ slider_image.name }}</h3>
                </div>
                <div
                  v-if="slider_image.heading"
                  class="rig-to-lef text-uppercase fw-bold"
                >
                  <h2>{{ slider_image.heading }}</h2>
                </div>
                <h4>
                  you
                </h4>
                <!-- <div
                  v-if="slider_image.discount"
                  class="lef-to-rig text-uppercase fw-light"
                >
                  Upto
                  <span class="fw-bold text-primary"
                    >{{ slider_image.discount }}%</span
                  >
                  off
                </div> -->
              </div>
              <!-- <nuxt-link
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
              </nuxt-link> -->
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
              dots: false,
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
