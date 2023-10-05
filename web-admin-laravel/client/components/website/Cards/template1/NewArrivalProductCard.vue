<template>
  <div class="card overflow-hidden">
    <nuxt-link :to="`/product/${product.slug}`">
      <div class="row g-0 align-items-center">
          <div class="col-6 pe-3 h-100">
            <div class="img-wrap">
              <img v-if="image" class="w-sm-100 img-fluid" :src="`/backend${image.thumbnails.small.thumbnail}`" :alt="image.alt_text">
              <img v-else class="w-sm-100 img-fluid" src="~/assets/images/defult-product-img.png" alt="...">
            </div>
          </div>
          <div class="col-6 h-100 d-flex align-items-center">
              <div class="card-body ps-0 py-3">
                  <h6>
                    {{product.name}}
                  </h6>
                  <div class="product-price d-flex align-items-center mb-1" v-if="product.flash_sale">
                    <span class="price">
                      {{product.flash_sale.display_price}}
                    </span>
                    <span class="actual-price" >
                      {{product.display_price}}
                    </span>
                  </div>
                  <div class="product-price d-flex align-items-center mb-1" v-else-if="product.special_sale">
                    <span class="price">
                      {{product.special_sale.display_price}}
                    </span>
                    <span class="actual-price" >
                      {{product.display_price}}
                    </span>
                  </div>
                  <div class="product-price d-flex align-items-center mb-1" v-else>
                    <span v-if="product.attributes &&  product.attributes.length > 0">
                        {{ $t("starting_from_price") }}
                    <span class="price" v-if="product.attributes &&  product.attributes.length > 0">
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
                      <i onclick="return false;" class="list-icon"  v-tooltip="{ content: $t('add_to_wishlist') }"  @click="addToWishlist()" ><fa :icon="['fas', 'heart']" :class="product.is_wishlisted || wishlist ? 'text-danger' : ''" /></i>
                      <button onclick="return false;" class="list-icon text-body border-0 bg-transparent"   v-tooltip="{ content: $t('add_to_cart') }"  @click="addToCart"><fa :icon="['fas', 'shopping-bag']" /></button>
                  </div>
                  <div class="rating">
                      <GlobalRating :rating="product.reviews_average_rating" />
                  </div>
                  <span v-for="(tag,index) in product.tags" :key="index" class="badge me-1" :class="index %2 == 0 ? 'bg-primary':'bg-danger'">{{tag}}</span>
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
    props:['product'],
    data(){
      return{
          wishlist : false
      }
    },
    mounted()
    {

    },
    methods:{
      ...mapActions({
          fetchCartItems: 'Web/Cart/fetchCartItems',
          fetchWishlistItems: 'Web/Wishlist/fetchWishlistItems'

      }),
      async addToCart(){
        if(this.product.is_available){
        if(this.product.product_type == 2){
          this.$router.push(`/product/${this.product.slug}`)
        }
        else{
          await this.$webService.addCartItem({product_id:this.product.id,quantity: 1}).then(async (res) => {
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
  computed:{
    image(){
      if(this.product.media){
        const image = this.product.media.find((single) => single.type == 'image')
        if(image){
          return image
        }
        else{
          return null
        }
      }
      else{
        return null
      }
    }
  }
}
</script>
