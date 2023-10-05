<template>
  <div class="card border-1 bg-white overflow-hidden m-0 h-100 fadin" v-if="show">
                <span class="position-absolute rounded-0 badge-flash px-5 py-2">
                    <span class="fs-6 fw-normal"> {{ $t("flash_sale") }}</span>
                </span>
                <div class="row g-0">
                <div class="col-md-12 f-end">
                    <div class="w-100 text-center pt-4">
                    <img
                        v-if="image"
                        class="d-block mx-auto w-40 h-40"
                        :src="`/backend${image.thumbnails.medium.thumbnail}`"
                        :alt="image.alt_text"
                    />
                     <img
                        v-else
                        class="d-block mx-auto w-40"
                        src="~/assets/images/defult-product-img.png"
                        alt=""
                    />
                    </div>
                </div>
                <div class="col-md-12 text-center f-start">
                    <div class="card-body p-4 pb-0">
                        <h5 class="fw-bold text-capitalize mb-2">
                            <nuxt-link :to="`/product/${product.slug}`">
                                {{ product.name }}
                            </nuxt-link>
                        </h5>
                            <div
                            class=" d-flex align-items-center mb-1 justify-content-center"
                            v-if="product.categories.length > 0"
                            v-for="category in product.categories" :key="category.id"
                        >
                            <h6 class="text-dark-50">
                            {{category.name}}
                            </h6>
                            <span class="" v-if="category.childrens.length > 0">
                            ,
                            </span>
                        </div>
                        <div class="star-rating mb-2 justify-content-center d-flex">
                            <GlobalRating :rating="product.reviews_average_rating" class="fs-3" />
                        </div>
                         <div
                            class="product-price d-flex align-items-center justify-content-center mb-1"
                            v-if="product.flash_sale"
                        >
                            <span class="price fs-5 text-dark-50">
                            {{ product.flash_sale.display_price }}
                            </span>
                            <span class="actual-price fs-5 text-primary">
                            {{ product.display_price }}
                            </span>
                        </div>
                        <div
                            class="product-price d-flex align-items-center justify-content-center mb-1"
                            v-else-if="product.special_sale"
                        >
                            <span class="price fs-5 text-dark-50">
                            {{ product.special_sale.display_price }}
                            </span>
                            <span class="actual-price fs-5 text-primary">
                            {{ product.display_price }}
                            </span>
                        </div>
                        <div class="product-price d-flex align-items-center justify-content-center mb-1" v-else>
                            <span v-if="product.attributes.length > 0">
                            {{ $t("starting_from_price") }}
                            <span class="price" v-if="product.attributes.length > 0">
                            {{ product.starting_from_price }}
                            </span>
                        </span>
                        <span v-else>
                            <span class="price fs-5 text-dark-50">
                            {{ product.display_price }}
                            </span>
                        </span>
                        </div>
                    <client-only>
                        <countdown :time="time" @end="hideOnTimeCompleted" tag="div">
                        <template slot-scope="props">
                            <ul id="countdown" class="d-flex flex-row flex-row mt-3 justify-content-center">
                            <li>
                                <span id="days" class="text-primary fs-5">{{ props.days }}</span>
                                <div class="text-uppercase">{{ $t("days") }}</div>
                            </li>
                            <li>
                                <span id="hours" class="text-primary fs-5">{{ props.hours }}</span>
                                <div class="text-uppercase">{{ $t("hrs") }}</div>
                            </li>
                            <li>
                                <span id="minutes" class="text-primary fs-5">{{ props.minutes }}</span>
                                <div class="text-uppercase ">{{ $t("mins") }}</div>
                            </li>
                            <li>
                                <span id="seconds" class="text-primary fs-5">{{ props.seconds }}</span>
                                <div class="text-uppercase">{{ $t("secs") }}</div>
                            </li>
                            </ul>
                        </template>
                        </countdown>
                    </client-only>
                    </div>
                </div>
                <div class="col-lg-12 py-4 f-end mt-n3">
                        <div
                        class="sales-card-footer d-flex flex-row align-items-center justify-content-center"
                    >
                        <button
                        @click="addToCart()"
                        class="
                            btn btn-primary
                            text-white
                            rounded
                            cart-icon
                            fw-bold
                            d-flex
                            flex-row
                            align-items-center
                            list-icon-btn
                        "
                            :disabled="product.stock < product.min_order"
                        >
                        <!-- <fa :icon="['fas', 'shopping-bag']" class="me-2" /> -->
                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" width="23" height="23" x="0" y="0" viewBox="0 0 489 489" style="enable-background:new 0 0 512 512" xml:space="preserve" class="me-2"><g>
                        <g xmlns="http://www.w3.org/2000/svg">
                            <path d="M440.1,422.7l-28-315.3c-0.6-7-6.5-12.3-13.4-12.3h-57.6C340.3,42.5,297.3,0,244.5,0s-95.8,42.5-96.6,95.1H90.3   c-7,0-12.8,5.3-13.4,12.3l-28,315.3c0,0.4-0.1,0.8-0.1,1.2c0,35.9,32.9,65.1,73.4,65.1h244.6c40.5,0,73.4-29.2,73.4-65.1   C440.2,423.5,440.2,423.1,440.1,422.7z M244.5,27c37.9,0,68.8,30.4,69.6,68.1H174.9C175.7,57.4,206.6,27,244.5,27z M366.8,462   H122.2c-25.4,0-46-16.8-46.4-37.5l26.8-302.3h45.2v41c0,7.5,6,13.5,13.5,13.5s13.5-6,13.5-13.5v-41h139.3v41   c0,7.5,6,13.5,13.5,13.5s13.5-6,13.5-13.5v-41h45.2l26.9,302.3C412.8,445.2,392.1,462,366.8,462z" fill="currentColor" data-original="currentColor" class=""></path>
                        </g>
                        <g xmlns="http://www.w3.org/2000/svg">
                        </g>
                        <g xmlns="http://www.w3.org/2000/svg">
                        </g>
                        <g xmlns="http://www.w3.org/2000/svg">
                        </g>
                        <g xmlns="http://www.w3.org/2000/svg">
                        </g>
                        <g xmlns="http://www.w3.org/2000/svg">
                        </g>
                        <g xmlns="http://www.w3.org/2000/svg">
                        </g>
                        <g xmlns="http://www.w3.org/2000/svg">
                        </g>
                        <g xmlns="http://www.w3.org/2000/svg">
                        </g>
                        <g xmlns="http://www.w3.org/2000/svg">
                        </g>
                        <g xmlns="http://www.w3.org/2000/svg">
                        </g>
                        <g xmlns="http://www.w3.org/2000/svg">
                        </g>
                        <g xmlns="http://www.w3.org/2000/svg">
                        </g>
                        <g xmlns="http://www.w3.org/2000/svg">
                        </g>
                        <g xmlns="http://www.w3.org/2000/svg">
                        </g>
                        <g xmlns="http://www.w3.org/2000/svg">
                        </g>
                        </g>
                        </svg>
                        <b>{{ $t("add_to_cart") }}</b>
                        </button>
                        <span>
                        <a
                             href="#"
                            onclick="return false;"
                            @click="addToWishlist()"
                            v-tooltip="{ content: $t('add_to_wishlist') }"
                            class="mx-2 list-icon d-flex flex-row align-items-center btn bg-secondary">
                            <!-- <fa :class="product.is_wishlisted || wishlist ? 'text-danger' : ''" :icon="['fas', 'heart']" /> -->
                            <span class="list-icon" :class="product.is_wishlisted || wishlist ? 'text-danger' : ''">
                                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" width="23" height="23" x="0" y="0" viewBox="0 0 512.001 512" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g transform="matrix(1,0,0,1,0,30)"><path xmlns="http://www.w3.org/2000/svg" d="m256 455.515625c-7.289062 0-14.316406-2.640625-19.792969-7.4375-20.683593-18.085937-40.625-35.082031-58.21875-50.074219l-.089843-.078125c-51.582032-43.957031-96.125-81.917969-127.117188-119.3125-34.644531-41.804687-50.78125-81.441406-50.78125-124.742187 0-42.070313 14.425781-80.882813 40.617188-109.292969 26.503906-28.746094 62.871093-44.578125 102.414062-44.578125 29.554688 0 56.621094 9.34375 80.445312 27.769531 12.023438 9.300781 22.921876 20.683594 32.523438 33.960938 9.605469-13.277344 20.5-24.660157 32.527344-33.960938 23.824218-18.425781 50.890625-27.769531 80.445312-27.769531 39.539063 0 75.910156 15.832031 102.414063 44.578125 26.191406 28.410156 40.613281 67.222656 40.613281 109.292969 0 43.300781-16.132812 82.9375-50.777344 124.738281-30.992187 37.398437-75.53125 75.355469-127.105468 119.308594-17.625 15.015625-37.597657 32.039062-58.328126 50.167969-5.472656 4.789062-12.503906 7.429687-19.789062 7.429687zm-112.96875-425.523437c-31.066406 0-59.605469 12.398437-80.367188 34.914062-21.070312 22.855469-32.675781 54.449219-32.675781 88.964844 0 36.417968 13.535157 68.988281 43.882813 105.605468 29.332031 35.394532 72.960937 72.574219 123.476562 115.625l.09375.078126c17.660156 15.050781 37.679688 32.113281 58.515625 50.332031 20.960938-18.253907 41.011719-35.34375 58.707031-50.417969 50.511719-43.050781 94.136719-80.222656 123.46875-115.617188 30.34375-36.617187 43.878907-69.1875 43.878907-105.605468 0-34.515625-11.605469-66.109375-32.675781-88.964844-20.757813-22.515625-49.300782-34.914062-80.363282-34.914062-22.757812 0-43.652344 7.234374-62.101562 21.5-16.441406 12.71875-27.894532 28.796874-34.609375 40.046874-3.453125 5.785157-9.53125 9.238282-16.261719 9.238282s-12.808594-3.453125-16.261719-9.238282c-6.710937-11.25-18.164062-27.328124-34.609375-40.046874-18.449218-14.265626-39.34375-21.5-62.097656-21.5zm0 0" fill="currentColor" data-original="currentColor" class=""></path></g></svg>
                            </span>
                            </a>
                        </span>
                        <span>
                        <a
                             href="#"
                            onclick="return false;"
                            @click="addToComparelist()"
                            v-tooltip="{ content: $t('add_to_compare') }"
                            class="list-icon d-flex flex-row align-items-center btn bg-secondary"
                            >
                            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" width="26" height="26" x="0" y="0" viewBox="0 0 24 24" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path xmlns="http://www.w3.org/2000/svg" d="m21 7.5h-9.793l3.14649 3.14648a.5.5 0 1 1 -.707.707l-4-4a.49983.49983 0 0 1 0-.707l4-4a.5.5 0 0 1 .707.707l-3.14649 3.14652h9.793a.5.5 0 0 1 0 1zm-11.35352 13.85352a.49984.49984 0 0 0 .707 0l4-4a.49983.49983 0 0 0 0-.707l-4-4a.5.5 0 0 0 -.707.707l3.14652 3.14648h-9.793a.5.5 0 0 0 0 1h9.793l-3.14652 3.14648a.49983.49983 0 0 0 0 .70704z" fill="currentColor" data-original="currentColor" class=""></path></g></svg>
                            <!-- <fa :icon="['fas', 'exchange-alt']" /> -->
                            </a>
                        </span>
                    </div>
                    </div>
                </div>
            </div>
