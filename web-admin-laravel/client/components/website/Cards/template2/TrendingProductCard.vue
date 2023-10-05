<template>
   <div
                    class="
                      card
                      m-0
                      mt-4
                      pt-4
                      bg-light
                      flex-lg-row
                      border-0
                      flex-md-column
                      justify-content-between
                    "
                  >
                    <div
                      class="p-0 bg-light rounded-1 position-relative image-sec"
                    >

                       <img v-if="product.media.length>0"
                         :src="`/backend${product.media[0].thumbnails.large.thumbnail}`"
                        class="w-100 rounded-2"
                        alt=""
                      />
                      <img
                      v-else
                        src="~/assets/images/defult-product-img.png"
                        class="w-100 rounded-2"
                        alt=""
                      />
                          <div v-if="product.tags && product.tags.length > 0" class="d-flex flex-column justify-content-end align-items-end position-absolute badge-custom">
                    <span v-for="(tag,index) in product.tags" :key="index" class="d-block">
                        <span class="badge me-1 bg-danger py-1 px-2" v-if="tag == 'Sale'">
                            {{$t('web.home.new_arrival_products.sale')}}
                        </span>
                        <span class="badge me-1 bg-primary py-1 px-2 position-relative text-uppercase" v-if="tag == 'Featured'">
                           {{$t('web.home.new_arrival_products.featured')}}
                        </span>
                        <span class="badge me-1 bg-success py-1 px-2 position-relative text-uppercase" v-if="tag == 'New'">
                             {{$t('web.home.new_arrival_products.new')}}
                        </span>
                    </span>
                </div>
                    </div>
                    <div class="text-section px-3 d-flex flex-column justify-content-between">
                      <h3>
                         <nuxt-link :to="`/product/${product.slug}`" class="fs-5 fw-bold">{{product.name}}</nuxt-link>
                      </h3>
                          <span v-if="product.categories && product.categories.length > 0">
                        <h4 class="fs-6 text-dark-50" v-for="(category,index) in product.categories" :key="index">{{category.name}}</h4>
                    </span>
                      <div class="rating mb-2">
                      <GlobalRating :rating="product.reviews_average_rating" />
                      </div>
                          <span class="w-100 d-block mb-0 text-dark-50" v-if="product.flash_sale">{{product.display_price}}<small class="text-danger"> {{product.flash_sale.display_price}}</small></span>
                <span class="w-100 d-block mb-0 text-dark-50" v-else-if="product.special_sale">{{product.display_price}}<small class="text-danger"> {{product.special_sale.display_price}}</small></span>
                <!-- <span class="w-100 d-block mb-3 text-dark-50" v-else>{{product.display_price}}<small class="text-danger"> {{product.special_sale.display_price}}</small></span> -->
                    <span class="product-price d-flex align-items-center mb-1" v-else>
                    <span v-if="product.attributes &&  product.attributes.length > 0">
                        {{ $t("starting_from_price") }}
                    <span class="w-100  mb-3 text-dark-50" v-if="product.attributes &&  product.attributes.length > 0">
                    {{ product.starting_from_price }}
                    </span>
                 </span>
                <span v-else>
                    <span class="w-100 d-block mb-0 text-dark-50">
                    {{ product.display_price }}
                    </span>
                </span>
                    </span>
                      <div class="d-flex align-items-center mt-auto pb-2">
                        <button type="button" @click="addToCart(product)"  class="btn btn-primary border-0 text-uppercase">
                           {{$t('web.home.new_arrival_products.add_to_cart')}}
                        </button>
                        <span>
                            <a href="#"
                            onclick="return false;"
                            @click="addToWishlist()"
                            v-tooltip="{ content: $t('add_to_wishlist') }"
                            class="mx-2 list-icon">
                            <!-- <fa :class="product.is_wishlisted || wishlist ? 'text-danger' : ''" :icon="['fas', 'heart']" /> -->
                            <span class="list-icon" :class="product.is_wishlisted || wishlist ? 'text-danger' : ''">
                                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" width="23" height="23" x="0" y="0" viewBox="0 0 512.001 512" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g transform="matrix(1,0,0,1,0,30)"><path xmlns="http://www.w3.org/2000/svg" d="m256 455.515625c-7.289062 0-14.316406-2.640625-19.792969-7.4375-20.683593-18.085937-40.625-35.082031-58.21875-50.074219l-.089843-.078125c-51.582032-43.957031-96.125-81.917969-127.117188-119.3125-34.644531-41.804687-50.78125-81.441406-50.78125-124.742187 0-42.070313 14.425781-80.882813 40.617188-109.292969 26.503906-28.746094 62.871093-44.578125 102.414062-44.578125 29.554688 0 56.621094 9.34375 80.445312 27.769531 12.023438 9.300781 22.921876 20.683594 32.523438 33.960938 9.605469-13.277344 20.5-24.660157 32.527344-33.960938 23.824218-18.425781 50.890625-27.769531 80.445312-27.769531 39.539063 0 75.910156 15.832031 102.414063 44.578125 26.191406 28.410156 40.613281 67.222656 40.613281 109.292969 0 43.300781-16.132812 82.9375-50.777344 124.738281-30.992187 37.398437-75.53125 75.355469-127.105468 119.308594-17.625 15.015625-37.597657 32.039062-58.328126 50.167969-5.472656 4.789062-12.503906 7.429687-19.789062 7.429687zm-112.96875-425.523437c-31.066406 0-59.605469 12.398437-80.367188 34.914062-21.070312 22.855469-32.675781 54.449219-32.675781 88.964844 0 36.417968 13.535157 68.988281 43.882813 105.605468 29.332031 35.394532 72.960937 72.574219 123.476562 115.625l.09375.078126c17.660156 15.050781 37.679688 32.113281 58.515625 50.332031 20.960938-18.253907 41.011719-35.34375 58.707031-50.417969 50.511719-43.050781 94.136719-80.222656 123.46875-115.617188 30.34375-36.617187 43.878907-69.1875 43.878907-105.605468 0-34.515625-11.605469-66.109375-32.675781-88.964844-20.757813-22.515625-49.300782-34.914062-80.363282-34.914062-22.757812 0-43.652344 7.234374-62.101562 21.5-16.441406 12.71875-27.894532 28.796874-34.609375 40.046874-3.453125 5.785157-9.53125 9.238282-16.261719 9.238282s-12.808594-3.453125-16.261719-9.238282c-6.710937-11.25-18.164062-27.328124-34.609375-40.046874-18.449218-14.265626-39.34375-21.5-62.097656-21.5zm0 0" fill="currentColor" data-original="currentColor" class=""></path></g></svg>
                            </span>
                            </a>
                        </span>
                      </div>
                    </div>
                  </div>
</template>
<style media="screen">
</style>
<script type="text/javascript">
import { mapGetters, mapActions } from "vuex";
export default {
  props: {
    product: {
      required: true,
    },
  },
  data() {
    return {
         wishlist : false
    };
  },
  methods: {
    ...mapActions({
      fetchCartItems: "Web/Cart/fetchCartItems",
       fetchWishlistItems: 'Web/Wishlist/fetchWishlistItems'
    }),
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
        this.$toast.error(this.$t("product_not_available"));
      }
    },
            async addToWishlist(){
        if(this.$auth.loggedIn && this.$gates.hasRole('customer') )
        {
        await this.$webService.addWishlistItem({product_id:this.product.id,quantity: 1}).then(async (res) => {
            await this.fetchWishlistItems()
            if(res.success == false)
            {
            this.$toast.error(res.data.message);
            }
            else
            {
                this.wishlist = true;
                this.$toast.success(res.data.message);
            }
        });
        }
        else
        {
            this.$toast.error(this.$t('please_login_first'));
        }
    },
  },
  computed: {
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
