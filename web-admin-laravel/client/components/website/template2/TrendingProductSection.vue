<template>
  <section v-if="$fetchState.pending">
    <WebsiteSkeletonTemplate2TrendingProducts />
  </section>
  <section class="featured-items" v-else-if="$fetchState.error">
    <div class="row">
      <div class="col-md-12">
        <AdminLoader />
      </div>
    </div>
  </section>
  <section
    class="trending-products"
    v-else
  >
    <div class="container">
      <div class="row heading mb-15">
        <div class="col-xl-6 col-md-4 text-center">
          <h2 class="section-heading text-start mb-0 p-0">{{this.$t('web.home.trending_now.title')}}</h2>
        </div>
        <div class=" col-xl-6 col-md-8">
          <ul
            class="nav nav-tabs border-0 mb-0 justify-content-center justify-content-md-end"
            id="myTab"
            role="tablist"
          >
            <li class="nav-item" role="presentation">
              <button
                class="nav-link pb-0 border-0 active"
                id="all-products"
                data-bs-toggle="tab"
                data-bs-target="#tab1"
                type="button"
                role="tab"
                aria-controls="home"
                aria-selected="true"
              >
                {{this.$t('web.home.trending_now.all')}}
              </button>
            </li>
            <li class="nav-item" role="presentation">
              <button
                class="nav-link pb-0 border-0"
                id="newset-products"
                data-bs-toggle="tab"
                data-bs-target="#tab2"
                type="button"
                role="tab"
                aria-controls="profile"
                aria-selected="false"
              >
              {{this.$t('web.home.trending_now.top_rated')}}
              </button>
            </li>
            <li class="nav-item" role="presentation">
              <button
                class="nav-link pb-0 border-0"
                id="on_sale_products"
                data-bs-toggle="tab"
                data-bs-target="#tab4"
                type="button"
                role="tab"
                aria-controls="contact"
                aria-selected="false"
              >
               {{this.$t('web.home.trending_now.on_sale')}}
              </button>
            </li>
            <li class="nav-item" role="presentation">
              <button
                class="nav-link pb-0 border-0"
                id="best_seller_products"
                data-bs-toggle="tab"
                data-bs-target="#tab5"
                type="button"
                role="tab"
                aria-controls="contact"
                aria-selected="false"
              >
                   {{this.$t('web.home.trending_now.best_sellers')}}
              </button>
            </li>
          </ul>
        </div>
      </div>
      <div class="row">
        <div class="new-section">
          <div class="tab-content" id="myTabContent">
            <div
              class="tab-pane fade show active"
              id="tab1"
              role="tabpanel"
              aria-labelledby="all-products"
            >
              <div class="row">
                <div class="col-xl-4 col-md-6" v-for="(product,index) in allTrendingProducts.trending_products" :key="index">
                     <Template2TrendingProductCard :product="product" />
                </div>
              </div>
            </div>
            <div
              class="tab-pane fade"
              id="tab2"
              role="tabpanel"
              aria-labelledby="newset-products"
            >
              <div class="row">

                <div class="col-lg-4 col-md-6" v-for="(product,index) in allTrendingProducts.top_rated_products " :key="index">
                 <Template2TrendingProductCard :product="product" />
                </div>
              </div>
            </div>
            <div
              class="tab-pane fade"
              id="tab4"
              role="tabpanel"
              aria-labelledby="on_sale_products"
            >
                <div class="row">
                <div class="col-xl-4 col-md-6" v-for="(product,index) in allTrendingProducts.on_sale_products" :key="index">
                 <Template2TrendingProductCard :product="product" />
                </div>
              </div>
            </div>
            <div
              class="tab-pane fade"
              id="tab5"
              role="tabpanel"
              aria-labelledby="best_seller_products"
            >
               <div class="row">
                <div class="col-xl-4 col-md-6" v-for="(product,index) in allTrendingProducts.best_sellers_products" :key="index">
                 <Template2TrendingProductCard :product="product" />
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import { mapGetters, mapActions } from "vuex";

export default {
  async fetch() {
    if (!this.allTrendingProducts) {
      await this.fetchTrendingProducts();
    }
  },
  methods: {
    ...mapActions({
      fetchTrendingProducts: "Web/General/fetchTrendingProducts",
         fetchCartItems: 'Web/Cart/fetchCartItems',
    }),
         async addToCart(product){
        if(product.is_available){
        if(product.product_type == 2){
          this.$router.push(`/product/${product.slug}`)
        }
        else{
          await this.$webService.addCartItem({product_id:product.id,quantity: 1}).then(async (res) => {
            if(res.success){
              this.$toast.success(res.message);
              await this.fetchCartItems()
            }
            else{
              this.$toast.error(res.message);
            }
          });
        }
      }
      else{
          this.$toast.error(this.$t('product_not_available'))
      }
      },
  },
  computed: {
    ...mapGetters({
      allTrendingProducts: "Web/General/allTrendingProducts",
    }),
  },
  data() {
    return {
    };
  },
};
</script>

<style></style>
