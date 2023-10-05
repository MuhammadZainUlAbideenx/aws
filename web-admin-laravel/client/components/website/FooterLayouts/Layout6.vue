<template>
  <Footer>
    <div class="footer_layout_six">
      <div class="footer bg-secondary mt-5 px-3 px-md-0" v-if="allFooterData">
        <div class="container">
          <div class="row border-bottom-light pt-5 pb-md-5">
            <div class="col-lg-3 col-md-6 pe-5">
              <h6 class="text-uppercase fw-bold  fs-5">
                {{ $t("contact_info") }}
              </h6>
              <ul class="d-flex justify-content-center flex-column info-list">
                <li>
                  <div
                    class="
                      d-flex
                      justify-content-start
                      align-items-center
                      flex-row

                    "
                  >
                    <img
                      src="~/assets/images/icons8-place-marker-50.png"
                      alt=""
                      class="img-fluid image-white"
                    />
                    <span class="ps-3">
                      {{ allFooterData.contactDetails.contact_address }}</span
                    >
                  </div>
                </li>
                <li>
                  <div
                    class="
                      d-flex
                      justify-content-start
                      align-items-center
                      flex-row

                    "
                  >
                    <img
                      src="~/assets/images/icons8-headset-50.png"
                      alt=""
                      class="img-fluid image-white"
                    />
                    <span class="ps-3"
                      >{{ allFooterData.contactDetails.contact_number }}
                    </span>
                  </div>
                </li>
                <li>
                  <div
                    class="
                      d-flex
                      justify-content-start
                      align-items-center
                      flex-row

                    "
                  >
                    <img
                      src="~/assets/images/icons8-email-open-50.png"
                      alt=""
                      class="img-fluid image-white"
                    />
                    <span class="ps-3">{{
                      allFooterData.contactDetails.contact_email
                    }}</span>
                  </div>
                </li>
                <!-- <li>
                <div
                  class="
                    d-flex
                    justify-content-start
                    align-items-center
                    flex-row
                  "
                >
                  <img
                    src="~/assets/images/icons8-coming-soon-50.png"
                    alt=""
                    class="img-fluid"
                  />
                  <span class="ps-3">Open Time:8:00 AM - 6:00 PM</span>
                </div>
              </li> -->
              </ul>
            </div>
            <div class="col-lg-3 col-md-3 col-6 mt-md-0 mt-4 ps-lg-5">
              <h6 class="text-uppercase fw-bold  fs-5">
                {{ $t("customer_care") }}
              </h6>
              <ul class="page-list">
                <li>
                  <nuxt-link to="/contact">{{ $t("contact_us") }}</nuxt-link>
                </li>
                <li>
                  <nuxt-link to="/aboutus">{{ $t("about_us") }}</nuxt-link>
                </li>
                <li>
                  <nuxt-link to="/termcondition">{{ $t("term_condition") }}</nuxt-link>
                </li>
                <li>
                  <nuxt-link to="/refundpolicy">{{ $t("refund_policy") }}</nuxt-link>
                </li>
                <li>
                  <nuxt-link to="/privacypolicy">{{ $t("privacy_policy") }}</nuxt-link>
                </li>
              </ul>
            </div>
            <div
              class="col-lg-3 col-md-3 col-6 mt-md-0 mt-4 ps-lg-5"
              v-if="allFooterData.categories.length > 0"
            >
              <h6 class="text-uppercase fw-bold  fs-5">
                {{ this.$t("web.home.footer.categories") }}
              </h6>
              <ul class="page-list">
                <li v-for="category in allFooterData.categories">
                  <nuxt-link
                    :to="{ path: '/shop', query: { category: category.slug } }"
                    >{{ category.name }}</nuxt-link
                  >
                </li>
              </ul>
            </div>
            <div
              class="col-lg-3 col-md-3 col-12 mt-lg-0 mt-4"
              v-if="allFooterData.categories.length > 0"
            >
              <h6 class="text-uppercase fw-bold fs-5 mb-4">
                instagram feeds
              </h6>
              <div class="row">
                <div class="col-12">
                  <div class="instagram-content d-flex">
                    <a href="">
                      <img
                        src="~/assets/images/insta_2.jpg"
                        alt=""
                        class="img-fluid"
                      />
                    </a>
                    <a href="">
                      <img
                        src="~/assets/images/insta_3.jpg"
                        alt=""
                        class="img-fluid"
                      />
                    </a>
                    <a href="">
                      <img
                        src="~/assets/images/insta_4.jpg"
                        alt=""
                        class="img-fluid"
                      />
                    </a>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-12">
                  <div class="instagram-content d-flex">
                    <a href="">
                      <img
                        src="~/assets/images/insta_2.jpg"
                        alt=""
                        class="img-fluid"
                      />
                    </a>
                    <a href="">
                      <img
                        src="~/assets/images/insta_3.jpg"
                        alt=""
                        class="img-fluid"
                      />
                    </a>
                    <a href="">
                      <img
                        src="~/assets/images/insta_4.jpg"
                        alt=""
                        class="img-fluid"
                      />
                    </a>
                  </div>
                </div>
              </div>

            </div>
          </div>

          <div class="row justify-content-center">
            <div class="col-lg-6  d-flex justify-content-center">
              <div class="footer-links">
                <ul class="d-flex flex-wrap justify-content-center my-3">
                      <li><a href="#">Search</a></li>
                      <li><a href="#">Collection</a></li>
                      <li><a href="blog-page1.html">blog</a></li>
                      <li><a href="about-page1.html">About Us</a></li>
                      <li><a href="login-page1.html">Login</a></li>
                      <li><a href="signup.html">Create Account</a></li>
                      <li><a href="product-page1.html">Products</a></li>
                      <li><a href="#">Look book</a></li>
                      <li><a href="#">Portfolio</a></li>
                      <li><a href="#">FAQ</a></li>
                      <li><a href="wishlist.html">Wishlist</a></li>
                      <li><a href="contact-page1.html">Contact</a></li>
                      <li><a href="#">New Products</a></li>
                </ul>
              </div>
            </div>
          </div>
          <div class="row py-2 bg-primary">
            <div
              class="col-lg-4 text-center text-md-start pb-2 py-md-2 text-white"
            >
              {{ this.allDefaultSettings.general_settings.copyright_text }}
            </div>
            <div
              class="
                col-lg-4
                text-center
                py-2
                px-0
                d-flex
                justify-content-center justify-content-md-end
                align-items-baseline
              "
            >
              <img
                src="~/assets/images/mastercard.png"
                alt=""
                class="px-2 mb-3 mb-md-0"
              />
              <img
                src="~/assets/images/paypal.png"
                alt=""
                class="px-2 mb-3 mb-md-0"
              />
              <img src="~/assets/images/visa.png" alt="" class="px-2" />
              <img src="~/assets/images/aE.png" alt="" class="ps-2" />
            </div>
          </div>
        </div>
      </div>
    </div>
  </Footer>
</template>

<script>
import { mapGetters, mapActions } from "vuex";

export default {
  components: {},
  async fetch() {
    if (!this.allFooterData) {
      await this.fetchFooterData();
    }
  },

  data() {
    return {
      appName: process.env.appName,
      formData: {
        email: "",
      },
    };
  },

  computed: mapGetters({
    allFooterData: "Web/General/allFooterData",
    allDefaultSettings: "allDefaultSettings",
  }),

  methods: {
    ...mapActions({
      fetchFooterData: "Web/General/fetchFooterData",
    }),
    async add_email() {
      await this.$webService
        .addNewsletterEmail({ email: this.formData.email })
        .then(async (res) => {
          if (res.success == false) {
            this.$toast.error(
              this.$t("subscription_email_already_exists_message")
            );
          } else {
            this.formData.email = "";
            this.$toast.success(this.$t("subscription_email_added_message"));
          }
        })
        .catch(async (res) => {
          if (res.response.data.errors) {
            this.error = res.response.data.errors;
            if (this.error.email) {
              this.$toast.error(this.error.email[0]);
            }
          }
        });
    },
  },
};
</script>

<style scoped>
</style>
