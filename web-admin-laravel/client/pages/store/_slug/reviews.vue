<template>
  <section v-if="$fetchState.pending">
    <WebsiteGlobalComponentsBreadCrumb :page="`store_reviews`"/>
     <Component :is="`WebsiteSkeleton${currentlyActiveTemplate}ReviewPage`" />
  </section>

  <section v-else class="vendor-review-page m-0">
    <WebsiteGlobalComponentsBreadCrumb :page="`store_reviews`"/>
    <WebsiteGlobalComponentsSubNavSection @switchTab="(param)=>this.tab = param" />

    <section class="review-cards mt-5 mb-0">
      <div class="container">
        <div class="row">
          <div class="col-md-4 mb-4 mb-md-0">
            <div
              class="
                d-flex
                align-items-center
                rounded
                shadow
                card-wrap
                categories
                h-100
              "
            >
              <div class="card-icon">
                <fa :icon="['fas', 'th-large']" class="fs-1 me-4" />
              </div>
              <div class="card-content">
                <h6 class="fw-bold mb-1">{{$t('main_categories')}}</h6>
                <p class="fw-bold text-primary fs-7 mb-0" v-for="(category,index) in vendor_category" :key="index">{{category.name}}</p>
              </div>
            </div>
          </div>
          <div class="col-md-4 mb-4 mb-md-0">
            <div
              class="
                d-flex
                align-items-center
                rounded
                shadow
                card-wrap
                ship-time
                h-100
              "
            >
              <div class="card-icon">
                <fa :icon="['fas', 'universal-access']" class="fs-1 me-4" />
              </div>
              <div class="card-content">
                <h6 class="fw-bold mb-1">{{$t('seller_rating')}}</h6>
                <div class="text-start">
                    <GlobalRating :rating="vendor.reviews_average_rating" />
                 </div>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div
              class="
                d-flex
                align-items-center
                rounded
                shadow
                card-wrap
                response
                h-100
              "
            >
              <div class="card-icon">
                <fa :icon="['fas', 'shipping-fast']" class="fs-1 me-4" />
              </div>
              <div class="card-content">
                <h6 class="fw-bold mb-1">{{$t('web.customer.featured_vendor_profile.order_completion')}}</h6>
                <div class="text-start">
                   <GlobalRating :rating="`${vendor.orders_average_rating}`" />
                 </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="rating-review-sec my-5" v-if="tab == 'reviews'">
      <div class="container">
        <div class="row">
          <div class="col-lg-4 mb-4 mb-lg-0">
            <div class="mb-3">
                <Template1VendorListCard :vendor="vendor"  />
            </div>
            <div class="card-wrap seller-rating rounded shadow">
              <h6 class="fw-bold mb-0"> {{$t('seller_rating')}}</h6>
              <p class="fs-1 text-primary fw-bold mb-0">{{ratings_count.avgRatings}}</p>
              <div
                class="
                  positive-rating
                  d-flex
                  justify-content-between
                  align-items-center
                "
              >
                <div class="fs-7" style="width:105px" for=""><fa v-for="index in 5" :key="index" :icon="['fas', 'star']" fixed-width class="text-warning"/></div>
                <div class="progress" style="height: 13px">
                  <div
                    class="progress-bar"
                    role="progressbar"
                    :style="'width:' +this.bindStar.five+'%'"
                    aria-valuenow="90"
                    aria-valuemin="0"
                    aria-valuemax="100"
                  ></div>
                </div>
                <span class="fs-7 opacity-7">{{ratings_count.fiveRatings}}</span>
              </div>
              <div
                class="
                  positive-rating
                  d-flex
                  justify-content-between
                  align-items-center
                "
              >
                <label class="fs-7 "  style="width:105px" for=""><fa v-for="index in 4" :key="index" :icon="['fas', 'star']" fixed-width class="text-warning"/></label>
                <div class="progress"  style="height: 13px">
                  <div
                    class="progress-bar"
                    role="progressbar"
                    :style="'width:' +this.bindStar.four+'%'"
                    aria-valuenow="25"
                    aria-valuemin="0"
                    aria-valuemax="100"
                  ></div>
                </div>
                <span class="fs-7 opacity-7">{{ratings_count.fourRatings}}</span>
              </div>
              <div
                class="
                  positive-rating
                  d-flex
                  justify-content-between
                  align-items-center
                "
              >
                <label class="fs-7 "  style="width:105px" for=""><fa v-for="index in 3" :key="index" :icon="['fas', 'star']" fixed-width class="text-warning"/></label>
                <div class="progress" style="height: 13px">
                  <div
                    class="progress-bar"
                    role="progressbar"
                   :style="'width:' +this.bindStar.three+'%'"
                    aria-valuenow="10"
                    aria-valuemin="0"
                    aria-valuemax="100"
                  ></div>
                </div>
                <span class="fs-7 opacity-7">{{ratings_count.threeRatings}}</span>
              </div>
                  <div
                class="
                  positive-rating
                  d-flex
                  justify-content-between
                  align-items-center
                "
              >
                <label class="fs-7"  style="width:105px" for=""><fa v-for="index in 2" :key="index" :icon="['fas', 'star']" fixed-width class="text-warning"/></label>
                <div class="progress" style="height: 13px">
                  <div
                    class="progress-bar"
                    role="progressbar"
                   :style="'width:' +this.bindStar.two+'%'"
                    aria-valuenow="10"
                    aria-valuemin="0"
                    aria-valuemax="100"
                  ></div>
                </div>
                <span class="fs-7 opacity-7">{{ratings_count.twoRatings}}</span>
              </div>
                  <div
                class="
                  positive-rating
                  d-flex
                  justify-content-between
                  align-items-center
                "
              >
                <label class="fs-7"  style="width:105px" for=""><fa v-for="index in 1" :key="index" :icon="['fas', 'star']" fixed-width class="text-warning"/></label>
                <div class="progress" style="height: 13px">
                  <div
                    class="progress-bar"
                    role="progressbar"
                   :style="'width:' +this.bindStar.one+'%'"
                    aria-valuenow="10"
                    aria-valuemin="0"
                    aria-valuemax="100"
                  ></div>
                </div>
                <span class="fs-7 opacity-7">{{ratings_count.oneRatings}}</span>
              </div>
              <p class="m-0 mt-3">
                {{$t('based_on')}} <span v-if="reviews.length>0">{{reviews.length}}</span> <span v-else>0</span> {{$t('customer_reviews')}}
              </p>
            </div>

          </div>

          <div class="col-lg-8">
            <div class="seller-rating-review">
              <h4 class="mb-4">
                {{$t('seller_ratings_and_reviews')}} <span v-if="reviews.length>0">({{reviews.length}})</span> <span v-else>(0)</span>
              </h4>
              <Component :is="`Website${currentlyActiveTemplate}ProductRatingReview`" :reviews="reviews" />

            </div>
          </div>
        </div>
      </div>
    </section>
    <section v-if="tab == 'products'" class="my-5">
        <div class="container">
        <div class="row review-gird">
         <WebsiteGlobalComponentsGrigListView
                :grid_class="grid_class"
                @changeGridClass="changeGridClass"
              />

                 <div :class="grid_class" v-for="product in vendorProducts" :key="product.id" >
                    <Component
                    :is="`${currentlyActiveTemplate}FeaturedProductCard`"
                    :grid_class="grid_class"
                    :product="product"
                    />
              </div>
        </div>
        </div>
    </section>
    <WebsiteTemplate1NewsLetterSection />
  </section>
