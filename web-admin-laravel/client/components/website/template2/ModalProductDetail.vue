<template>
  <div
    class="modal fade quickViewModal"
    :id="modal_id"
    tabindex="-1"
    aria-labelledby="quickView"
    aria-hidden="true"
  >
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body">
          <div class="row g-0" v-if="product">
            <div class="col-12 col-md-6">
              <VueSlickCarousel
                v-if="product.media.length > 0"
                :key="key"
                v-bind="settings"
              >
                <div v-for="media in product.media" :key="media.id">
                  <div class="img-wrap" v-if="media.type == 'image'">
                    <img
                      :src="`/backend${media.original_media_path}`"
                      class="d-block w-100"
                      :alt="media.alt_text"
                    />
                  </div>
                  <div class="img-wrap" v-if="media.type == 'video'">
                    <video
                      width="auto"
                      height="auto"
                      controls
                      :src="`/backend${media.original_media_path}`"
                      class="d-block w-100"
                      :alt="media.alt_text"
                    ></video>
                  </div>
                </div>
              </VueSlickCarousel>
              <span
                v-for="(tag, index) in product.tags"
                class="badge"
                :class="index % 2 == 0 ? 'bg-primary' : 'bg-danger'"
                >{{ tag }}</span
              >
            </div>
            <div class="col-12 col-md-6 pro-description">
              <button
                type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close"
              ></button>
              <div class="pro-sec price-sec">
                <h4>{{ product.name }}</h4>
                <p class="price-det" v-html="product.short_description"></p>
                <div
                  class="price-stock d-flex flex-row align-items-center mb-3"
                >
                  <h4 class="itm-price mb-0">{{ price }}</h4>
                  <div
                    class="about-stock text-success mb-0"
                    v-if="stock >= product.min_order"
                  >
                    {{$t('available_in_stock')}}
                  </div>
                  <div class="about-stock text-danger mb-0" v-else>
                    {{$t('out_of_stock')}}
                  </div>
                </div>
                <div class="pro-rating">
                  <GlobalRating :rating="product.reviews_average_rating" />
                </div>
              </div>
              <div class="pro-sec shop-name">
                <div v-if="product.brand">
                  <span>{{$t('brand')}}:</span
                  ><span
                    ><a href="#">{{ product.brand.name }}</a></span
                  >
                </div>
                <div v-if="product.sku">
                  <span>{{$t('sku')}}:</span
                  ><span
                    ><a href="#">{{ product.sku }}</a></span
                  >
                </div>
              </div>

              <!-- Uncomment below div for variants -->
              <!-- <div
                v-if="
                  product.product_type == 2 && product.attributes.length > 0
                "
              >
                <div
                  class="pro-sec size-sec"
                  v-for="attribute in product.attributes"
                  :key="attribute.id"
                >
                  <div class="select-col d-flex align-items-center mb-3">
                    <h5>{{ attribute.name }}</h5>
                  </div>
                  <div
                    class="btn-group select-opt"
                    role="group"
                    aria-label="button"
                  >
                    <div v-for="value in attribute.values" :key="value.id">
                      <input
                        type="radio"
                        class="btn-check"
                        :id="value.slug"
                        :value="value.slug"
                        autocomplete="off"
                      />
                      <label class="btn btn-primary s-xs" :for="value.slug">{{
                        value.name
                      }}</label>
                    </div>
                  </div>
                </div>
              </div> -->
              <div class="pro-sec quantity-sec d-flex align-items-center">
                <h4 v-if="product.product_type != 2" class="me-3">Qty:</h4>
                <WebsiteTemplate2PlusMinusInput
                  v-if="product.product_type != 2"
                  :key="key"
                  v-model="quantity"
                  :min="product.min_order"
                  :max="stock < product.max_order ? stock : product.max_order"
                />
                <button
                  v-if="product.product_type != 2"
                  type="button"
                  class="
                    btn btn-primary
                    ad-cart
                    d-flex
                    justify-content-center
                    align-items-center
                    px-2
                  "
                  @click="addToCart"
                  :disabled="stock < product.min_order"
                >
                  <fa :icon="['fas', 'shopping-cart']" class="me-2" />{{$t('add_to_cart')}}
                </button>
                <button
                  v-else
                  type="button"
                  data-bs-dismiss="modal"
                  class="
                    btn btn-primary
                    ad-cart
                    d-flex
                    justify-content-center
                    align-items-center
                    px-2
                  "
                  @click="$router.push(`/product/${product.slug}`)"
                >
                  {{$t('web.customer.orders.filter.view_details')}}
                </button>

                <a href="#" onclick="return false;" @click="addToWishlist()" class="icon-cont"
                  ><fa :icon="['fas', 'heart']" :class="product.is_wishlisted || wishlist ? 'text-danger' : ''"
                /></a>
                <a href="#" onclick="return false;" @click="addToComparelist()" class="icon-cont"
                  ><fa :icon="['fas', 'exchange-alt']"
                /></a>
                <a href="#" onclick="return false;" class="icon-cont"
                  ><fa :icon="['fas', 'share']"
                /></a>
              </div>
            </div>
          </div>
          <div class="" v-else>
            <AdminLoader />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
export default {
  created() {},
  data() {
    return {
      product: "",
      price: "",
      stock: "",
      quantity: 1,
      key: 1,
      wishlist: false,
      settings: {
        responsive: [
          {
            breakpoint: 1024,
            settings: {
              slidesToShow: 1,
            },
          },
          {
            breakpoint: 600,
            settings: {
              slidesToShow: 1,
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
  mounted() {
    this.$root.$on("detailModalProductChanged", (data) => {
      this.product = data;
      this.price = this.product.display_price;
      this.stock = this.product.stock;
      this.quantity = this.product.min_order;
    });
  },
  props: ["modal_id"],
  methods: {
    async addToCart() {
      if (this.product.is_available) {
        if (this.stock >= this.quantity) {
          if (this.quantity >= this.product.max_order) {
            this.$toast.error(this.$t("product_exceeds_its_maximum_order_limit"));
          } else {
            await this.$webService
              .addCartItem({
                product_id: this.product.id,
                quantity: this.quantity,
              })
              .then(async (res) => {
                await this.fetchCartItems();
                if (res.success) {
                  this.$toast.success(res.message);
                } else {
                  this.$toast.error(res.message);
                }
              });
          }
        } else {
          this.$toast.error(this.$t("product_out_of_stock"));
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
      fetchWishlistItems: 'Web/Wishlist/fetchWishlistItems',
       fetchCompareProducts: 'Web/General/fetchCompareProducts'
    }),

  },
    computed:{
    ...mapGetters({
      allCompareProducts: 'Web/General/allCompareProducts'
    }),
  },
  watch: {
    product() {
      if (this.product) {
        this.key += 1;
      }
    },
  },
};
</script>

<style>
</style>
