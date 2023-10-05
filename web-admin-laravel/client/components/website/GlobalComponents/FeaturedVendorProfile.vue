<template>
  <section class="vender-detail mart-sectioin mt-5">
    <div class="container" v-if="currentlyActiveTemplate == 'Template1'">
      <div class="row">
        <div class="col-12">
          <div class="vender-detail-wrap bg-secondary rounded-bottom pb-4">
            <div class="mart-bg-wrap">
              <img
                class="mart-bg"
                v-if="vendor.store != null && vendor.store.cover_image"
                :src="`/backend${vendor.store.cover_image.original_media_path}`"
                alt=""
              />
              <img
                class="mart-bg"
                src="~assets/images/mart-section-bg.png"
                v-else
                alt=""
              />
              <div class="mart-logo-wrap img-wrap">
                <img
                  :src="`/backend${vendor.store.store_logo.original_media_path}`"
                  v-if="vendor.store != null && vendor.store.store_logo"
                  class="img-fluid"
                  alt=""
                />
                <img
                  src="~assets/images/mart-section-logo.png"
                  v-else
                  class="img-fluid"
                  alt=""
                />
              </div>
            </div>
            <h2 class="section-heading"  v-if="vendor.store != null && vendor.store.name">{{ this.vendor.store.name }}</h2>
            <div
              class="
                vender-info
                d-flex
                justify-content-between
                align-items-center
                p-4
                px-5

              "
            >
              <div class="vender-rating">
                <div class="text-primary fw-bold mb-1">
                  <nuxt-link :to="`/store/${vendor.store.slug}/reviews`">
                   {{$t('web.customer.featured_vendor_profile.seller_rating')}}
                  </nuxt-link>
                </div>
                <div class="star-rating mx-auto">
                  <GlobalRating :rating="`${vendor.reviews_average_rating}`" />
                </div>
              </div>
                <div class="vender-rating">
                <div class="text-primary fw-bold mb-1">
                  <nuxt-link :to="`/store/${vendor.store.slug}/reviews`">
                   {{$t('web.customer.featured_vendor_profile.order_completion')}}
                  </nuxt-link>
                </div>
                <div class="star-rating mx-auto">
                  <GlobalRating :rating="`${vendor.orders_average_rating}`" />
                </div>
              </div>
              <div class="vender-followers">
                <div>  {{$t('web.customer.featured_vendor_profile.followers')}}</div>
                <div class="text-primary fw-bold mb-1">{{vendor.total_follower}}</div>
              </div>
              <!-- <div class="vender-response">
                <div class="text-primary fw-bold mb-1">Chat Response rate</div>
                <div>100.00%</div>
              </div> -->
              <div class="vender-btns">
                 <nuxt-link :to="`/store/${vendor.store.slug}/reviews?type=all-products`">
                <button
                  class="
                    btn btn-primary
                    text-white
                    rounded
                    fw-bold
                    d-flex
                    align-items-center
                    justify-content-center
                    mb-2
                    mx-auto
                  "
                >
                  {{$t('web.customer.featured_vendor_profile.all_products')}}
                </button>
                 </nuxt-link>
                <button
                  class="
                    btn btn-warning
                    rounded
                    fw-bold
                    d-flex
                    align-items-center
                    justify-content-center
                    mx-auto
                  "
                   @click="followVendor(vendor.id)"
                >
                  <fa :icon="['fas', 'heart']" :class=" follow ? 'text-danger' : ''"  class="me-2" /> {{$t('follow')}}
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="container" v-if="currentlyActiveTemplate == 'Template2'">
      <div class="row">
        <div class="col-12">
          <div class="vender-detail-wrap bg-secondary rounded-bottom pb-4">
            <div class="mart-bg-wrap">
              <img
                class="mart-bg"
                v-if="vendor.store != null && vendor.store.cover_image"
                :src="`/backend${vendor.store.cover_image.original_media_path}`"
                alt=""
              />
              <img
                class="mart-bg"
                src="~assets/images/mart-section-bg.png"
                v-else
                alt=""
              />
              <div class="mart-logo-wrap img-wrap">
                <img
                  :src="`/backend${vendor.store.store_logo.original_media_path}`"
                  v-if="vendor.store != null && vendor.store.store_logo"
                  class="img-fluid"
                  alt=""
                />
                <img
                  src="~assets/images/mart-section-logo.png"
                  v-else
                  class="img-fluid"
                  alt=""
                />
              </div>
            </div>
            <h2 class="section-heading"  v-if="vendor.store != null && vendor.store.name">{{ this.vendor.store.name }}</h2>
            <div
              class="
                vender-info
                d-flex
                justify-content-between
                align-items-center
                p-4
                px-5

              "
            >
              <div class="vender-rating">
                <div class="text-primary fw-bold mb-1">
                  <nuxt-link :to="`/store/${vendor.store.slug}/reviews`">
                     {{$t('web.customer.featured_vendor_profile.seller_rating')}}
                  </nuxt-link>
                </div>
                <div class="star-rating mx-auto">
                  <GlobalRating :rating="`${vendor.reviews_average_rating}`" />
                </div>
              </div>
                <div class="vender-rating">
                <div class="text-primary fw-bold mb-1">
                  <nuxt-link :to="`/store/${vendor.store.slug}/reviews`">
                   {{$t('web.customer.featured_vendor_profile.order_completion')}}
                  </nuxt-link>
                </div>
                <div class="star-rating mx-auto">
                  <GlobalRating :rating="`${vendor.orders_average_rating}`" />
                </div>
              </div>
              <div class="vender-followers">
                <div>{{$t('web.customer.featured_vendor_profile.followers')}}</div>
                <div class="text-primary fw-bold mb-1">{{vendor.total_follower}}</div>
              </div>
              <!-- <div class="vender-response">
                <div class="text-primary fw-bold mb-1">Chat Response rate</div>
                <div>100.00%</div>
              </div> -->
              <div class="vender-btns">
                 <nuxt-link :to="`/store/${vendor.store.slug}/reviews?type=all-products`">
                <button
                  class="
                    btn btn-primary
                    text-white
                    rounded
                    fw-bold
                    d-flex
                    align-items-center
                    justify-content-center
                    mb-2
                    mx-auto
                  "
                >
                   {{$t('web.customer.featured_vendor_profile.all_products')}}
                </button>
                 </nuxt-link>
                <button
                  class="
                    btn btn-warning
                    rounded
                    fw-bold
                    d-flex
                    align-items-center
                    justify-content-center
                    mx-auto
                  "
                   @click="followVendor(vendor.id)"
                >
                  <fa :icon="['fas', 'heart']" :class=" follow ? 'text-danger' : ''"  class="me-2" /> {{$t('follow')}}
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>
<style media="screen">
</style>
<script type="text/javascript">
import { mapGetters } from "vuex";