</template>

<script>
import { mapGetters } from "vuex";

export default {
  auth: false,
  data() {
    return {
        currentlyActiveTemplate: "",
      key: 1,
      vendor: "",
      grid_class: "col-lg-2 last-col-2",
      vendor_category: "",
      vendorProducts:[],
      reviews: "",
      ratings_count:"",
      seo: {},
      tab: "reviews",
      bindStar: {
          five:'',
          four:'',
          three:'',
          two:'',
          one:''
      }
    };
  },
   created()
  {
    if (this.$route.query.type == "all-products") {
        this.tab = "products"
    }
    this.currentlyActiveTemplate = this.allSettings.general_settings.currently_active_theme
  },
  async fetch() {
    const { data } = await this.$webService.vendorReview(
      this.$route.params.slug
    );
    if (data) {
      this.vendor = data.vendor;
      this.reviews = data.reviews
      this.vendor_category = data.vendor_category
      this.ratings_count = data.ratings_count

         for (let index = 0; index < data.vendor.products.length; index++) {
            const element = data.vendor.products[index];
            if (element.variants.length == 0 && element.product_type == 2) {

            }
            else
            {
                this.vendorProducts.push(element);
            }
        }
       if(this.ratings_count.totalRatings > 0)
        {
            var five = (this.ratings_count.fiveRatings * 100)/ this.ratings_count.totalRatings;
            if (five == 0) {
            this.bindStar.five = 0;

            }
            else
            {

                this.bindStar.five = Math.round(100 - five);
            }
             var four = (this.ratings_count.fourRatings * 100)/ this.ratings_count.totalRatings;
             if (four == 0) {
            this.bindStar.four = 0;

            }
            else
            {

                this.bindStar.four = Math.round(100 - five);
            }
             var three = (this.ratings_count.threeRatings * 100)/ this.ratings_count.totalRatings;
             if (three == 0) {
            this.bindStar.three = 0;
            }
            else
            {

                this.bindStar.three = Math.round(100 - five);
            }
             var two = (this.ratings_count.twoRatings * 100)/ this.ratings_count.totalRatings;
             if (two == 0) {
            this.bindStar.two = 0;
            }
            else
            {

                this.bindStar.two = Math.round(100 - five);
            }
             var one = (this.ratings_count.oneRatings * 100)/ this.ratings_count.totalRatings;
             if (one == 0) {
            this.bindStar.one = 0;
            }
            else
            {

                this.bindStar.one = Math.round(100 - one);
            }
        }
    }
  },
  methods:{
     changeGridClass(grid_class) {
      this.grid_class = grid_class;
    },
  },
  computed: {
    ...mapGetters({
      allSettings: "allDefaultSettings",
    }),
  },
};
</script>

<style>
</style>
