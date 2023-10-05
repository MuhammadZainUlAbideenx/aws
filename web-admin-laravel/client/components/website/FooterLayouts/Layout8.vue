<template>
  <Footer>
    <div class="footer_layout_eight">
      <div class="footer bg-dark mt-5 px-3 px-md-0" v-if="allFooterData">
        <div class="container">
          <div class="row">
            <div class="col-12">
              <div class="footer-logo pt-5">
                  <a href="">
                    <img
                      src="~/assets/images/nictus-logo-white.png"
                      alt=""
                      class="img-fluid"
                    />
                </a>
              </div>
            </div>
          </div>
          <div class="row py-4 ">
            <div class="col-md-3">
              <div class="content-info">
                <h2 class="text-white py-3 contact">CONTACT INFO</h2>
                <p class="text-white mb-0 address">ADDRESS:</p>
                <p class="street-adress">123 Street Name, City, England</p>
                <p class="text-white mb-0 address">PHONE:</p>
                <p class="street-adress">{{ allFooterData.contactDetails.contact_number }}</p>
                <p class="text-white mb-0 address">EMAIL:</p>
                <p class="street-adress"><a href="">{{
                      allFooterData.contactDetails.contact_email
                    }}</a></p>
                <!-- <p class="text-white mb-0 address">WORKING DAYS/HOURS:</p>
                <p class="street-adress">Mon - Sun / 9:00 AM - 8:00 PM</p> -->

                <ul class="d-flex">
                  <li>
                    <a
                      :href="
                        this.allDefaultSettings.general_settings.facebook_url
                      "
                      v-if="
                        this.allDefaultSettings.general_settings.facebook_url
                      "
                      class="facebook"
                      ><svg
                        xmlns="http://www.w3.org/2000/svg"
                        version="1.1"
                        xmlns:xlink="http://www.w3.org/1999/xlink"
                        xmlns:svgjs="http://svgjs.com/svgjs"
                        width="20"
                        height="20"
                        x="0"
                        y="0"
                        viewBox="0 0 155.139 155.139"
                        style="enable-background: new 0 0 512 512"
                        xml:space="preserve"
                        class=""
                      >
                        <g>
                          <g xmlns="http://www.w3.org/2000/svg">
                            <path
                              id="f_1_"
                              style=""
                              d="M89.584,155.139V84.378h23.742l3.562-27.585H89.584V39.184   c0-7.984,2.208-13.425,13.67-13.425l14.595-0.006V1.08C115.325,0.752,106.661,0,96.577,0C75.52,0,61.104,12.853,61.104,36.452   v20.341H37.29v27.585h23.814v70.761H89.584z"
                              fill="currentColor"
                              data-original="currentColor"
                              class=""
                            ></path>
                          </g>
                          <g xmlns="http://www.w3.org/2000/svg"></g>
                          <g xmlns="http://www.w3.org/2000/svg"></g>
                          <g xmlns="http://www.w3.org/2000/svg"></g>
                          <g xmlns="http://www.w3.org/2000/svg"></g>
                          <g xmlns="http://www.w3.org/2000/svg"></g>
                          <g xmlns="http://www.w3.org/2000/svg"></g>
                          <g xmlns="http://www.w3.org/2000/svg"></g>
                          <g xmlns="http://www.w3.org/2000/svg"></g>
                          <g xmlns="http://www.w3.org/2000/svg"></g>
                          <g xmlns="http://www.w3.org/2000/svg"></g>
                          <g xmlns="http://www.w3.org/2000/svg"></g>
                          <g xmlns="http://www.w3.org/2000/svg"></g>
                          <g xmlns="http://www.w3.org/2000/svg"></g>
                          <g xmlns="http://www.w3.org/2000/svg"></g>
                          <g xmlns="http://www.w3.org/2000/svg"></g>
                        </g></svg
                    ></a>
                  </li>
                  <li class="px-3">
                    <a   :href="
                        this.allDefaultSettings.general_settings.twitter_url
                      " class="twitter">
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        version="1.1"
                        xmlns:xlink="http://www.w3.org/1999/xlink"
                        xmlns:svgjs="http://svgjs.com/svgjs"
                        width="20"
                        height="20"
                        x="0"
                        y="0"
                        viewBox="0 0 512 512"
                        style="enable-background: new 0 0 512 512"
                        xml:space="preserve"
                        class=""
                      >
                        <g>
                          <g xmlns="http://www.w3.org/2000/svg">
                            <g>
                              <path
                                d="M512,97.248c-19.04,8.352-39.328,13.888-60.48,16.576c21.76-12.992,38.368-33.408,46.176-58.016    c-20.288,12.096-42.688,20.64-66.56,25.408C411.872,60.704,384.416,48,354.464,48c-58.112,0-104.896,47.168-104.896,104.992    c0,8.32,0.704,16.32,2.432,23.936c-87.264-4.256-164.48-46.08-216.352-109.792c-9.056,15.712-14.368,33.696-14.368,53.056    c0,36.352,18.72,68.576,46.624,87.232c-16.864-0.32-33.408-5.216-47.424-12.928c0,0.32,0,0.736,0,1.152    c0,51.008,36.384,93.376,84.096,103.136c-8.544,2.336-17.856,3.456-27.52,3.456c-6.72,0-13.504-0.384-19.872-1.792    c13.6,41.568,52.192,72.128,98.08,73.12c-35.712,27.936-81.056,44.768-130.144,44.768c-8.608,0-16.864-0.384-25.12-1.44    C46.496,446.88,101.6,464,161.024,464c193.152,0,298.752-160,298.752-298.688c0-4.64-0.16-9.12-0.384-13.568    C480.224,136.96,497.728,118.496,512,97.248z"
                                fill="currentColor"
                                data-original="currentColor"
                                class=""
                              ></path>
                            </g>
                          </g>
                          <g xmlns="http://www.w3.org/2000/svg"></g>
                          <g xmlns="http://www.w3.org/2000/svg"></g>
                          <g xmlns="http://www.w3.org/2000/svg"></g>
                          <g xmlns="http://www.w3.org/2000/svg"></g>
                          <g xmlns="http://www.w3.org/2000/svg"></g>
                          <g xmlns="http://www.w3.org/2000/svg"></g>
                          <g xmlns="http://www.w3.org/2000/svg"></g>
                          <g xmlns="http://www.w3.org/2000/svg"></g>
                          <g xmlns="http://www.w3.org/2000/svg"></g>
                          <g xmlns="http://www.w3.org/2000/svg"></g>
                          <g xmlns="http://www.w3.org/2000/svg"></g>
                          <g xmlns="http://www.w3.org/2000/svg"></g>
                          <g xmlns="http://www.w3.org/2000/svg"></g>
                          <g xmlns="http://www.w3.org/2000/svg"></g>
                          <g xmlns="http://www.w3.org/2000/svg"></g>
                        </g>
                      </svg>
                    </a>
                  </li>
                  <li>
                    <a   :href="
                        this.allDefaultSettings.general_settings.linked_in_url
                      " class="linkedin">
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        version="1.1"
                        xmlns:xlink="http://www.w3.org/1999/xlink"
                        xmlns:svgjs="http://svgjs.com/svgjs"
                        width="20"
                        height="20"
                        x="0"
                        y="0"
                        viewBox="0 0 100 100"
                        style="enable-background: new 0 0 512 512"
                        xml:space="preserve"
                        class=""
                      >
                        <g>
                          <g
                            xmlns="http://www.w3.org/2000/svg"
                            id="_x31_0.Linkedin"
                          >
                            <path
                              d="m90 90v-29.3c0-14.4-3.1-25.4-19.9-25.4-8.1 0-13.5 4.4-15.7 8.6h-.2v-7.3h-15.9v53.4h16.6v-26.5c0-7 1.3-13.7 9.9-13.7 8.5 0 8.6 7.9 8.6 14.1v26h16.6z"
                              fill="currentColor"
                              data-original="currentColor"
                              class=""
                            ></path>
                            <path
                              d="m11.3 36.6h16.6v53.4h-16.6z"
                              fill="currentColor"
                              data-original="currentColor"
                              class=""
                            ></path>
                            <path
                              d="m19.6 10c-5.3 0-9.6 4.3-9.6 9.6s4.3 9.7 9.6 9.7 9.6-4.4 9.6-9.7-4.3-9.6-9.6-9.6z"
                              fill="currentColor"
                              data-original="currentColor"
                              class=""
                            ></path>
                          </g>
                        </g>
                      </svg>
                    </a>
                  </li>
                </ul>
              </div>
            </div>
            <div class="col-md-9">
              <div class="row align-items-center">
                <div class="col-md-6">
                  <div class="subscribe">
                    <h2 class="text-white py-3">SUBSCRIBE NEWSLETTER</h2>
                    <p>
                      Get all the latest information on Events, Sales and
                      Offers. <br />
                      Sign up for newsletter today.
                    </p>
                  </div>
                </div>
                <div class="col-md-6">
                  <form action="">
                    <div class="input-group">
                      <input
                        type="text"
                        class="form-control text-white"
                        placeholder="Email Address"
                        aria-label="Recipient's username"
                        aria-describedby="basic-addon2"
                      />
                      <button
                        class="input-group-text btn btn-primary text-white fw-bold"
                        id="basic-addon2"
                        >Subscribe</button
                      >
                    </div>
                  </form>
                </div>
              </div>
              <div class="line">
                <hr class="line-c" />
              </div>
              <div class="row">
                <div class="col-lg-3 col-md-3 col-6 mt-md-0 mt-4">
                  <h6 class="text-uppercase fw-bold text-white fs-6">
                    {{ $t("customer_care") }}
                  </h6>
                  <ul class="page-list">
                    <li>
                      <nuxt-link to="/contact">{{
                        $t("contact_us")
                      }}</nuxt-link>
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
                  class="col-lg-4 col-md-3 col-6 mt-md-0 mt-4"
                  v-if="allFooterData.categories.length > 0"
                >
                  <h6 class="text-uppercase fw-bold text-white fs-6">
                    {{ this.$t("web.home.footer.categories") }}
                  </h6>
                  <ul class="page-list">
                    <li v-for="category in allFooterData.categories">
                      <nuxt-link
                        :to="{
                          path: '/shop',
                          query: { category: category.slug },
                        }"
                        >{{ category.name }}</nuxt-link
                      >
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>

          <div class="row py-2 bg-dark border-top-c">
            <div
              class="col-lg-6 col-12 text-center text-md-start pb-2 py-md-2 text-white"
            >
              {{ this.allDefaultSettings.general_settings.copyright_text }}
            </div>
            <div
              class="
                col-lg-6
                text-center
                py-2
                px-0
                d-flex
                col-12
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
