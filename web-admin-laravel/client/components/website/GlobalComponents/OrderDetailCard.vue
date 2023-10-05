<template>
  <div class="table-responsive bg-secondary mx-0">
    <div class="row w-100">
      <table class="table m-0">
        <tr class="d-block py-2 px-1">
          <td>
            <div class="d-flex align-items-center">
              <img
                class="orderTableImg"
                v-if="
                  product.product.media &&
                  product.product.media[0] &&
                  product.product.media[0].thumbnails &&
                  product.product.media[0].thumbnails.small
                "
                v-bind:src="
                  url + `${product.product.media[0].thumbnails.small.thumbnail}`
                "
                alt="..."
              />
              <img
              v-else
              src="~/assets/images/defult-product-img.png"
              alt="Product Image"
              class="img-fluid"
            />
              <div v-if="product.product.name" class="ps-3">
                <h3 class="fw-bold text-capitalize orderTitle my-1">
                  {{ product.product.name }}
                </h3>
                <p class="text_size orderDescription text-justify fw-bold m-0">
                  {{ product.product.short_description }}
                </p>
                <p
                  class="text_size orderDescription text-justify fw-bold m-0"
                  v-if="product.order_product_variant_details"
                  v-for="variant in product.order_product_variant_details" :key="variant.id"
                >
                  {{ variant.attribute_name }} : {{ variant.value_name }}
                </p>
              </div>
            </div>
          </td>
          <td>
            <div class="d-flex justify-content-center align-items-center h-100">
              <span class="text-muted fw-bold letter_spacing"
                >QTY:
                <span v-if="product.quantity">
                  {{ product.quantity }}
                </span></span
              >
            </div>
          </td>
          <td>
            <div
              class="d-flex justify-content-center align-items-center h-100"
              v-if="product.sale_type != null"
            >
              <div class="text-primary fw-bold letter_spacing">
                {{
                  product.current_product_order_time_total_sale_display_price
                }}
                <span class="text-danger text-decoration-line-through">
                      {{ product.current_product_order_time_total_display_price }}
                </span>
              </div>
            </div>
            <div
              v-else
              class="d-flex justify-content-center align-items-center h-100"
            >
              <div class="text-primary fw-bold letter_spacing">
                {{ product.current_product_order_time_total_display_price }}
              </div>
            </div>
          </td>
          <td>
            <div class="d-flex justify-content-center align-items-center h-100">
              <span class="text-muted fw-bold letter_spacing">
                {{ detail.payment_method.name }}
              </span>
            </div>
          </td>
          <td
            v-if="
              allSettings &&
              allSettings.general_settings &&
              allSettings.general_settings.is_multi_vendor &&
              allSettings.general_settings.is_multi_vendor == 1 &&
              product.product.vendor &&
              product.product.vendor.store
            "
          >
            <div
              class="
                d-flex
                justify-content-start
                align-items-center
                h-100
                fw-bold
                text-size
              "
            >
              <span class="text-dark">By: &nbsp;</span>
              <nuxt-link
                :to="`/store/${product.product.vendor.store.slug}`"
                class="text-primary primary_border text-uppercase"
              >
                {{ product.product.vendor.store.name }}</nuxt-link
              >
            </div>
          </td>
          <td v-if="detail.order_status.status_code == 6 || detail.order_status.status_code == 7 ">
            <div class="d-flex justify-content-center align-items-center h-100" v-if="!review_created">
              <nuxt-link
                to=""
                class="mb-0 me-4 text-dark d-flex align-items-center"
                data-bs-toggle="modal"
                :data-bs-target="`#ratingModal${product.product.id}`"
              >
                <fa
                  :icon="['fas', 'smile']"
                  class="me-2 text-primary fs-5"
                  fixed-width
                />
                <span class="text_size fw-bold lh-base dark_border"
                  >Write a review</span
                ></nuxt-link
              >
            </div>
            <div v-else>
                <div v-for="review in product.product.reviews" :key="review.id">
                    <div v-if="product.product.id == review.product.id && product.id == review.order_id && $auth.user.id == review.customer_id">
                        <div class="star-rating mb-1">
                            <GlobalRating :rating="review.rating" />
                        </div>
                    </div>

                </div>
                <div v-if="runTimeReview">
                         <div class="star-rating mb-1">
                            <GlobalRating :rating="runTimeReviewCount" />
                        </div>
                    </div>
            </div>

          </td>
        </tr>
      </table>
    </div>
    <!-- Rating Model -->
    <div
      class="modal fade"
      :id="`ratingModal${product.product.id}`"
      tabindex="-1"
      role="dialog"
      aria-labelledby="ratingModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content rounded-2">
          <div class="modal-header">
            <h5 class="modal-title" id="ratingModalLabel">{{$t('rate_now')}}</h5>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="exampleFormControlSelect1">{{$t('select_rating')}}</label>
                <StarsRatings :increment="0.5"  @rating-selected ="setRating"></StarsRatings>
            </div>
            <div class="form-group">
              <label for="review_message"> {{$t('comment')}}</label>
              <textarea
                class="form-control rounded-1 mt-1"
                v-model="ratings.comment"
                id="review_message"
                rows="3"
              ></textarea>
            </div>
            <div class="form-group mt-4">
              <label for="review_message"> {{$t('images')}}:</label>
                <input
                          type="file"
                          id="images"
                          ref="images"
                          @change="processFile($event)"
                          multiple
                        />
            </div>
          </div>
          <div class="modal-footer pt-0">
            <button
              type="button"
              class="btn btn-secondary"
              data-bs-dismiss="modal"
            >
              {{$t('web.customer.wallet.close')}}
            </button>
            <button
              type="button"
              id="submit_data"
              v-on:click="submitRating(product.product.id)"
              class="btn btn-primary"
            >
                {{$t('web.customer.wallet.submit')}}
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<style media="screen">
</style>
<script type="text/javascript">
import { mapGetters } from "vuex";
import axios from 'axios';

