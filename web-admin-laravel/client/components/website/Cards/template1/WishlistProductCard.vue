<template>
  <div
    class="card bg-white featured-items-card"
    :class="small ? 'featured-small' : ''"
  >
    <div class="img-wrap rounded">
      <img
        class="rounded-top"
        v-if="image"
        :src="`/backend${image.thumbnails.medium.thumbnail}`"
        :alt="image.alt_text"
      />
      <img
        class="rounded-top"
        v-else
        src="~/assets/images/defult-product-img.png"
        alt=""
      />
      <span
        v-for="(tag, index) in product.tags"
        class="badge"
        :key="tag"
        :class="index % 2 == 0 ? 'bg-primary' : 'bg-danger'"
        >{{ tag }} </span
      >
      <div class="icon-wrap d-flex flex-column">
        <i onclick="return false;" @click="addToWishlist()" v-tooltip="{ content: $t('add_to_wishlist') }" class="icon-cont"
          ><fa :icon="['fas', 'heart']" :class="product.is_wishlisted || wishlist ? 'text-danger' : ''"
        /></i>
        <i onclick="return false;" @click="addToComparelist()"  v-tooltip="{ content: $t('add_to_compare') }" class="icon-cont"
          ><fa :icon="['fas', 'exchange-alt']"
        /></i>
        <WebsiteGlobalComponentsShareIconPopup />
      </div>
      <a
        href="#"
        class="hov-wrap d-flex justify-content-center"
        data-bs-toggle="modal"
        :data-bs-target="`#${modal_id}`"
        @click="detailModalProductChanged(product)"
      >
        <fa :icon="['fas', 'search']" class="me-1 mt-1" />
        {{ this.$t("web.home.quick_view") }}
      </a>
    </div>
    <div class="card-body text-start">
      <div class="star-rating mb-1">
        <GlobalRating :rating="product.reviews_average_rating" />
      </div>
      <h6 class="fw-bold mb-1">
        <nuxt-link :to="`/product/${product.slug}`">
          {{ product.name }}
        </nuxt-link>
      </h6>
      <p class="prod-detail" v-if="grid_class == 'col-12'">
        {{ product.description }}
      </p>
      <div
        class="
          price-icon
          d-flex
          flex-row
          justify-content-between
          align-items-center
        "
      >
        <div
          class="product-price d-flex align-items-start flex-column-reverse w-75"
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
          class="product-price d-flex align-items-start flex-column w-75"
          v-else-if="product.special_sale"
        >
          <span class="price">
            {{ product.special_sale.display_price }}
          </span>
          <br>
          <span class="actual-price">
            {{ product.display_price }}
          </span>
        </div>
        <div class="product-price d-flex align-items-start w-75" v-else>
          <span v-if="product.attributes && product.attributes.length > 0">
                {{ $t("starting_from_price") }}
                <span class="price" v-if="product.attributes && product.attributes.length > 0">
                  {{ product.starting_from_price }}
                </span>
              </span>
              <span v-else>
                <span class="price">
                  {{ product.display_price }}
                </span>
              </span>
        </div>
        <button
          v-if="product.product_type == 2"
           v-tooltip="{ content: $t('add_to_cart') }"
          @click="$router.push(`/product/${product.slug}`)"
          class="
            btn btn-primary
            text-white
            text-center
            rounded
            fw-bold
            d-flex
            flex-row
            align-items-center
            justify-content-center
            fs-7
            py-1
          "
        >
          <fa :icon="['fas', 'shopping-bag']" class="fs-6" />
          <!-- {{
            $t("view")
          }} -->
        </button>
        <button
          v-else
          @click="addToCart()"
          v-tooltip="{ content: $t('add_to_cart') }"
          class="
            btn btn-primary
            text-white
            text-center
            rounded
            fw-bold
            d-flex
            flex-row
            align-items-center
            justify-content-center
            fs-7
            py-1
          "
        >
          <fa :icon="['fas', 'shopping-bag']" class="fs-6" />
          <!-- {{
            $t("cart")
          }} -->
        </button>
        <button
          @click="removeItemFromWishlist()"
           v-tooltip="{ content: $t('remove') }"
          class="
            btn btn-danger
            text-white
            text-center
            rounded
            fw-bold
            d-flex
            align-items-center
            justify-content-center
            ms-1
            py-1
            fs-7
          "
        >
        <fa :icon="['fas', 'trash']" class="fs-6" />
          <!-- {{ $t("remove") }} -->
        </button>
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
    modal_id: {
      required: false,
      default: "product_detail_quickview",
    },
    small: {
      default: false,
      required: false,
      type: Boolean,
    },
    grid_class: {
      default: "",
      required: false,
    },
  },
  data() {
    return {
        wishlist : false,
    };
  },
  methods: {
    ...mapActions({
      fetchCartItems: "Web/Cart/fetchCartItems",
      fetchWishlistItems: "Web/Wishlist/fetchWishlistItems",
      fetchCompareProducts: "Web/General/fetchCompareProducts",
    }),
    detailModalProductChanged(product) {
      this.$root.$emit("detailModalProductChanged", product);
    },
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
    async addToComparelist() {
      var get_compare_products = JSON.parse(
        localStorage.getItem("compare_products")
      );
      if (
        this.allCompareProducts &&
        this.allCompareProducts.products.lngth != 0
      ) {
        if (this.allCompareProducts.products.length == 3) {
          this.$toast.error(this.$t("compare_already_three_products_message"));
        } else if (get_compare_products.includes(this.product.id)) {
          this.$toast.error(this.$t("compare_product_already_exist"));
        } else {
          get_compare_products.push(this.product.id);
          localStorage.setItem(
            "compare_products",
            JSON.stringify(get_compare_products)
          );
          this.$toast.success(this.$t("product_is_added_to_compare_list"));
          this.fetchCompareProducts({ compare_ids: get_compare_products });
        }
      } else {
        var comp_products = [];
        comp_products.push(this.product.id);
        localStorage.setItem("compare_products", JSON.stringify(comp_products));
        this.fetchCompareProducts({ compare_ids: comp_products });
        this.$toast.success(this.$t("product_is_added_to_compare_list"));
      }
    },
    async addToWishlist() {
      if (
        this.$auth.loggedIn &&
        this.$gates.hasRole('customer')
      ) {
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
        this.$toast.error(this.$t("please_login_first"));
      }
    },
   async removeItemFromWishlist()
    {
      if (
        this.$auth.loggedIn &&
        this.$gates.hasRole('customer')
      ) {
        await this.$webService
          .deleteWishlistItem({ product_id: this.product.id})
          .then(async (res) => {
            // await this.fetchWishlistItems();
            this.$emit('removeWishlistItem');
            //  this.$store.commit('Web/General/updateCompareProducts', null)
            if (res.success == false) {
              this.$toast.error(res.data.message);
            } else {
              this.$toast.success(res.data.message);
            }
          });
      } else {
        this.$toast.error(this.$t("please_login_first"));
      }
    }
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
    ...mapGetters({
      allCompareProducts: "Web/General/allCompareProducts",
    }),
  },
};
</script>
