<template>
  <div class="card mb-3 ms-3 me-3">
    <nuxt-link :to="`/product/${product.slug}`">
      <div class="row g-0 align-items-center">
        <div class="col-6 pe-3 h-100">
          <div class="img-wrap">
            <img
              v-if="image"
              class="w-sm-100 img-fluid"
              :src="`/backend${image.thumbnails.small.thumbnail}`"
              :alt="image.alt_text"
            />
            <img
              v-else
              class="w-sm-100 img-fluid"
              src="~/assets/images/defult-product-img.png"
              alt="..."
            />
          </div>
        </div>
        <div class="col-6 h-100 d-flex align-items-center">
          <div class="card-body ps-0 py-3">
            <h6 class="mb-1">{{ product.name }}</h6>
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
            <div class="icons d-flex flex-row align-items-center mb-1">
              <i onclick="return false;" class="list-icon pe-2"
                ><fa :icon="['fas', 'heart']"
              /></i>
              <i onclick="return false;" class="list-icon" @click="addToCart"
               v-tooltip="{ content: $t('add_to_cart') }"
                ><fa :icon="['fas', 'shopping-bag']"
              /></i>
            </div>
            <div class="rating">
              <GlobalRating :rating="product.reviews_average_rating" />
            </div>
          </div>
        </div>
      </div>
    </nuxt-link>
  </div>
</template>
<style media="screen">
</style>
<script type="text/javascript">
import { mapGetters, mapActions } from "vuex";
export default {
  props: ["product"],
  data() {
    return {};
  },
  methods: {
    ...mapActions({
      fetchCartItems: "Web/Cart/fetchCartItems",
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