export default {
  props: ["vendor"],
  data() {
    return {
        follow : false,
         currentlyActiveTemplate: "",
        data:{
            vendor_id:"",
            customer_id:"",
        },
      settings: {
        infinite: true,
        slidesToShow: 4,
        speed: 500,
        rows: 2,
        slidesPerRow: 1,
        responsive: [
          {
            breakpoint: 1024,
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
              slidesToShow: 1,
              slidesToScroll: 1,
            },
          },
        ],
      },
    };
  },
  methods: {
     async followVendor(vendor_id) {

    if (
        this.$auth.loggedIn &&
        this.$gates.hasRole('customer')
      ) {
         this.data.vendor_id = vendor_id
        this.data.customer_id = this.$auth.user.id
        await this.$webService
          .followVendor(this.data)
          .then(async (res) => {
                this.follow = res.data.is_follow;
              this.$emit('updateFollowCount',this.follow)
              this.$toast.success(res.message);
          });
      } else {
        this.$toast.error(this.$t("please_login_first"));
      }
    },
  },
 created()
  {
    this.currentlyActiveTemplate = this.allSettings.general_settings.currently_active_theme;

    this.follow = this.vendor.is_followed
  },
  computed: {
     ...mapGetters({
      allSettings: "allDefaultSettings",
    }),
    cover_image() {
      if (this.vendor && this.vendor.store && this.vendor.store.cover_image) {
        return this.vendor.store.cover_image;
      } else {
        return null;
      }
    },
    store_logo() {
      if (this.vendor && this.vendor.store && this.vendor.store.store_logo) {
        return this.vendor.store.store_logo;
      } else {
        return null;
      }
    },
  },
};
</script>
