<template>
  <div class="card border-0 overflow-hidden" v-if="show">
    <div class="row g-0">
      <div class="col-md-6 overflow-hidden rounded">
        <div class="img-wrap rounded-start custom-imgs">
          <img
            v-if="image"
            class="d-block rounded w-100 h-100"
            :src="`/backend${image.thumbnails.medium.thumbnail}`"
            :alt="image.alt_text"
          />
          <img
            v-else
            class="d-block rounded w-100 h-100"
            src="~/assets/images/defult-product-img.png"
            alt=""
          />
        </div>
      </div>
      <div class="col-md-6 d-flex flex-row align-items-center">
        <div class="card-body p-4 h-100 d-flex flex-column justify-content-between">
          <div class="star-rating mb-2">
            <GlobalRating :rating="product.reviews_average_rating" />
          </div>
          <h6 class="fw-bold">
            <nuxt-link :to="`/product/${product.slug}`">
              {{ product.name }}
            </nuxt-link>
          </h6>
          <div
            class=" d-flex align-items-center mb-1"
            v-if="product.categories.length > 0"
            v-for="category in product.categories" :key="category.id"
          >
            <span class="">
              {{category.name}}
            </span>
             <span class="" v-if="category.childrens.length > 0">
               ,
            </span>
          </div>
            <div
            class="product-price d-flex align-items-center mb-1"
            v-if="product.flash_sale"
          >
            <span class="price">
              {{ product.flash_sale.display_price }}
            </span>
            <span class="actual-price">
              {{ product.display_price }}
            </span>
          </div>
          <div
            class="product-price d-flex align-items-center mb-1"
            v-else-if="product.special_sale"
          >
            <span class="price">
              {{ product.special_sale.display_price }}
            </span>
            <span class="actual-price">
              {{ product.display_price }}
            </span>
          </div>
          <div class="product-price d-flex align-items-center mb-1" v-else>
            <span v-if="product.attributes.length > 0">
            {{ $t("starting_from_price") }}
            <span class="price" v-if="product.attributes.length > 0">
              {{ product.starting_from_price }}
            </span>
          </span>
          <span v-else>
            <span class="price">
              {{ product.display_price }}
            </span>
          </span>
          </div>
          <client-only>
            <countdown :time="time" @end="hideOnTimeCompleted" tag="div">
              <template slot-scope="props">
                <ul id="countdown" class="d-flex flex-row flex-row mt-3">
                  <li>
                    <span id="days">{{ props.days }}</span>
                    <div>{{ $t("days") }}</div>
                  </li>
                  <li>
                    <span id="hours">{{ props.hours }}</span>
                    <div>{{ $t("hours") }}</div>
                  </li>
                  <li>
                    <span id="minutes">{{ props.minutes }}</span>
                    <div>{{ $t("minutes") }}</div>
                  </li>
                  <li>
                    <span id="seconds">{{ props.seconds }}</span>
                    <div>{{ $t("seconds") }}</div>
                  </li>
                </ul>
              </template>
            </countdown>
          </client-only>
          <div
            class="sales-card-footer d-flex flex-row align-items-center mt-3"
          >
            <button
              @click="addToCart()"
              class="
                bg-transparent
                border-0
                text-body
                rounded
                fw-bold
                d-flex
                flex-row
                align-items-center
              "
            >
              <fa v-tooltip="{ content: $t('add_to_cart') }" :icon="['fas', 'shopping-bag']" class="me-2 fs-4" />
              <!-- {{ $t("add_to_cart") }} -->
            </button>
            <span>
              <a
                href="#"
                onclick="return false;"
                @click="addToWishlist()"
                v-tooltip="{ content: $t('add_to_wishlist') }"
                class="mx-2 list-icon d-flex flex-row align-items-center"
                ><fa :icon="['fas', 'heart']" :class="product.is_wishlisted || wishlist ? 'text-danger' : ''"
              /></a>
            </span>
               <span>
              <a
                href="#"
                onclick="return false;"
                @click="addToComparelist()"
                 v-tooltip="{ content: $t('add_to_compare') }"
                class="mx-2 list-icon d-flex flex-row align-items-center"
                ><fa :icon="['fas', 'exchange-alt']"
              /></a>
            </span>
          </div>
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
