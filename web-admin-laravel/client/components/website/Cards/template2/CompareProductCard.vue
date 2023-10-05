<template>
    <div class="compare-item rounded h-100">
        <div class="compare-item-wrap rounded overflow-hidden h-100 d-flex flex-column bg-secondary" >
            <div class="compare-item-img">
                <div class="img-wrap">
                <img v-if="image"  :src="`/backend${image.thumbnails.medium.thumbnail}`" :alt="image.alt_text">
                <img v-else src="~assets/images/mega-menu-offer-img.jpg">

                </div>
                <h5>
                <nuxt-link :to="`/product/${product.slug}`">
                {{product.name}}
                </nuxt-link>
                    <GlobalRating :rating="product.reviews_average_rating" /> </h5>
                <div class="icon-wrap d-flex flex-column">
                <a href="#" onclick="return false;"  @click="addToWishlist()" class="icon-cont"><fa :icon="['fas', 'heart']" /></a>
                </div>
            </div>
            <ul>
                <li>
                <div class="product-price d-flex align-items-center" v-if="product.flash_sale">
                        {{$t('price')}}:
                        <span class="price">
                            {{product.flash_sale.display_price}}
                        </span>
                        <span class="actual-price" >
                            {{product.display_price}}
                        </span>
                        </div>
                        <div class="product-price d-flex align-items-center" v-else-if="product.special_sale">
                            {{$t('price')}}:
                        <span class="price">
                            {{product.special_sale.display_price}}
                        </span>
                        <span class="actual-price" >
                            {{product.display_price}}
                        </span>
                        </div>
                        <div class="product-price d-flex align-items-center" v-else>
                        {{$t('price')}}:
                        <span class="price">
                            {{product.display_price}}
                        </span>

                        </div>
                        </li>
                <li v-if="this.product.sku">{{$t('sku')}}: {{ this.product.sku}}</li><li v-else>{{$t('sku')}}: {{$t('n_a')}}</li>
            <!--  <li>{{$t('stock')}}: {{ this.product.stock}}</li> -->
                <li>{{$t('keywords.manufacturer')}}: {{ this.product.manufacturer.name}}</li>
                <li v-if="this.product.modal">{{$t('modal')}}: {{this.product.modal}}</li><li v-else>{{$t('modal')}}: {{$t('n_a')}}</li>
                <li v-if="this.product.brand">{{$t('brand.label')}}: {{ this.product.brand.name}}</li><li v-else>{{$t('brand')}}: {{$t('n_a')}}</li>
                <li v-if="this.product.vendor">{{$t('keywords.vendor')}}: {{ this.product.vendor.name}}</li><li v-else>{{$t('vendor')}}: {{$t('n_a')}}</li>
                <li>{{$t('weight')}}: {{this.product.weight +' '+ this.product.unit}}</li>
                <li v-if="this.product.attributes.length > 0">{{$t('attributes')}}
                    <div class="pl-4" v-for="attribute in this.product.attributes" :key="attribute.id">
                    {{attribute.name}} : <span v-for="(value,index) in attribute.values" :key="value.id">{{value.name}} {{ index == attribute.values.length -1 ? '':','}}</span>
                    </div>
                </li>
                <li v-else>{{$t('attributes')}}: {{$t('n_a')}}</li>
            </ul>
            <div class="vender-btns d-flex justify-content-center align-items-center mt-auto">
                <nuxt-link :to="`/product/${product.slug}`">
                <button class="btn btn-warning rounded fw-bold d-flex align-items-center justify-content-center">
                {{$t('explore_more')}}
                </button>
                </nuxt-link>
                <button @click="addToCart()" class="btn btn-primary text-white rounded fw-bold d-flex align-items-center justify-content-center ms-3">
                <fa :icon="['fas', 'shopping-bag']" class="me-2" /> {{$t('add_to_cart')}}
                </button>
                    <button @click="removeItem()" class="btn btn-danger text-white rounded fw-bold d-flex align-items-center justify-content-center ms-3">{{$t('remove')}}
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
export default {
  props:['product'],
  data(){
      return{
      }
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
          this.$toast.error('Product Not Available Yet')
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
                this.$toast.success(res.data.message);
            }
        });
        }
        else
        {
            this.$toast.error(this.$t('please_login_first'));
        }
    },
        removeItem()
        {
            this.$emit('removeItem');
        }
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

<style>

</style>
