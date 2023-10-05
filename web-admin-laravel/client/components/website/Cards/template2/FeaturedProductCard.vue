<template>
  <div
    class="card bg-white featured-items-card p-0 border-0 shadow-none product-hover rounded-0 bg-transparent mt-0"
    :class="small ? 'featured-small' : ''"
  >
        <div class="img-wrap bg-secondary hover-img">
            <img
                class="border-2"
                v-if="image"
                :src="`/backend${image.thumbnails.large.thumbnail}`"
                :alt="image.alt_text"
            />
            <img
                class="border-2"
                v-else
                src="~/assets/images/defult-product-img.png"
                alt=""
            />
            <span
                v-for="(tag, index) in product.tags"
                class="badge"
                :key="tag"
                :class="index % 2 == 0 ? 'bg-primary' : 'bg-danger'"
                >{{ tag }}</span
            >
            <div class="popup-product bg-white rounded-1 p-2">
            <div class="img-wrap bg-secondary">
                <img
                    class="border-2"
                    v-if="image"
                    :src="`/backend${image.thumbnails.large.thumbnail}`"
                    :alt="image.alt_text"
                />
                <img
                    class="border-2"
                    v-else
                    src="~/assets/images/defult-product-img.png"
                    alt=""
                />
                <span
                    v-for="(tag, index) in product.tags"
                    class="badge"
                    :key="tag"
                    :class="index % 2 == 0 ? 'bg-primary' : 'bg-danger'"
                    >{{ tag }}</span
                >
            </div>
            <div class="card-body text-center py-0 px-4">
            <div
                class="
                price-icon
                d-flex
                flex-row
                justify-content-center
                align-items-start flex-column h-100
                "
            >
                <div class="w-100 border-bottom mb-3 pb-3">
                    <h6 class="fw-bold mb-1 text-start">
                        <nuxt-link :to="`/product/${product.slug}`">
                        {{ product.name }}
                        </nuxt-link>
                    </h6>
                    <div
                    class="product-price d-flex align-items-center"
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
                    class="product-price d-flex align-items-center"
                    v-else-if="product.special_sale"
                    >
                    <span class="price">
                        {{ product.special_sale.display_price }}
                    </span>
                    <span class="actual-price">
                        {{ product.display_price }}
                    </span>
                    </div>
                        <div class="product-price d-flex align-items-center" v-else>
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
                </div>

                <!-- <div class="veriant w-100" v-if="product.attributes && product.attributes.length > 0">
                    <span v-for="attribute in product.attributes" :key="attribute.id">
                        <label class="w-100 fs-6 fw-bold text-start">{{attribute.name}}:</label>
                            <ul>
                                <li class="d-flex flex-wrap"><a href="javascript:void(0)" class="mb-1 me-1" v-for="value in attribute.values" :key="value">{{value.name}}</a></li>
                            </ul>
                    </span>
                </div>
                <div v-else>
                    <div v-html="product.short_description_web" class="w-100 fs-6 fw-normal text-start detail-section"></div>
                </div> -->
                <div class="w-100 mt-auto pb-4">
                <button
                v-if="product.product_type == 2"
                @click="$router.push(`/product/${product.slug}`)"
                class="
                    btn bg-black
                    text-white
                    rounded-0
                    fw-bold
                    fs-7
                    py-1
                    w-100
                "
                >
                {{
                    $t("view")
                }}
                </button>
                <button
                v-else
                @click="addToCart()"
                :disabled="product.stock < product.min_order"
                class="
                    btn bg-black
                    text-white
                    rounded-0
                    fw-bold
                    fs-7
                    py-1
                    w-100
                "
                >
                {{
                    $t("Add to Cart")
                }}
                </button>
                <nuxt-link :to="`/product/${product.slug}`" class="btn bg-black
                    text-white
                    rounded-0
                    fw-bold
                    fs-7
                    py-1
                    w-100
                    mt-2">
                        {{ "Go to Product" }}
                </nuxt-link>
                </div>
            </div>
            </div>
            </div>
        </div>
        <div class="card-body text-start py-2 px-0 d-flex flex-column justify-content-start align-items-start">
         <h6 class="fw-bold mb-1 mt-2">
            <nuxt-link :to="`/product/${product.slug}`">
            {{ product.name }}
            </nuxt-link>
        </h6>
        <div class="star-rating mb-1">
            <GlobalRating :rating="product.reviews_average_rating" />
        </div>
        <p class="prod-detail" v-if="grid_class == 'col-12'">
            {{ product.description }}
        </p>
        <div
            class="
            price-icon
            d-flex
            flex-row
            justify-content-center
            align-items-center
            "
        >
            <div
            class="product-price d-flex align-items-center"
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
            class="product-price d-flex align-items-center"
            v-else-if="product.special_sale"
            >
            <span class="price">
                {{ product.special_sale.display_price }}
            </span>
            <span class="actual-price">
                {{ product.display_price }}
            </span>
            </div>
            <div class="product-price d-flex align-items-center" v-else>
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
        this.allCompareProducts.products.length != 0
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
      if (this.$auth.loggedIn && this.$gates.hasRole("customer")) {
        await this.$webService
          .addWishlistItem({ product_id: this.product.id, quantity: 1 })
          .then(async (res) => {
              await this.fetchWishlistItems()
            if (res.success == false) {
              this.$toast.error(res.data.message);
            }
            else {
                this.wishlist = true;
              this.$toast.success(res.data.message);
            }
          });
      } else {
        this.$toast.error(this.$t("please_login_first"));
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
    ...mapGetters({
      allCompareProducts: "Web/General/allCompareProducts",
    }),
  },
};
</script>
