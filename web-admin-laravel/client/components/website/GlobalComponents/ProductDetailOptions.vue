<template>
    <div>
        <div class="product-detail-options" v-if="currentlyActiveTemplate == 'Template1'">
        <div class="pro-sec price-sec">
            <h4>{{product.name}}</h4>
            <p class="price-det" v-html="product.short_description_web"></p>
            <div class="pro-rating mb-3">
                <GlobalRating :rating="product.reviews_average_rating" />
            </div>
            <div class="pro-stock row g-0">
                <div class="col-4">
                  <div>{{ $t("price") }}</div>
                    <div v-if="product.brand">{{ $t("brand.label") }}:</div>
                    <div v-if="product.sku">{{ $t("sku") }}</div>
                    <div>{{ $t("avaibility") }}</div>
                </div>
                <div class="col-8">
                    <div class="product-price d-flex align-items-center" v-if="flash_sale_price">
                      <span class="price">
                        {{product.flash_sale.display_price}}
                      </span>
                      <span class="actual-price" >
                        {{product.display_price}}
                      </span>
                    </div>
                    <div class="product-price d-flex align-items-center" v-else-if="special_sale_price">
                      <span class="price">
                        {{product.special_sale.display_price}}
                      </span>
                      <span class="actual-price" >
                        {{product.display_price}}
                      </span>
                    </div>
                    <div class="product-price d-flex align-items-center" v-else>
                      <span class="price">
                        {{price}}
                      </span>
                    </div>
                    <div v-if="product.brand">{{product.brand.name}}</div>
                    <div v-if="product.sku">{{product.sku}}</div>
                    <div><span v-if="stock >= product.min_order &&  product.product_type == 1">{{ $t("in_stock") }}</span>
                    <span v-else-if="stock != 0 && product.product_type == 2">
                        {{ $t("in_stock") }}
                    </span>
                    <span v-else> {{ $t("out_of_stock") }}</span> </div>
                </div>
            </div>
        </div>
        <div class="pro-sec" v-if="product.product_type == 2 && product.attributes.length >0">

          <div class="pro-sec size-sec" v-for="attribute in product.attributes"  :key="attribute.id">
              <div class="select-col d-flex align-items-center mb-3">
                  <h5>{{attribute.name}}</h5>
                  <span class="seclected-opt mb-2">{{display_options['attribute_'+attribute.id]}}</span>
              </div>
              <div class="btn-group select-opt flex-wrap" role="group" aria-label="button">
                <div v-for="value in attribute.values"  :key="value.id">
                  <input type="radio" class="btn-check" @change="optionsChanged" :id="value.slug" :value="value.slug" v-model="options['attribute_'+attribute.id]" autocomplete="off">
                  <label class="btn btn-primary s-xs" :for="value.slug">{{value.name}}</label>
                </div>
              </div>
          </div>
          <div v-if="stock != 0 && product.product_type == 2">

          </div>
          <div class="alert alert-danger" v-else role="alert">
              {{ $t("out_of_stock") }}
        </div>
        </div>
          <div class="alert alert-danger" v-if="stock < product.min_order && product.product_type == 1"  role="alert">
              {{ $t("out_of_stock") }}
        </div>
        <div class="pro-sec quantity-sec">
            <div class="sel-col d-flex align-items-center ">
                <h5>{{$t('quantity')}}:</h5>
            </div>
            <div class="d-flex align-items-center">
                <div v-if="product.is_upcoming" class="d-flex">
                    <button  type="button" :disabled="stock < product.min_order"  class="btn btn-primary ad-cart text-white
                d-flex justify-content-center px-2"> Available on {{product.available_date}}</button>
                 <a href="#" onclick="return false;" @click="addToWishlist()" class="icon-cont"><fa :icon="['fas', 'heart']"  :class="product.is_wishlisted || wishlist ? 'text-danger' : ''"/></a>
                <a href="#" onclick="return false;" @click="addToComparelist()"  class="icon-cont"><fa :icon="['fas', 'exchange-alt']" /></a>
                <a href="#" onclick="return false;" class="icon-cont"><fa :icon="['fas', 'share']" /></a>
                </div>
                <div v-else class="d-flex align-items-center">
                    <WebsiteTemplate1PlusMinusInput v-model="quantity" :min="product.min_order" :max="stock < product.max_order? stock:product.max_order" />
                <button type="button"  :disabled="stock < product.min_order"  class="icon-cont btn-custom text-black
                d-flex justify-content-center px-2" @click="addToCart"><fa :icon="['fas', 'shopping-bag']" class="me-2" />
                 <!-- {{ $t("add_to_cart") }} -->
                 </button>
                <a href="#" onclick="return false;" @click="addToWishlist()" class="icon-cont"><fa :icon="['fas', 'heart']"  :class="product.is_wishlisted || wishlist ? 'text-danger' : ''"/></a>
                <a href="#" onclick="return false;" @click="addToComparelist()"  class="icon-cont"><fa :icon="['fas', 'exchange-alt']" /></a>
                <a href="#" onclick="return false;" class="icon-cont"><fa :icon="['fas', 'share']" /></a>
                </div>

            </div>
        </div>
    </div>
    <div class="product-detail-options" v-if="currentlyActiveTemplate == 'Template2'">
        <div class="pro-sec price-sec">
            <div class="w-100 mb-3">
                <span v-if="stock >= product.min_order &&  product.product_type == 1" class="badge bg-green-badge small rounded-1 text-green-dark text-uppercase">{{ $t("in_stock") }}</span>
                <span v-else-if="stock != 0 && product.product_type == 2" class="badge bg-green-badge rounded-1 small text-green-dark text-uppercase">
                    {{ $t("in_stock") }}
                </span>
                <span v-else> {{ $t("out_of_stock") }}</span>
            </div>
            <h4 class="fs-3 fw-bold">{{product.name}}</h4>
            <div class="w-100 d-flex">
                <div v-if="product.brand"><span class="text-dark-50">{{ $t("brand.label") }}:</span> {{product.brand.name}}</div>
                <div class="pro-rating px-5">
                    <GlobalRating :rating="product.reviews_average_rating" />
                </div>
                <div v-if="product.sku"><span class="text-dark-50">{{ $t("sku") }}:</span> {{product.sku}}</div>
            </div>
            <hr>
            <div v-if="product.brand" class="w-100 mb-3 text-primary"><span class="text-dark-50">{{$t('web.customer.product_detail.sold_by')}}: </span>{{product.brand.name}}</div>
            <p class="price-det text-dark" v-html="product.short_description"></p>
            <hr>
            <div class="pro-stock row g-0">
                <div class="col-12">
                    <div class="product-price d-flex align-items-center" v-if="flash_sale_price">
                      <span class="price">
                        {{product.flash_sale.display_price}}
                      </span>
                      <span class="actual-price" >
                        {{product.display_price}}
                      </span>
                    </div>
                    <div class="product-price d-flex align-items-center" v-else-if="special_sale_price">
                      <span class="price">
                        {{product.special_sale.display_price}}
                      </span>
                      <span class="actual-price" >
                        {{product.display_price}}
                      </span>
                    </div>
                    <div class="product-price d-flex align-items-center" v-else>
                      <span class="price fs-2">
                        {{price}}
                      </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="pro-sec" v-if="product.product_type == 2 && product.attributes.length >0">

          <div class="pro-sec size-sec" v-for="attribute in product.attributes"  :key="attribute.id">
              <div class="select-col d-flex align-items-center mb-3">
                  <h5>{{attribute.name}}</h5>
                  <span class="seclected-opt mb-2">{{display_options['attribute_'+attribute.id]}}</span>
              </div>
              <div class="btn-group select-opt flex-wrap" role="group" aria-label="button">
                <div v-for="value in attribute.values"  :key="value.id">
                  <input type="radio" class="btn-check" @change="optionsChanged" :id="value.slug" :value="value.slug" v-model="options['attribute_'+attribute.id]" autocomplete="off">
                  <label class="btn btn-primary s-xs" :for="value.slug">{{value.name}}</label>
                </div>
              </div>
          </div>
          <div v-if="stock != 0 && product.product_type == 2">

          </div>
          <div class="alert alert-danger" v-else role="alert">
              {{ $t("out_of_stock") }}
        </div>
        </div>
          <div class="alert alert-danger" v-if="stock < product.min_order && product.product_type == 1"  role="alert">
              {{ $t("out_of_stock") }}
        </div>
        <div class="pro-sec quantity-sec">
            <div class="sel-col d-flex align-items-center ">
                <h5 class="fs-6">{{$t('quantity')}}:</h5>
            </div>
            <div class="d-flex flex-column">
                <div class="d-flex align-items-center quantity-section">
                    <WebsiteTemplate2PlusMinusInput v-model="quantity" :min="product.min_order" :max="stock < product.max_order? stock:product.max_order" />
                    <button type="button"  :disabled="stock < product.min_order"  class="btn rounded-1 border-0 btn-custom btn-primary
                    d-flex justify-content-center align-items-center px-2" @click="addToCart">
                    <!-- <fa :icon="['fas', 'shopping-bag']" class="me-2 fs-4" /> -->
                    <svg data-v-4bd8babe="" xmlns="http://www.w3.org/2000/svg" class="me-2 fs-4" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" width="23" height="23" x="0" y="0" viewBox="0 0 489 489" xml:space="preserve"><g data-v-4bd8babe=""><g data-v-4bd8babe="" xmlns="http://www.w3.org/2000/svg"><path data-v-4bd8babe="" d="M440.1,422.7l-28-315.3c-0.6-7-6.5-12.3-13.4-12.3h-57.6C340.3,42.5,297.3,0,244.5,0s-95.8,42.5-96.6,95.1H90.3   c-7,0-12.8,5.3-13.4,12.3l-28,315.3c0,0.4-0.1,0.8-0.1,1.2c0,35.9,32.9,65.1,73.4,65.1h244.6c40.5,0,73.4-29.2,73.4-65.1   C440.2,423.5,440.2,423.1,440.1,422.7z M244.5,27c37.9,0,68.8,30.4,69.6,68.1H174.9C175.7,57.4,206.6,27,244.5,27z M366.8,462   H122.2c-25.4,0-46-16.8-46.4-37.5l26.8-302.3h45.2v41c0,7.5,6,13.5,13.5,13.5s13.5-6,13.5-13.5v-41h139.3v41   c0,7.5,6,13.5,13.5,13.5s13.5-6,13.5-13.5v-41h45.2l26.9,302.3C412.8,445.2,392.1,462,366.8,462z" fill="currentColor" data-original="currentColor"></path></g> <g data-v-4bd8babe="" xmlns="http://www.w3.org/2000/svg"></g> <g data-v-4bd8babe="" xmlns="http://www.w3.org/2000/svg"></g> <g data-v-4bd8babe="" xmlns="http://www.w3.org/2000/svg"></g> <g data-v-4bd8babe="" xmlns="http://www.w3.org/2000/svg"></g> <g data-v-4bd8babe="" xmlns="http://www.w3.org/2000/svg"></g> <g data-v-4bd8babe="" xmlns="http://www.w3.org/2000/svg"></g> <g data-v-4bd8babe="" xmlns="http://www.w3.org/2000/svg"></g> <g data-v-4bd8babe="" xmlns="http://www.w3.org/2000/svg"></g> <g data-v-4bd8babe="" xmlns="http://www.w3.org/2000/svg"></g> <g data-v-4bd8babe="" xmlns="http://www.w3.org/2000/svg"></g> <g data-v-4bd8babe="" xmlns="http://www.w3.org/2000/svg"></g> <g data-v-4bd8babe="" xmlns="http://www.w3.org/2000/svg"></g> <g data-v-4bd8babe="" xmlns="http://www.w3.org/2000/svg"></g> <g data-v-4bd8babe="" xmlns="http://www.w3.org/2000/svg"></g> <g data-v-4bd8babe="" xmlns="http://www.w3.org/2000/svg"></g></g></svg>
                  {{$t('web.customer.compare.add_to_cart')}}
                    </button>
                </div>
                <div class="d-flex align-items-center mt-4 mb-3">
                    <a href="#" onclick="return false;" @click="addToWishlist()" class="icon-cont d-flex align-items-center">
                        <!-- <fa class="fs-3" :icon="['fas', 'heart']"  :class="product.is_wishlisted || wishlist ? 'text-danger' : ''"/> -->
                        <span :class="product.is_wishlisted || wishlist ? 'text-danger' : ''">
                            <svg data-v-4bd8babe="" xmlns="http://www.w3.org/2000/svg" class="fs-3 fa-share" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" width="23" height="23" x="0" y="0" viewBox="0 0 512.001 512" xml:space="preserve"><g data-v-4bd8babe="" transform="matrix(1,0,0,1,0,30)"><path data-v-4bd8babe="" xmlns="http://www.w3.org/2000/svg" d="m256 455.515625c-7.289062 0-14.316406-2.640625-19.792969-7.4375-20.683593-18.085937-40.625-35.082031-58.21875-50.074219l-.089843-.078125c-51.582032-43.957031-96.125-81.917969-127.117188-119.3125-34.644531-41.804687-50.78125-81.441406-50.78125-124.742187 0-42.070313 14.425781-80.882813 40.617188-109.292969 26.503906-28.746094 62.871093-44.578125 102.414062-44.578125 29.554688 0 56.621094 9.34375 80.445312 27.769531 12.023438 9.300781 22.921876 20.683594 32.523438 33.960938 9.605469-13.277344 20.5-24.660157 32.527344-33.960938 23.824218-18.425781 50.890625-27.769531 80.445312-27.769531 39.539063 0 75.910156 15.832031 102.414063 44.578125 26.191406 28.410156 40.613281 67.222656 40.613281 109.292969 0 43.300781-16.132812 82.9375-50.777344 124.738281-30.992187 37.398437-75.53125 75.355469-127.105468 119.308594-17.625 15.015625-37.597657 32.039062-58.328126 50.167969-5.472656 4.789062-12.503906 7.429687-19.789062 7.429687zm-112.96875-425.523437c-31.066406 0-59.605469 12.398437-80.367188 34.914062-21.070312 22.855469-32.675781 54.449219-32.675781 88.964844 0 36.417968 13.535157 68.988281 43.882813 105.605468 29.332031 35.394532 72.960937 72.574219 123.476562 115.625l.09375.078126c17.660156 15.050781 37.679688 32.113281 58.515625 50.332031 20.960938-18.253907 41.011719-35.34375 58.707031-50.417969 50.511719-43.050781 94.136719-80.222656 123.46875-115.617188 30.34375-36.617187 43.878907-69.1875 43.878907-105.605468 0-34.515625-11.605469-66.109375-32.675781-88.964844-20.757813-22.515625-49.300782-34.914062-80.363282-34.914062-22.757812 0-43.652344 7.234374-62.101562 21.5-16.441406 12.71875-27.894532 28.796874-34.609375 40.046874-3.453125 5.785157-9.53125 9.238282-16.261719 9.238282s-12.808594-3.453125-16.261719-9.238282c-6.710937-11.25-18.164062-27.328124-34.609375-40.046874-18.449218-14.265626-39.34375-21.5-62.097656-21.5zm0 0" fill="currentColor" data-original="currentColor"></path></g></svg>
                        </span>
                        <span class="border-bottom border-gray pb-1 ms-2 text-body"> {{$t('web.customer.compare.add_to_wishlist')}}</span></a>
                    <a href="#" onclick="return false;" @click="addToComparelist()" class="icon-cont d-flex align-items-center">
                        <!-- <fa class="fs-3" :icon="['fas', 'exchange-alt']" /> -->
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" version="1.1"  class="fs-3 fa-share" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" width="26" height="26" x="0" y="0" viewBox="0 0 24 24" xml:space="preserve"><g><path xmlns="http://www.w3.org/2000/svg" d="m21 7.5h-9.793l3.14649 3.14648a.5.5 0 1 1 -.707.707l-4-4a.49983.49983 0 0 1 0-.707l4-4a.5.5 0 0 1 .707.707l-3.14649 3.14652h9.793a.5.5 0 0 1 0 1zm-11.35352 13.85352a.49984.49984 0 0 0 .707 0l4-4a.49983.49983 0 0 0 0-.707l-4-4a.5.5 0 0 0 -.707.707l3.14652 3.14648h-9.793a.5.5 0 0 0 0 1h9.793l-3.14652 3.14648a.49983.49983 0 0 0 0 .70704z" fill="currentColor" data-original="currentColor"></path></g></svg>
                        </span>
                    <span class="border-bottom border-gray pb-1 ms-2 text-body">  {{$t('web.customer.compare.label')}}</span></a>
                </div>
                <hr>
                <div class="d-flex align-items-center">
                    <a href="#" onclick="return false;" class="icon-cont text-primary"><fa :icon="['fas', 'share']" /></a>
                </div>

            </div>
        </div>
    </div>
    </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