</template>
<style media="screen">
</style>
<script type="text/javascript">
import { mapGetters, mapActions } from "vuex";

export default {
  props: ["product"],
  data() {
    const now = new Date();
    const expireDate = new Date(this.product.flash_sale.expire_date);
    const showTime = expireDate - now;
    return {
      time: showTime,
      show: showTime > 0 ? true : false,
      wishlist: false,
    };
  },
  methods: {
    async addToCart() {
      if (this.product.is_available) {
        if (this.product.product_type == 2) {
          this.$router.push(`/product/${this.product.slug}`);
        } else {
          await this.$webService
            .addCartItem({ product_id: this.product.id, quantity: 1 })
            .then(async (res) => {
              if (res.success) {
                this.$toast.success(res.message);
                await this.fetchCartItems();
              } else {
                this.$toast.error(res.message);
              }
            });
        }
      } else {
        this.$toast.error("Product Not Available Yet");
      }
    },
    async addToWishlist() {
      if (this.$auth.loggedIn && this.$gates.hasRole("customer")) {
        await this.$webService
          .addWishlistItem({ product_id: this.product.id, quantity: 1 })
          .then(async (res) => {
            await this.fetchWishlistItems();
            if (res.success == false) {
              this.$toast.error(res.data.message);
            } else {
                this.wishlist = true;
              this.$toast.success(res.data.message);
            }
          });
      } else {
        this.$toast.error("Please Login First");
      }
    },
    async addToComparelist(){
        var get_compare_products = JSON.parse(localStorage.getItem('compare_products'));
        if(this.allCompareProducts && this.allCompareProducts.products.lngth != 0)
        {
             if(this.allCompareProducts.products.length == 3)
            {
                this.$toast.error(this.$t('compare_already_three_products_message'));
            }
            else if(get_compare_products.includes(this.product.id))
            {
                this.$toast.error(this.$t('compare_product_already_exist'));
            }
            else
            {
                get_compare_products.push(this.product.id);
                localStorage.setItem('compare_products', JSON.stringify(get_compare_products));
                this.$toast.success(this.$t('product_is_added_to_compare_list'));
                this.fetchCompareProducts({compare_ids:get_compare_products})
            }
        }
        else
        {
            var comp_products = [];
            comp_products.push(this.product.id);
            localStorage.setItem('compare_products', JSON.stringify(comp_products));
            this.fetchCompareProducts({compare_ids:comp_products})
          this.$toast.success(this.$t('product_is_added_to_compare_list'));
        }

    },
    ...mapActions({
      fetchCartItems: "Web/Cart/fetchCartItems",
      fetchWishlistItems: "Web/Wishlist/fetchWishlistItems",
       fetchCompareProducts: "Web/General/fetchCompareProducts",

    }),
    hideOnTimeCompleted() {
      this.show = false;
    },
  },
  computed: {
        ...mapGetters({
      allCompareProducts: "Web/General/allCompareProducts",
    }),
    image() {
      if (this.product.media) {
        const image = this.product.media.find(
          (single) => single.type == "image"
        );
        if (image) {
          return image;
        } else {
          return null;
        }
      } else {
        return null;
      }
    },
  },
};
</script>
