(window.webpackJsonp=window.webpackJsonp||[]).push([[301,44,84],{1428:function(t,e,r){"use strict";r.r(e);var n=r(0),c=(r(5),{props:["products"],data:function(){return{key:1,product_detail:"",settings:{slidesToShow:6,responsive:[{breakpoint:992,settings:{slidesToShow:3}},{breakpoint:768,settings:{slidesToShow:2}},{breakpoint:576,settings:{slidesToShow:1,slidesToScroll:1}}]},active_category:""}},fetch:function(){return Object(n.a)(regeneratorRuntime.mark((function t(){return regeneratorRuntime.wrap((function(t){for(;;)switch(t.prev=t.next){case 0:case"end":return t.stop()}}),t)})))()},methods:{changeProductDetail:function(t){this.product_detail=t}},computed:{},watch:{products:function(){this.key+=1}}}),o=r(71),component=Object(o.a)(c,(function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("section",{staticClass:"col-12 featured-items"},[r("div",{staticClass:"container"},[r("div",{staticClass:"row"},[r("div",{staticClass:"col-12"},[r("h2",{staticClass:"section-heading mb-5 text-start"},[t._v("Related Products")]),t._v(" "),r("VueSlickCarousel",t._b({key:t.key,staticClass:"related-pro"},"VueSlickCarousel",t.settings,!1),t._l(t.products,(function(t){return r("div",{key:t.id},[r("Template2FeaturedProductCard",{attrs:{modal_id:"product_detail_quickview",product:t}})],1)})),0)],1)])])])}),[],!1,null,null,null);e.default=component.exports;installComponents(component,{Template2FeaturedProductCard:r(965).default})},662:function(t,e,r){t.exports=r.p+"img/defult-product-img.e4aa9fc.png"},664:function(t,e,r){"use strict";r.r(e);var n={props:["rating"],data:function(){return{}}},c=r(71),component=Object(c.a)(n,(function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("div",{staticClass:"stars",style:{"--rating":t.rating},attrs:{"aria-label":"Rating of this product is 2.3 out of 5."}},[r("span",[t._v("("+t._s(this.rating)+")")])])}),[],!1,null,null,null);e.default=component.exports},965:function(t,e,r){"use strict";r.r(e);r(43),r(25),r(7),r(57),r(40),r(58);var n=r(0),c=r(21),o=(r(50),r(60),r(101),r(4),r(5),r(129));function d(object,t){var e=Object.keys(object);if(Object.getOwnPropertySymbols){var r=Object.getOwnPropertySymbols(object);t&&(r=r.filter((function(t){return Object.getOwnPropertyDescriptor(object,t).enumerable}))),e.push.apply(e,r)}return e}function l(t){for(var i=1;i<arguments.length;i++){var source=null!=arguments[i]?arguments[i]:{};i%2?d(Object(source),!0).forEach((function(e){Object(c.a)(t,e,source[e])})):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(source)):d(Object(source)).forEach((function(e){Object.defineProperty(t,e,Object.getOwnPropertyDescriptor(source,e))}))}return t}var _={props:{product:{required:!0},modal_id:{required:!1,default:"product_detail_quickview"},small:{default:!1,required:!1,type:Boolean},grid_class:{default:"",required:!1}},data:function(){return{wishlist:!1}},methods:l(l({},Object(o.b)({fetchCartItems:"Web/Cart/fetchCartItems",fetchWishlistItems:"Web/Wishlist/fetchWishlistItems",fetchCompareProducts:"Web/General/fetchCompareProducts"})),{},{detailModalProductChanged:function(t){this.$root.$emit("detailModalProductChanged",t)},addToCart:function(){var t=this;return Object(n.a)(regeneratorRuntime.mark((function e(){return regeneratorRuntime.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:if(!t.product.is_available){e.next=9;break}if(2!=t.product.product_type){e.next=5;break}t.$router.push("/product/".concat(t.product.slug)),e.next=7;break;case 5:return e.next=7,t.$webService.addCartItem({product_id:t.product.id,quantity:1}).then(function(){var e=Object(n.a)(regeneratorRuntime.mark((function e(r){return regeneratorRuntime.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:if(!r.success){e.next=6;break}return t.$toast.success(r.message),e.next=4,t.fetchCartItems();case 4:e.next=7;break;case 6:t.$toast.error(r.message);case 7:case"end":return e.stop()}}),e)})));return function(t){return e.apply(this,arguments)}}());case 7:e.next=10;break;case 9:t.$toast.error(t.$t("product_not_available"));case 10:case"end":return e.stop()}}),e)})))()},addToComparelist:function(){var t=this;return Object(n.a)(regeneratorRuntime.mark((function e(){var r,n;return regeneratorRuntime.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:r=JSON.parse(localStorage.getItem("compare_products")),t.allCompareProducts&&0!=t.allCompareProducts.products.length?3==t.allCompareProducts.products.length?t.$toast.error(t.$t("compare_already_three_products_message")):r.includes(t.product.id)?t.$toast.error(t.$t("compare_product_already_exist")):(r.push(t.product.id),localStorage.setItem("compare_products",JSON.stringify(r)),t.$toast.success(t.$t("product_is_added_to_compare_list")),t.fetchCompareProducts({compare_ids:r})):((n=[]).push(t.product.id),localStorage.setItem("compare_products",JSON.stringify(n)),t.fetchCompareProducts({compare_ids:n}),t.$toast.success(t.$t("product_is_added_to_compare_list")));case 2:case"end":return e.stop()}}),e)})))()},addToWishlist:function(){var t=this;return Object(n.a)(regeneratorRuntime.mark((function e(){return regeneratorRuntime.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:if(!t.$auth.loggedIn||!t.$gates.hasRole("customer")){e.next=5;break}return e.next=3,t.$webService.addWishlistItem({product_id:t.product.id,quantity:1}).then(function(){var e=Object(n.a)(regeneratorRuntime.mark((function e(r){return regeneratorRuntime.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,t.fetchWishlistItems();case 2:0==r.success?t.$toast.error(r.data.message):(t.wishlist=!0,t.$toast.success(r.data.message));case 3:case"end":return e.stop()}}),e)})));return function(t){return e.apply(this,arguments)}}());case 3:e.next=6;break;case 5:t.$toast.error(t.$t("please_login_first"));case 6:case"end":return e.stop()}}),e)})))()}}),computed:l({image:function(){if(this.product.media){var image=this.product.media.find((function(t){return"image"==t.type}));return image||null}return null}},Object(o.c)({allCompareProducts:"Web/General/allCompareProducts"}))},m=_,f=r(71),component=Object(f.a)(m,(function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",{staticClass:"card bg-white featured-items-card p-0 border-0 shadow-none product-hover rounded-0 bg-transparent mt-0",class:t.small?"featured-small":""},[n("div",{staticClass:"img-wrap bg-secondary hover-img"},[t.image?n("img",{staticClass:"border-2",attrs:{src:"/backend"+t.image.thumbnails.large.thumbnail,alt:t.image.alt_text}}):n("img",{staticClass:"border-2",attrs:{src:r(662),alt:""}}),t._v(" "),t._l(t.product.tags,(function(e,r){return n("span",{key:e,staticClass:"badge",class:r%2==0?"bg-primary":"bg-danger"},[t._v(t._s(e))])})),t._v(" "),n("div",{staticClass:"popup-product bg-white rounded-1 p-2"},[n("div",{staticClass:"img-wrap bg-secondary"},[t.image?n("img",{staticClass:"border-2",attrs:{src:"/backend"+t.image.thumbnails.large.thumbnail,alt:t.image.alt_text}}):n("img",{staticClass:"border-2",attrs:{src:r(662),alt:""}}),t._v(" "),t._l(t.product.tags,(function(e,r){return n("span",{key:e,staticClass:"badge",class:r%2==0?"bg-primary":"bg-danger"},[t._v(t._s(e))])}))],2),t._v(" "),n("div",{staticClass:"card-body text-center py-0 px-4"},[n("div",{staticClass:"\n              price-icon\n              d-flex\n              flex-row\n              justify-content-center\n              align-items-start flex-column h-100\n              "},[n("div",{staticClass:"w-100 border-bottom mb-3 pb-3"},[n("h6",{staticClass:"fw-bold mb-1 text-start"},[n("nuxt-link",{attrs:{to:"/product/"+t.product.slug}},[t._v("\n                      "+t._s(t.product.name)+"\n                      ")])],1),t._v(" "),t.product.flash_sale?n("div",{staticClass:"product-price d-flex align-items-center"},[n("span",{staticClass:"price"},[t._v("\n                      "+t._s(t.product.flash_sale.display_price)+"\n                  ")]),t._v(" "),n("span",{staticClass:"actual-price"},[t._v("\n                      "+t._s(t.product.display_price)+"\n                  ")])]):t.product.special_sale?n("div",{staticClass:"product-price d-flex align-items-center"},[n("span",{staticClass:"price"},[t._v("\n                      "+t._s(t.product.special_sale.display_price)+"\n                  ")]),t._v(" "),n("span",{staticClass:"actual-price"},[t._v("\n                      "+t._s(t.product.display_price)+"\n                  ")])]):n("div",{staticClass:"product-price d-flex align-items-center"},[t.product.attributes&&t.product.attributes.length>0?n("span",[t._v("\n              "+t._s(t.$t("starting_from_price"))+"\n              "),t.product.attributes&&t.product.attributes.length>0?n("span",{staticClass:"price"},[t._v("\n              "+t._s(t.product.starting_from_price)+"\n              ")]):t._e()]):n("span",[n("span",{staticClass:"price"},[t._v("\n              "+t._s(t.product.display_price)+"\n              ")])])])]),t._v(" "),n("div",{staticClass:"w-100 mt-auto pb-4"},[2==t.product.product_type?n("button",{staticClass:"\n                  btn bg-black\n                  text-white\n                  rounded-0\n                  fw-bold\n                  fs-7\n                  py-1\n                  w-100\n              ",on:{click:function(e){return t.$router.push("/product/"+t.product.slug)}}},[t._v("\n              "+t._s(t.$t("view"))+"\n              ")]):n("button",{staticClass:"\n                  btn bg-black\n                  text-white\n                  rounded-0\n                  fw-bold\n                  fs-7\n                  py-1\n                  w-100\n              ",attrs:{disabled:t.product.stock<t.product.min_order},on:{click:function(e){return t.addToCart()}}},[t._v("\n              "+t._s(t.$t("Add to Cart"))+"\n              ")]),t._v(" "),n("nuxt-link",{staticClass:"btn bg-black\n                  text-white\n                  rounded-0\n                  fw-bold\n                  fs-7\n                  py-1\n                  w-100\n                  mt-2",attrs:{to:"/product/"+t.product.slug}},[t._v("\n                      "+t._s("Go to Product")+"\n              ")])],1)])])])],2),t._v(" "),n("div",{staticClass:"card-body text-start py-2 px-0 d-flex flex-column justify-content-start align-items-start"},[n("h6",{staticClass:"fw-bold mb-1 mt-2"},[n("nuxt-link",{attrs:{to:"/product/"+t.product.slug}},[t._v("\n          "+t._s(t.product.name)+"\n          ")])],1),t._v(" "),n("div",{staticClass:"star-rating mb-1"},[n("GlobalRating",{attrs:{rating:t.product.reviews_average_rating}})],1),t._v(" "),"col-12"==t.grid_class?n("p",{staticClass:"prod-detail"},[t._v("\n          "+t._s(t.product.description)+"\n      ")]):t._e(),t._v(" "),n("div",{staticClass:"\n          price-icon\n          d-flex\n          flex-row\n          justify-content-center\n          align-items-center\n          "},[t.product.flash_sale?n("div",{staticClass:"product-price d-flex align-items-center"},[n("span",{staticClass:"price"},[t._v("\n              "+t._s(t.product.flash_sale.display_price)+"\n          ")]),t._v(" "),n("span",{staticClass:"actual-price"},[t._v("\n              "+t._s(t.product.display_price)+"\n          ")])]):t.product.special_sale?n("div",{staticClass:"product-price d-flex align-items-center"},[n("span",{staticClass:"price"},[t._v("\n              "+t._s(t.product.special_sale.display_price)+"\n          ")]),t._v(" "),n("span",{staticClass:"actual-price"},[t._v("\n              "+t._s(t.product.display_price)+"\n          ")])]):n("div",{staticClass:"product-price d-flex align-items-center"},[t.product.attributes&&t.product.attributes.length>0?n("span",[t._v("\n                  "+t._s(t.$t("starting_from_price"))+"\n                  "),t.product.attributes&&t.product.attributes.length>0?n("span",{staticClass:"price"},[t._v("\n                  "+t._s(t.product.starting_from_price)+"\n                  ")]):t._e()]):n("span",[n("span",{staticClass:"price"},[t._v("\n                  "+t._s(t.product.display_price)+"\n                  ")])])])])])])}),[],!1,null,null,null);e.default=component.exports;installComponents(component,{GlobalRating:r(664).default})}}]);