export default {
  props: ["vendor", "detail", "product"],
  data() {
    return {
      url: "/backend",
      ratings: {
        rate: "",
        comment: "",
        images:""
      },

    rating: "",
    review_created: false,
    runTimeReview: false,
    runTimeReviewCount:"",
    currentRating: "No Rating",
    currentSelectedRating: "",
    boundRating: 3,
    selectedProductId: "",

      ratingLoader: false,
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
mounted()
{
    for (let index = 0; index < this.product.product.reviews.length; index++) {
        const review = this.product.product.reviews[index];
        if (this.product.product.id == review.product.id && this.product.id == review.order_id && this.$auth.user.id == review.customer_id) {
           this.review_created = true
        }
    }
},
  methods: {
    async submitRating(model_id) {
      if (!this.ratings.rate || !this.ratings.comment) {
        this.$toast.error("Rating and Comment Fields are Required");
      } else {
 const headers = {
        "Content-Type": "multipart/form-data",
        "Authorization": this.$axios.defaults.headers.common.Authorization
      };
        var data = {
          description: this.ratings.comment,
          rating: this.ratings.rate,
          product_id: this.selectedProductId,
          customer_id: this.$auth.user.id,
          order_id: this.detail.id,
          images:this.ratings.images
        };

        let formData = new FormData();
        for (let index = 0; index < this.ratings.images.length; index++) {
            const element = this.ratings.images[index];
            formData.append("images[]", element);
        }

      formData.append("description", this.ratings.comment);
      formData.append("rating", this.ratings.rate);
      formData.append("product_id", this.selectedProductId);
      formData.append("customer_id", this.$auth.user.id);
      formData.append("order_id", this.detail.id);
      const res = await axios
        .post("/backend/api/web/add_product_review", formData, {
          headers: headers,
        })
        .then((res) => {
             this.review_created = true;
             this.runTimeReview = true;
             this.runTimeReviewCount = res.data.data.rating;
            this.ratingLoader = false;
            this.$toast.success(res.message);
            $("#ratingModal"+model_id).modal("hide");
            this.rating = "";
            this.ratings.rate = "";
             this.currentSelectedRating = "";
            this.ratings.comment = "";
        })
         .catch(async (res) => {
            this.ratingLoader = false;
            this.$toast.error("Please add image Minimum 1 and Max 3");
          });
      }
    },


     setRating: function(rating) {
         this.selectedProductId = this.product.product.id
         this.ratings.rate = rating;
    },
    showCurrentRating: function(rating) {
      this.currentRating = (rating === 0) ? this.currentSelectedRating : "Click to select " + rating + " stars"
    },
    setCurrentSelectedRating: function(rating) {
      this.currentSelectedRating = rating ;
    },
    processFile(event) {
        this.ratings.images = event.target.files;
    },

  },
  computed: {
    cover_image() {
      if (this.vendor && this.vendor.store && this.vendor.store.cover_image) {
        return this.vendor.store.cover_image;
      } else {
        return null;
      }
    },
    ...mapGetters({
      allSettings: "allDefaultSettings",
    }),
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
<style lang="scss" scoped>
.rating {
  display: flex;
  flex-direction: row-reverse;
  justify-content: center;
}

.rating > input {
  display: none;
}

.rating > label {
  position: relative;
  width: 1em;
  font-size: 4vw;
  color: #ffd600;
  cursor: pointer;
}

.rating > label::before {
  content: "\2605";
  position: absolute;
  opacity: 0;
}

.rating > label:hover:before,
.rating > label:hover ~ label:before {
  opacity: 1 !important;
}

.rating > input:checked ~ label:before {
  opacity: 1;
}

.rating:hover > input:checked ~ label:before {
  opacity: 0.4;
}

@media only screen and (max-width: 600px) {
}
</style>
