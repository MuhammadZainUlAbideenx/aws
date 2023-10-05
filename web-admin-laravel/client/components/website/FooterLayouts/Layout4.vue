<template>
  <Footer class="pt-5">
    <div class="footer_layout_four">
      <!-- <div class="footer-wraper bg-dark py-5">
        <div class="container">
          <div class="row">
            <div class="col-lg-6 col-md-12">
              <div class="footer-subscribe-wrapper mt-2">
                <h3 class="entry-title text-white">Get our emails for info <br> on new items, sales and more.</h3>
                <div class="entry-description">
                  <p class="mb-0 text-white">We'll email you a voucher worth £10 off your first order over £50.</p>
                </div>
              </div>

            </div>
            <div class="col-lg-6 d-flex flex-column align-items-start col-md-12">
              <form action="" class="mt-4 w-100">
                <div class="input-group mb-2 w-100">
                  <input type="text" class="form-control rounded-0" placeholder="Enter your email address "
                    aria-label="Recipient's username" aria-describedby="basic-addon2">
                  <a href="" class="input-group-text rounded-0 bg-dark text-white px-4"
                    id="basic-addon2">Subscribe</a>
                </div>
              </form>
              <p class="privacy-text text-white mb-0">
                <a href="" class="text-white">
                  By subscribing you agree to our Terms & Conditions and Privacy & Cookies Policy.
                </a>
              </p>
            </div>
          </div>
        </div>
      </div> -->



      <div class="container">
        <div class="row py-5">
          <div class="col col-12 col-lg-4">
            <div class="footer-logo ">
              <a href="">
                <img src="~/assets/images/nictus-logo.png" alt="" class="img-fluid mb-3">
              </a>
              <p>Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis in
                termapol.</p>
              <p>
                <a href="">{{ allFooterData.contactDetails.contact_number }} - {{
                      allFooterData.contactDetails.contact_email
                    }}</a>
              </p>
            </div>
          </div>
          <div class="col col-md-3 col-lg-2">
            <h4 class="mb-3">Information</h4>
            <ul class="unlisted ps-0">
              <li class="mb-2">
                  <nuxt-link to="/contact">{{ $t("contact_us") }}</nuxt-link>
                </li>
                <li class="mb-2">
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
          <div class="col col-md-3 col-lg-2">
            <h4 class="mb-3">Account</h4>
            <ul class="unlisted ps-0">
              <li class="mb-2">
                <a href="">Dashboard</a>
              </li>
              <li class="mb-2">
                <a href="">My Orders</a>
              </li>
              <li class="mb-2">
                <a href="">My Wishlist</a>
              </li>
              <li class="mb-2">
                <a href="">Account details</a>
              </li>
              <li class="mb-2">
                <a href="">Track My Orders</a>
              </li>
            </ul>
          </div>
          <div class="col col-md-3 col-lg-2">
            <h4 class="mb-3">Shop</h4>
            <ul class="unlisted ps-0">
              <li class="mb-2">
                <a href="">Affiliate</a>
              </li>
              <li class="mb-2">
                <a href="">Bestsellers</a>
              </li>
              <li class="mb-2">
                <a href="">Discount</a>
              </li>
              <li class="mb-2">
                <a href="">Latest Products</a>
              </li>
              <li class="mb-2">
                <a href="">Sale Products</a>
              </li>
            </ul>
          </div>
          <div class="col col-md-3 col-lg-2" v-if="allFooterData.categories.length > 0">
            <h4 class="mb-3">Categories</h4>
            <ul class="unlisted ps-0">
                 <li class="mb-2" v-for="category in allFooterData.categories">
                  <nuxt-link
                    :to="{ path: '/shop', query: { category: category.slug } }"
                    >{{ category.name }}</nuxt-link
                  >
                </li>
              <!-- <li class="mb-2">
                <a href="">Women</a>
              </li>
              <li class="mb-2">
                <a href="">Men</a>
              </li>
              <li class="mb-2">
                <a href="">Bags</a>
              </li>
              <li class="mb-2">
                <a href="">Outerwear</a>
              </li>
              <li class="mb-2">
                <a href="">Shoes</a>
              </li> -->
            </ul>
          </div>
        </div>
      </div>


  <div class="pb-5">
    <div class="container">
      <div class="row">
        <div class="col-12">
         <div class="categories d-flex align-items-center mb-3">
          <h4 class="me-3">Consumer Electric:</h4>
          <a class="me-3">TV Television</a>
          <a class="me-3">Air Condition</a>
          <a class="me-3">Refrigator</a>
          <a class="me-3">Washing Machine</a>
          <a class="me-3">Audio Speaker</a>
          <a class="me-3 after-none">Security Camera</a>
         </div>
        </div>
      </div>

      <div class="row">
        <div class="col-12">
         <div class="categories d-flex align-items-center mb-3">
          <h4 class="me-3">Clothing & Apparel:</h4>
          <a class="me-3">Men T-shirt</a>
          <a class="me-3">Dresses</a>
          <a class="me-3">Men's Sneaker</a>
          <a class="me-3">Leather Backpack</a>
          <a class="me-3">Watches</a>
          <a class="me-3">Boots</a>
          <a class="me-3">Rayban</a>
          <a class="me-3 after-none">Formal Shirts</a>
         </div>
        </div>
      </div>

      <div class="row">
        <div class="col-12">
         <div class="categories d-flex align-items-center mb-3">
          <h4 class="me-3">Home, Garden & Kitchen:</h4>
          <a class="me-3">Sofa</a>
          <a class="me-3">Chair</a>
          <a class="me-3">Bed Room</a>
          <a class="me-3">Living Room</a>
          <a class="me-3">Cookware</a>
          <a class="me-3">Utensil</a>
          <a class="me-3">Blender</a>
          <a class="me-3">Decor</a>
          <a class="me-3">Library</a>
          <a class="me-3 after-none">Wayfarer</a>
         </div>
        </div>
      </div>




      <div class="row">
        <div class="col-12">
         <div class="categories d-flex align-items-center mb-3">
          <h4 class="me-3">Health & Beauty:</h4>
          <a class="me-3">Skin Care</a>
          <a class="me-3">Body Shower</a>
          <a class="me-3">Bed Room</a>
          <a class="me-3">Makeup</a>
          <a class="me-3">Cookware</a>
          <a class="me-3">Hair Care</a>
          <a class="me-3">Lipstick</a>
          <a class="me-3 after-none">Perfume</a>
         </div>
        </div>
      </div>




      <div class="row">
        <div class="col-12">
         <div class="categories d-flex align-items-center mb-3">
          <h4 class="me-3">Jewelry & Watches:</h4>
          <a class="me-3">Necklace</a>
          <a class="me-3">Pendant</a>
          <a class="me-3">Diamond Ring</a>
          <a class="me-3">Silver Earing</a>
          <a class="me-3">Leather Watcher</a>
          <a class="me-3">Rolex</a>
          <a class="me-3">Gucci</a>
          <a class="me-3">Australian Opal</a>
          <a class="me-3">Ammolite</a>
          <a class="me-3 after-none">Sun Pyrite</a>
         </div>
        </div>
      </div>


      <div class="row">
        <div class="col-12">
         <div class="categories d-flex align-items-center mb-3">
          <h4 class="me-3">Computer & Technologies:</h4>
          <a class="me-3">Laptop</a>
          <a class="me-3">iMac</a>
          <a class="me-3">Smartphone</a>
          <a class="me-3">Tablet</a>
          <a class="me-3">Apple</a>
          <a class="me-3">Asus</a>
          <a class="me-3">Drone</a>
          <a class="me-3">Wireless Speaker</a>
          <a class="me-3">Game Controller</a>
          <a class="me-3 after-none">Sun Pyrite</a>
         </div>
        </div>
      </div>

    </div>
  </div>


      <div class="container">
        <div class="payment-method py-5">
          <div class="container">
            <div class="row align-items-center">
              <div class="col-md-4">
                <p class="mb-0"> {{ this.allDefaultSettings.general_settings.copyright_text }}</p>
              </div>
              <div class="col-md-4">
                <p class="my-2 payment-logo-width">
                  <a href="">
                    <img src="~/assets/images/payment-method/paypal-logo.png" alt="" class="img-fluid pe-2">
                  </a>
                  <a href="">
                    <img src="~/assets/images/payment-method/mastercard-logo.png" alt="" class="img-fluid pe-2">
                  </a>
                  <a href="">
                    <img src="~/assets/images/payment-method/visa-logo.png" alt="" class="img-fluid pe-2">
                  </a>
                  <a href="">
                    <img src="~/assets/images/payment-method/stripe-logo.png" alt="" class="img-fluid pe-2">
                  </a>
                </p>
              </div>
              <div class="col-md-4">
                <ul class="footer-list ps-0">
                  <li class="pe-3">
                    <a href="">
                      privacy policy
                    </a>
                  </li>
                  <li class="pe-3 before-left">
                    <a href="">
                      Terms and Conditions
                    </a>
                  </li>
                  <li class="before-left">
                    <a href="">
                      Returns Policy
                    </a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>

    <!-- <div class="footer_layout_three">
      <div
        class="footer bg-dark-gray pt-100 mt-50 px-3 px-md-0"
        v-if="allFooterData"
      >
        <div class="container">
          <div class="row border-bottom-light pb-4 pb-md-5">
            <div class="col-lg-3 col-md-6 pe-5">
              <h6 class="text-uppercase fw-bold text-white fs-5">
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
                      class="img-fluid"
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
                      class="img-fluid"
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
                      class="img-fluid"
                    />
                    <span class="ps-3">{{
                      allFooterData.contactDetails.contact_email
                    }}</span>
                  </div>
                </li>

              </ul>
            </div>
            <div class="col-lg-3 col-md-3 col-6 mt-md-0 mt-4 ps-lg-5">
              <h6 class="text-uppercase fw-bold text-white fs-5">
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
                  <nuxt-link to="">{{ $t("f_a_q") }}</nuxt-link>
                </li>
                <li>
                  <nuxt-link to="/aboutus">{{ $t("service") }}</nuxt-link>
                </li>
                <li>
                  <nuxt-link to="/aboutus">{{ $t("help_center") }}</nuxt-link>
                </li>
              </ul>
            </div>
            <div
              class="col-lg-3 col-md-3 col-6 mt-md-0 mt-4 ps-lg-5"
              v-if="allFooterData.categories.length > 0"
            >
              <h6 class="text-uppercase fw-bold text-white fs-5">
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
              <h6 class="text-uppercase fw-bold text-white fs-5 mb-4">
                {{ $t("sidebar.newsletter") }}
              </h6>
              <p>
                {{ $t("newsletter_description") }}
              </p>
              <form class="position-relative">
                <input
                  :placeholder="$t('enter_email')"
                  type="email"
                  v-on:keyup.enter="add_email()"
                  v-model="formData.email"
                  class="px-3 w-100 border-0"
                />
                <button
                  type="button"
                  v-on:click="add_email()"
                  class="
                    position-absolute
                    ftr-email
                    end-0
                    top-0
                    btn btn-primary
                    rounded-0
                    text-white
                    fs-5
                  "
                >
                  <fa :icon="['fas', 'paper-plane']" />
                </button>
              </form>
              <ul class="d-flex">
                <li>
                  <a
                    :href="
                      this.allDefaultSettings.general_settings.facebook_url
                    "
                    v-if="this.allDefaultSettings.general_settings.facebook_url"
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
                  <a href="#" class="twitter">
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
                  <a href="#" class="linkedin">
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
          <div class="row py-4">
            <div class="col-lg-6 text-center text-md-start pb-2 py-md-2">
              {{ this.allDefaultSettings.general_settings.copyright_text }}
            </div>
            <div
              class="
                col-lg-6
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
    </div> -->
  </Footer>
</template>

<script>
import { mapGetters, mapActions } from "vuex";

export default {
  components: {
  },
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