export default {
  props:['product'],
  data(){
    return {
      options:{},
      display_options:{},
      variant_attribute_value_names:[],
      price:'',
      flash_sale_price:'',
      special_sale_price:'',
      stock: '',
      variant: '',
      quantity:1,
       wishlist : false,
      currentlyActiveTemplate: "",

    }
  },
  methods:{
    ...mapActions({
        fetchCartItems: 'Web/Cart/fetchCartItems',
        fetchWishlistItems: "Web/Wishlist/fetchWishlistItems",
         fetchCompareProducts: "Web/General/fetchCompareProducts",
    }),
    async addToCart(){
      if(this.product.is_available){
      if(this.product.product_type == 2){
        var slug = ''
        for (var i = 0; i < this.product.attributes.length; i++) {
          if(i == 0){
            slug = this.options['attribute_'+this.product.attributes[i].id]
          }
          else{
            slug = slug +'-'+this.options['attribute_'+this.product.attributes[i].id]
          }
        }
        var variant = this.product.variants.find((obj) => obj.variant == slug)
        if(variant == null){
          this.$toast.success(this.$t('Please Select Variant'))
        }
        else{
            if(this.quantity > this.product.max_order){
              this.$toast.error(this.$t('product_max_order_limit_reached'))
            }
            else{
            await this.$webService.addCartItem({product_id:this.product.id,quantity: this.quantity,variant:this.variant,variant_attribute_value_names:this.variant_attribute_value_names}).then(async (res) => {
              await this.fetchCartItems()
              if(res.success){
                this.$toast.success(res.message);
              }
              else{
                this.$toast.error(res.message);
              }
            });
          }
        //   else{
        //     this.$toast.error(this.$t('min_add_to_cart_quantity'))
        //   }
        }
      }
      else{
        if(this.stock >= this.quantity){
          if(this.quantity > this.product.max_order){
            this.$toast.error(this.$t('product_max_order_limit_reached'))
          }
          else{
            await this.$webService.addCartItem({product_id:this.product.id,quantity: this.quantity,variant:this.variant,variant_attribute_value_names:this.variant_attribute_value_names}).then(async (res) => {
              await this.fetchCartItems()
              if(res.success){
                this.$toast.success(res.message);
              }
              else{
                this.$toast.error(res.message);
              }
            });
          }
        }
        else{
          this.$toast.error(this.$t('min_add_to_cart_quantity'))
        }
      }
    }else{
      this.$toast.error(this.$t('product_not_available'))
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
        }
        if (get_compare_products.includes(this.product.id)) {
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
    optionsChanged(){
      var slug = ''
      for (var i = 0; i < this.product.attributes.length; i++) {
        if(i == 0){
          slug = this.options['attribute_'+this.product.attributes[i].id]
        }
        else{
          slug = slug +'-'+this.options['attribute_'+this.product.attributes[i].id]
        }
        var value = this.product.attributes[i].values.find((val) => val.slug == this.options['attribute_'+this.product.attributes[i].id])
        var ind = this.variant_attribute_value_names.findIndex((t) => t.attribute_id == this.product.attributes[i].id)
        if (this.product.attributes[i].values.length > 0) {
                this.$set(this.display_options,'attribute_'+this.product.attributes[i].id,value.name)
        this.variant_attribute_value_names[ind].value_name = value.name
        }
      }
      var variant = this.product.variants.find((obj) => obj.variant == slug)
      if(variant == null){
        this.variant = ''
        this.price = this.product.display_price
        this.stock = 0
        this.$toast.success(this.$t('product_not_available'))
      }
      else{
        this.price = variant.display_price
        this.stock = variant.stock
        this.variant = variant.variant
      }
    }
  },

  created(){
    this.currentlyActiveTemplate = this.allSettings.general_settings.currently_active_theme;

    this.price = this.product.display_price
    this.stock = this.product.stock
    if(this.product.product_type == 2 && this.product.attributes.length !=0){
      for (var i = 0; i < this.product.attributes.length; i++) {
          if (this.product.attributes[i].values.length > 0) {
                  this.$set(this.options,'attribute_'+this.product.attributes[i].id,this.product.attributes[i].values[0].slug)
        this.$set(this.display_options,'attribute_'+this.product.attributes[i].id,this.product.attributes[i].values[0].name)
        let variantAtt={
          attribute_id:this.product.attributes[i].id,
          attribute_name:this.product.attributes[i].name,
          value_name:this.product.attributes[i].values[0].name
        }
        this.variant_attribute_value_names.push(variantAtt)
          }


      }
      var slug = ''
      for (var i = 0; i < this.product.attributes.length; i++) {
        if(i == 0){
          slug = this.options['attribute_'+this.product.attributes[i].id]
        }
        else{
          slug = slug +'-'+this.options['attribute_'+this.product.attributes[i].id]
        }
      }
      var variant = this.product.variants.find((obj) => obj.variant == slug)
      if(variant == null){
        this.stock = 0
      }
      else{
        this.price = variant.display_price
        this.variant = variant.variant
        this.stock = variant.stock
      }
    }
    if(this.product.flash_sale && this.product.product_type != 2){
      this.flash_sale_price = this.product.flash_sale.display_price

    }
    if(this.product.special_sale && this.product.product_type != 2){
      this.special_sale_price = this.product.special_sale.display_price

    }
      this.quantity = this.product.min_order

      this.wishlist = this.product.is_wishlisted;
  },
  computed: {
    ...mapGetters({
      allCompareProducts: "Web/General/allCompareProducts",
       allSettings: "allDefaultSettings",
    }),
  },
};
</script>

<style>

</style>
