(window.webpackJsonp=window.webpackJsonp||[]).push([[330,108,152,244],{1086:function(t,e,r){"use strict";r.r(e);r(43),r(25),r(7),r(4),r(57),r(40),r(58);var n=r(21),l=r(129);function o(object,t){var e=Object.keys(object);if(Object.getOwnPropertySymbols){var r=Object.getOwnPropertySymbols(object);t&&(r=r.filter((function(t){return Object.getOwnPropertyDescriptor(object,t).enumerable}))),e.push.apply(e,r)}return e}var c={data:function(){return{currentlyActiveTemplate:"",Step:1,thankYou:!1,customer_credentials:{},order_num:"",ordered_id:""}},created:function(){this.currentlyActiveTemplate=this.allSettings.general_settings.currently_active_theme},fetch:function(){},methods:{order_nunber:function(t){this.order_num=t},order_id:function(t){this.ordered_id=t},customer:function(t){this.customer_credentials=t}},computed:function(t){for(var i=1;i<arguments.length;i++){var source=null!=arguments[i]?arguments[i]:{};i%2?o(Object(source),!0).forEach((function(e){Object(n.a)(t,e,source[e])})):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(source)):o(Object(source)).forEach((function(e){Object.defineProperty(t,e,Object.getOwnPropertyDescriptor(source,e))}))}return t}({},Object(l.c)({allCartItems:"Web/Cart/allCartItems",allSettings:"allDefaultSettings"})),auth:!1},d=c,m=r(71),component=Object(m.a)(d,(function(){var t=this,e=this,r=e.$createElement,n=e._self._c||r;return e.$fetchState.pending||!e.allCartItems||null==e.currentlyActiveTemplate||""==e.currentlyActiveTemplate?n("section",{staticClass:"product-order mt-0"},[n("WebsiteGlobalComponentsBreadCrumb",{attrs:{page:"product_order"}})],1):0!=e.allCartItems.cart_items.length||5==e.Step||e.thankYou?e.thankYou?n("section",[n("div",[n("WebsiteOrderFormStepsTemplate1ThankYou",{attrs:{customer_credentials:e.customer_credentials,order_num:e.order_num,ordered_id:e.ordered_id}})],1)]):n("section",{staticClass:"product-order mt-0"},[n("WebsiteGlobalComponentsBreadCrumb",{attrs:{page:"product_order"}}),e._v(" "),"Template1"==e.currentlyActiveTemplate?n("WebsiteTemplate1CheckoutPage"):e._e(),e._v(" "),"Template2"==e.currentlyActiveTemplate?n("WebsiteTemplate2CheckoutPage",{on:{showThankYouPage:function(e){return t.thankYou=e},customer:e.customer,order_nunber:e.order_nunber,order_id:e.order_id}}):e._e(),e._v(" "),n("WebsiteTemplate1NewsLetterSection")],1):n("section",{staticClass:"my-cart mt-0"},[n("WebsiteOrderFormSteps"+e.currentlyActiveTemplate+"ContinueShopping",{tag:"Component"})],1)}),[],!1,null,null,null);e.default=component.exports;installComponents(component,{WebsiteGlobalComponentsBreadCrumb:r(687).default,WebsiteOrderFormStepsTemplate1ThankYou:r(865).default,WebsiteTemplate1CheckoutPage:r(1051).default,WebsiteTemplate2CheckoutPage:r(916).default,WebsiteTemplate1NewsLetterSection:r(691).default})},677:function(t,e,r){var content=r(690);content.__esModule&&(content=content.default),"string"==typeof content&&(content=[[t.i,content,""]]),content.locals&&(t.exports=content.locals);(0,r(131).default)("e62035f2",content,!0,{sourceMap:!1})},687:function(t,e,r){"use strict";r.r(e);r(43),r(25),r(7),r(4),r(57),r(40),r(58);var n=r(21),l=r(129);function o(object,t){var e=Object.keys(object);if(Object.getOwnPropertySymbols){var r=Object.getOwnPropertySymbols(object);t&&(r=r.filter((function(t){return Object.getOwnPropertyDescriptor(object,t).enumerable}))),e.push.apply(e,r)}return e}var c={props:["page","post","product"],data:function(){return{currentlyActiveTemplate:""}},created:function(){this.currentlyActiveTemplate=this.allSettings.general_settings.currently_active_theme},computed:function(t){for(var i=1;i<arguments.length;i++){var source=null!=arguments[i]?arguments[i]:{};i%2?o(Object(source),!0).forEach((function(e){Object(n.a)(t,e,source[e])})):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(source)):o(Object(source)).forEach((function(e){Object.defineProperty(t,e,Object.getOwnPropertyDescriptor(source,e))}))}return t}({},Object(l.c)({allSettings:"allDefaultSettings"}))},d=c,m=r(71),component=Object(m.a)(d,(function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("section",{staticClass:"site-breadcrumb bg-secondary py-3 mt-0 mb-0"},["Template1"==t.currentlyActiveTemplate?r("div",{staticClass:"container"},[r("div",{staticClass:"row"},[r("div",{staticClass:"col"},[r("nav",{attrs:{"aria-label":"breadcrumb"}},[r("ol",{staticClass:"breadcrumb"},[r("li",{staticClass:"breadcrumb-item"},[r("nuxt-link",{staticClass:"text-medium text-decoration-none",attrs:{to:"/"}},[t._v("\n                "+t._s(this.$t("home"))+"\n              ")])],1),t._v(" "),"blog_detail"==t.page?r("li",{staticClass:"breadcrumb-item"},[r("nuxt-link",{staticClass:"text-medium text-decoration-none",attrs:{to:"/blog"}},[t._v("\n                "+t._s(this.$t("blog"))+"\n              ")])],1):t._e(),t._v(" "),"product_detail"==t.page?r("li",{staticClass:"breadcrumb-item"},[r("nuxt-link",{staticClass:"text-medium text-decoration-none",attrs:{to:"/shop"}},[t._v("\n                "+t._s(this.$t("products"))+"\n              ")])],1):t._e(),t._v(" "),"order_details"==t.page?r("li",{staticClass:"breadcrumb-item"},[r("nuxt-link",{staticClass:"text-medium text-decoration-none",attrs:{to:"/customer/orders"}},[t._v("\n                "+t._s(this.$t("my_orders"))+"\n              ")])],1):t._e(),t._v(" "),"blog_detail"==t.page?r("li",{staticClass:"breadcrumb-item active",attrs:{"aria-current":"page"}},[t._v(t._s(this.post))]):"product_detail"==t.page?r("li",{staticClass:"breadcrumb-item active",attrs:{"aria-current":"page"}},[t._v(t._s(this.product))]):"order_details"==t.page?r("li",{staticClass:"breadcrumb-item active",attrs:{"aria-current":"page"}},[t._v(t._s(t.$t("order_details")))]):r("li",{staticClass:"breadcrumb-item active",attrs:{"aria-current":"page"}},[t._v(t._s(this.$t(this.page)))])])])])])]):t._e(),t._v(" "),"Template2"==t.currentlyActiveTemplate?r("div",{staticClass:"container"},[r("div",{staticClass:"row mx-0"},[r("div",{staticClass:"col px-0"},[r("nav",{attrs:{"aria-label":"breadcrumb"}},[r("ol",{staticClass:"breadcrumb"},[r("li",{staticClass:"breadcrumb-item"},[r("nuxt-link",{staticClass:"text-gray text-decoration-none",attrs:{to:"/"}},[t._v("\n                "+t._s(this.$t("home"))+"\n              ")])],1),t._v(" "),"blog_detail"==t.page?r("li",{staticClass:"breadcrumb-item"},[r("nuxt-link",{staticClass:"text-gray text-decoration-none",attrs:{to:"/blog"}},[t._v("\n                "+t._s(this.$t("blog"))+"\n              ")])],1):t._e(),t._v(" "),"product_detail"==t.page?r("li",{staticClass:"breadcrumb-item"},[r("nuxt-link",{staticClass:"text-gray text-decoration-none",attrs:{to:"/shop"}},[t._v("\n                "+t._s(this.$t("products"))+"\n              ")])],1):t._e(),t._v(" "),"order_details"==t.page?r("li",{staticClass:"breadcrumb-item"},[r("nuxt-link",{staticClass:"text-gray text-decoration-none",attrs:{to:"/customer/orders"}},[t._v("\n                "+t._s(this.$t("my_orders"))+"\n              ")])],1):t._e(),t._v(" "),"blog_detail"==t.page?r("li",{staticClass:"breadcrumb-item active",attrs:{"aria-current":"page"}},[t._v(t._s(this.post))]):"product_detail"==t.page?r("li",{staticClass:"breadcrumb-item active",attrs:{"aria-current":"page"}},[t._v(t._s(this.product))]):"order_details"==t.page?r("li",{staticClass:"breadcrumb-item active",attrs:{"aria-current":"page"}},[t._v(t._s(t.$t("order_details")))]):r("li",{staticClass:"breadcrumb-item active",attrs:{"aria-current":"page"}},[t._v(t._s(this.$t(this.page)))])])])])])]):t._e()])}),[],!1,null,null,null);e.default=component.exports},689:function(t,e,r){"use strict";r(677)},690:function(t,e,r){var n=r(130)((function(i){return i[1]}));n.push([t.i,".cursor-pointer{cursor:pointer}",""]),n.locals={},t.exports=n},691:function(t,e,r){"use strict";r.r(e);var n=r(0),l=(r(5),{data:function(){return{formData:{email:""}}},methods:{add_email:function(){var t=this;return Object(n.a)(regeneratorRuntime.mark((function e(){return regeneratorRuntime.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,t.$webService.addNewsletterEmail({email:t.formData.email}).then(function(){var e=Object(n.a)(regeneratorRuntime.mark((function e(r){return regeneratorRuntime.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:0==r.success?t.$toast.error(t.$t("subscription_email_already_exists_message")):(t.formData.email="",t.$toast.success(t.$t("subscription_email_added_message")));case 1:case"end":return e.stop()}}),e)})));return function(t){return e.apply(this,arguments)}}()).catch(function(){var e=Object(n.a)(regeneratorRuntime.mark((function e(r){return regeneratorRuntime.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:r.response.data.errors&&(t.error=r.response.data.errors,t.error.email&&t.$toast.error(t.error.email[0]));case 1:case"end":return e.stop()}}),e)})));return function(t){return e.apply(this,arguments)}}());case 2:case"end":return e.stop()}}),e)})))()}}}),o=l,c=(r(689),r(71)),component=Object(c.a)(o,(function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("section",{staticClass:"news-letter m-0 news-temp2"},[r("div",{staticClass:"news-letter-mail py-5 mt-5"},[r("div",{staticClass:"container"},[r("div",{staticClass:"row"},[r("div",{staticClass:"col-sm-6 pe-5"},[r("h2",{staticClass:"text-uppercase"},[t._v(t._s(this.$t("web.home.news.newsletter.heading")))]),t._v(" "),r("p",[t._v(t._s(this.$t("web.home.news.newsletter.description")))])]),t._v(" "),r("div",{staticClass:"col-sm-6 my-auto"},[r("div",{staticClass:"input-group mail shadow-sm"},[r("input",{directives:[{name:"model",rawName:"v-model",value:t.formData.email,expression:"formData.email"}],staticClass:"form-control border rounded px-3",attrs:{placeholder:t.$t("enter_email"),type:"email"},domProps:{value:t.formData.email},on:{keyup:function(e){return!e.type.indexOf("key")&&t._k(e.keyCode,"enter",13,e.key,"Enter")?null:t.add_email()},input:function(e){e.target.composing||t.$set(t.formData,"email",e.target.value)}}}),t._v(" "),r("span",{staticClass:"\n                input-group-append\n                position-absolute\n                top-50\n                end-0\n                translate-middle-y\n                me-3\n                cursor-pointer\n              ",on:{click:function(e){return t.add_email()}}},[r("fa",{attrs:{icon:["fa","paper-plane"]}})],1)])])])])])])}),[],!1,null,null,null);e.default=component.exports},786:function(t,e,r){"use strict";r.r(e);r(43),r(25),r(7),r(4),r(57),r(40),r(58);var n=r(21),l=(r(33),r(81),r(702),r(133),r(82),r(129));function o(object,t){var e=Object.keys(object);if(Object.getOwnPropertySymbols){var r=Object.getOwnPropertySymbols(object);t&&(r=r.filter((function(t){return Object.getOwnPropertyDescriptor(object,t).enumerable}))),e.push.apply(e,r)}return e}var c={props:["shipping_value"],data:function(){return{shippingApply:!1,totalAfterShipping:""}},methods:{format_number:function(t,e){return t.toFixed(e).replace(/(\d)(?=(\d{3})+\.)/g,"$1,")}},computed:function(t){for(var i=1;i<arguments.length;i++){var source=null!=arguments[i]?arguments[i]:{};i%2?o(Object(source),!0).forEach((function(e){Object(n.a)(t,e,source[e])})):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(source)):o(Object(source)).forEach((function(e){Object.defineProperty(t,e,Object.getOwnPropertyDescriptor(source,e))}))}return t}({},Object(l.c)({allCartItems:"Web/Cart/allCartItems"})),created:function(){if(this.allCartItems.discount){var t=this.allCartItems.subtotal.split(",").join(""),e=parseFloat(t)-parseFloat(this.allCartItems.discount);e=this.format_number(e,this.allCartItems.currency_decimal),this.allCartItems.total=e}},watch:{shipping_value:{immediate:!0,handler:function(t,e){if(t)if(this.allCartItems.total){this.shippingApply=!0;var r=this.allCartItems.total.split(",").join(""),n=parseFloat(r)+parseFloat(t);this.totalAfterShipping=this.format_number(n,this.allCartItems.currency_decimal)}else{this.shippingApply=!0;var l=this.allCartItems.subtotal.split(",").join(""),o=parseFloat(l)+parseFloat(t);this.totalAfterShipping=this.format_number(o,this.allCartItems.currency_decimal)}else this.shippingApply=!1}}}},d=c,m=r(71),component=Object(m.a)(d,(function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",{staticClass:"cart-summary bg-secondary p-4 mt-5 mt-100"},[n("div",{staticClass:"d-flex justify-content-between align-items-center mb-4 px-3"},[n("h5",{staticClass:"fw-bold mb-0 fs-4"},[t._v("\n      "+t._s(this.$t("order_summary"))+"\n    ")]),t._v(" "),n("a",{staticClass:"text-primary text-uppercase text-decoration-none fw-bold fs-7",attrs:{href:"#"}})]),t._v(" "),n("div",{staticClass:"cart-summary-widget px-3"},[t.allCartItems?n("ul",{staticClass:"product-list"},t._l(t.allCartItems.cart_items,(function(e){return n("li",{key:e.id},[e.product.media&&e.product.media[0]&&e.product.media[0].thumbnails?n("div",{staticClass:"item-img"},[n("img",{staticClass:"img-fluid",attrs:{src:"/backend"+e.product.media[0].thumbnails.small.thumbnail,alt:"Product Image"}})]):n("div",{staticClass:"item-img"},[n("img",{staticClass:"img-fluid",attrs:{src:r(662),alt:"Product Image"}})]),t._v(" "),n("div",{staticClass:"item-detail-wrap d-flex flex-grow-1 align-items-start"},[n("div",{staticClass:"item-detail"},[n("h6",[n("nuxt-link",{attrs:{to:"/product/"+e.product.slug}},[t._v("\n                "+t._s(e.product.name)+"\n              ")])],1)]),t._v(" "),n("div",{staticClass:"item-s"},[t._v("\n            "+t._s(e.quantity)+" x "+t._s(e.single_price)+"\n          ")])])])})),0):t._e(),t._v(" "),n("ul",{staticClass:"product-detail-list"},[n("li",[n("ul",[n("li",[n("h6",[t._v(t._s(this.$t("sub_total")))]),t._v(" "),n("div",{staticClass:"item-s"},[t._v("\n              "+t._s(t.allCartItems?t.allCartItems.subtotal_with_currency:0)+"\n            ")])])])]),t._v(" "),t.allCartItems.discount?n("li",[n("ul",[n("li",[n("h6",[t._v(t._s(this.$t("discount")))]),t._v(" "),"rlt"==t.allCartItems.currency_direction?n("div",{staticClass:"item-s"},[t._v("\n              "+t._s(t.allCartItems?t.allCartItems.discount:0)+"\n              "+t._s(t.allCartItems.symbol)+"\n            ")]):t._e(),t._v(" "),"ltr"==t.allCartItems.currency_direction?n("div",{staticClass:"item-s "},[t._v("\n              "+t._s(t.allCartItems.symbol)+" "+t._s(t.allCartItems?t.allCartItems.discount:0)+"\n            ")]):t._e()])])]):t._e(),t._v(" "),t.shipping_value?n("li",[n("ul",[n("li",[n("h6",{staticClass:"text-start"},[t._v(t._s(this.$t("shipping")))]),t._v(" "),"rlt"==t.allCartItems.currency_direction?n("div",{staticClass:"item-s text-end"},[t._v("\n              "+t._s(t.shipping_value)+" "+t._s(t.allCartItems.symbol)+"\n            ")]):t._e(),t._v(" "),"ltr"==t.allCartItems.currency_direction?n("div",{staticClass:"item-s text-end"},[t._v("\n              "+t._s(t.allCartItems.symbol)+" "+t._s(t.shipping_value)+"\n            ")]):t._e()])])]):t._e(),t._v(" "),t.shippingApply?n("li",[n("h6",[t._v(t._s(this.$t("total")))]),t._v(" "),"rlt"==t.allCartItems.currency_direction?n("div",{staticClass:"total-price item-s "},[t._v("\n          "+t._s(t.totalAfterShipping)+" "+t._s(t.allCartItems.symbol)+"\n        ")]):t._e(),t._v(" "),"ltr"==t.allCartItems.currency_direction?n("div",{staticClass:"total-price item-s "},[t._v("\n         "+t._s(t.allCartItems.symbol)+" "+t._s(t.totalAfterShipping)+"\n        ")]):t._e()]):n("li",[n("h6",[t._v(t._s(this.$t("total")))]),t._v(" "),"rlt"==t.allCartItems.currency_direction?n("div",{staticClass:"total-price item-s "},[t._v("\n          "+t._s(t.allCartItems.total?t.allCartItems.total:t.allCartItems.subtotal)+"\n          "+t._s(t.allCartItems.symbol)+"\n        ")]):t._e(),t._v(" "),"ltr"==t.allCartItems.currency_direction?n("div",{staticClass:"total-price item-s "},[t._v("\n           "+t._s(t.allCartItems.symbol)+"  "+t._s(t.allCartItems.total?t.allCartItems.total:t.allCartItems.subtotal)+"\n        ")]):t._e()])])])])}),[],!1,null,null,null);e.default=component.exports},787:function(t,e,r){"use strict";r.r(e);r(43),r(25),r(7),r(4),r(57),r(40),r(58);var n=r(21),l=r(0),o=(r(5),r(129));function c(object,t){var e=Object.keys(object);if(Object.getOwnPropertySymbols){var r=Object.getOwnPropertySymbols(object);t&&(r=r.filter((function(t){return Object.getOwnPropertyDescriptor(object,t).enumerable}))),e.push.apply(e,r)}return e}function d(t){for(var i=1;i<arguments.length;i++){var source=null!=arguments[i]?arguments[i]:{};i%2?c(Object(source),!0).forEach((function(e){Object(n.a)(t,e,source[e])})):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(source)):c(Object(source)).forEach((function(e){Object.defineProperty(t,e,Object.getOwnPropertyDescriptor(source,e))}))}return t}var m={data:function(){return{loading:!1,payment_error:"",formData:{payment_method_code:"",cardInfo:{number:"",exp_month:"",exp_year:"",cvc:""},billing_address:{},shipping_address:{},shipping_id:"",shipping_value:"",plateForm:"web",paytm_mode:"",coupon_id:""},order_nunber:"",order_id:"",guest_customer_credentials:{},errors:{}}},fetch:function(){return Object(l.a)(regeneratorRuntime.mark((function t(){return regeneratorRuntime.wrap((function(t){for(;;)switch(t.prev=t.next){case 0:case"end":return t.stop()}}),t)})))()},computed:d({},Object(o.c)({allSettings:"allDefaultSettings",allCartItems:"Web/Cart/allCartItems"})),props:["payment_details","shipping_details","shipping_method_id","billing_details","shipping_method_value","isPaymentMethodSelected"],methods:d(d({},Object(o.b)({fetchCartItems:"Web/Cart/fetchCartItems"})),{},{executePayment:function(){var t=this;return Object(l.a)(regeneratorRuntime.mark((function e(){return regeneratorRuntime.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return t.loading=!0,t.formData.billing_address=t.billing_details,t.formData.shipping_address=t.shipping_details,t.formData.shipping_id=t.shipping_method_id,t.formData.shipping_value=t.shipping_method_value,t.formData.payment_method_code=t.payment_details.payment_method_code,t.formData.cardInfo.number=t.payment_details.number,t.formData.cardInfo.exp_month=t.payment_details.exp_month,t.formData.cardInfo.exp_year=t.payment_details.exp_year,t.formData.cardInfo.cvc=t.payment_details.cvc,t.formData.paytm_mode=t.payment_details.paytm_mode,e.next=13,t.$webService.executePayment(t.formData).then((function(e){var r;(t.loading=!1,e.response)?(t.errors=null!==(r=e.response.data.errors)&&void 0!==r?r:e.response.data,t.$toast.error(e.response.data.message)):(e.success&&(t.payment_error="",e.captured&&(t.fetchCartItems(),t.order_nunber=e.data.order_detail.order_number,t.order_id=e.data.order_detail.order_id,e.data.customer_credentials&&(t.guest_customer_credentials=e.data.customer_credentials),t.$emit("customer",t.guest_customer_credentials),t.$emit("order_nunber",t.order_nunber),t.$emit("order_id",t.order_id),t.$emit("showThankYouPage",!0)),e.authorization_required&&(t.$cookies.set("payment_method_code",t.formData.payment_method_code),t.$cookies.set("order_id",e.data.order_detail.order_id),t.$cookies.set("order_number",e.data.order_detail.order_number),window.location.href=e.authorization_url)),e.success||t.$toast.error(e.message),e.data.message&&(t.payment_error=e.data.message),t.errors={})})).catch((function(e){t.loading=!1,t.errors=e.response.data.errors}));case 13:case"end":return e.stop()}}),e)})))()}}),watch:{guest_customer_credentials:{deep:!0,handler:function(){this.$emit("guest_customer_credentials",this.guest_customer_credentials)}},errors:{deep:!0,handler:function(){this.$emit("errors",this.errors)}}},mounted:function(){this.formData.coupon_id=this.allCartItems.coupon_id?this.allCartItems.coupon_id:""}},_=r(71),component=Object(_.a)(m,(function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("div",{staticClass:"order-form-btns text-center d-flex flex-column px-5 py-4 bg-secondary"},[r("div",{},[t.payment_error?r("span",{staticClass:"float-end text-danger"},[r("b",[t._v(t._s(t.payment_error))])]):t._e()]),t._v(" "),t.allSettings&&t.allSettings.general_settings&&t.allSettings.general_settings.contact_number?r("div",{staticClass:"phone-no"},[r("span",{staticClass:"opacity-5"},[t._v(t._s(t.$t("web.btn_order.need_help_with_your_order")))]),t._v(" "),r("span",{staticClass:"text-primary fw-bold"},[t._v(t._s(t.$t("web.btn_order.hotline")))]),t._v(" "),r("span",{staticClass:"opacity-5"},[t._v(t._s(t.allSettings.general_settings.contact_number))])]):t._e(),t._v(" "),r("button",{staticClass:"btn bg-primary text-white rounded-1 py-2 lh-lg fw-bold text-uppercase mt-4 mx-3",attrs:{disabled:!t.isPaymentMethodSelected||t.loading},on:{click:t.executePayment}},[r("span",{staticClass:"btn-pro me-2"},[r("svg",{attrs:{xmlns:"http://www.w3.org/2000/svg","xmlns:xlink":"http://www.w3.org/1999/xlink",width:"24",height:"24",viewBox:"0 0 391.4 489"}},[r("defs",[r("linearGradient",{attrs:{id:"linear-gradient",x1:"0.872",y1:"0.137",x2:"0.029",y2:"0.988",gradientUnits:"objectBoundingBox"}},[r("stop",{attrs:{offset:"0","stop-color":"#40abfd"}}),t._v(" "),r("stop",{attrs:{offset:"1","stop-color":"#00f7fe"}})],1)],1),t._v(" "),r("g",{attrs:{id:"shopping",transform:"translate(-48.8)"}},[r("g",{attrs:{id:"Group_188","data-name":"Group 188"}},[r("path",{attrs:{id:"Path_316","data-name":"Path 316",d:"M440.1,422.7l-28-315.3a13.477,13.477,0,0,0-13.4-12.3H341.1a96.612,96.612,0,0,0-193.2,0H90.3a13.406,13.406,0,0,0-13.4,12.3l-28,315.3c0,.4-.1.8-.1,1.2,0,35.9,32.9,65.1,73.4,65.1H366.8c40.5,0,73.4-29.2,73.4-65.1A4.868,4.868,0,0,0,440.1,422.7ZM244.5,27a69.672,69.672,0,0,1,69.6,68.1H174.9A69.672,69.672,0,0,1,244.5,27ZM366.8,462H122.2c-25.4,0-46-16.8-46.4-37.5l26.8-302.3h45.2v41a13.5,13.5,0,0,0,27,0v-41H314.1v41a13.5,13.5,0,0,0,27,0v-41h45.2l26.9,302.3C412.8,445.2,392.1,462,366.8,462Z",fill:"url(#linear-gradient)"}})])])])]),t._v("\n        "+t._s(t.$t("web.btn_order.proceed_payment"))+"\n    ")])])}),[],!1,null,null,null);e.default=component.exports},916:function(t,e,r){"use strict";r.r(e);r(43),r(25),r(7),r(4),r(57),r(40),r(58);var n=r(21),l=r(129);function o(object,t){var e=Object.keys(object);if(Object.getOwnPropertySymbols){var r=Object.getOwnPropertySymbols(object);t&&(r=r.filter((function(t){return Object.getOwnPropertyDescriptor(object,t).enumerable}))),e.push.apply(e,r)}return e}var c={data:function(){return{thankYou:!1,isPaymentMethodSelected:!1,Step:1,previous:1,billing_details:{},shipping_method_id:"",shipping_method_value:"",shipping_details:{},details_payment:{},order_num:"",ordered_id:"",all_errors:{},customer_credentials:{},calculated_shipping_value:""}},fetch:function(){},computed:function(t){for(var i=1;i<arguments.length;i++){var source=null!=arguments[i]?arguments[i]:{};i%2?o(Object(source),!0).forEach((function(e){Object(n.a)(t,e,source[e])})):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(source)):o(Object(source)).forEach((function(e){Object.defineProperty(t,e,Object.getOwnPropertyDescriptor(source,e))}))}return t}({},Object(l.c)({allCartItems:"Web/Cart/allCartItems"})),methods:{changeStep:function(t){this.Step=t},step_click_with_shipping_data:function(t){var e=t.step,r=t.calculated_shipping_value;this.Step=e,this.calculated_shipping_value=r},details:function(t){this.details_payment=t},shipping_method_details:function(t){this.shipping_method_id=t.id,this.shipping_method_value=t.value},shipping_address:function(t){this.shipping_details=t},billing_address:function(t){this.billing_details=t},order_nunber:function(t){this.order_num=t},order_id:function(t){this.ordered_id=t},customer:function(t){this.customer_credentials=t},errors:function(t){this.all_errors=t},step_clicked:function(t){this.Step=t},showThankYouPage:function(t){this.$emit("customer",this.customer_credentials),this.$emit("order_nunber",this.order_num),this.$emit("order_id",this.ordered_id),this.$emit("showThankYouPage",t)}}},d=c,m=r(71),component=Object(m.a)(d,(function(){var t=this,e=this,r=e.$createElement,n=e._self._c||r;return n("div",[n("div",{staticClass:"container"},[1==e.Step&&e.$fetchState.pending?n("div",{staticClass:"row"},[e._m(0)]):n("div",{staticClass:"row"},[n("div",{staticClass:"col-lg-7 col-md-6 mb-3 mb-md-5"},[n("WebsiteOrderFormStepsTemplate2BillingAddressForm",{attrs:{all_errors:e.all_errors,billing_details:e.billing_details},on:{billing_address:e.billing_address,errors:e.errors,shipping_method_details:e.shipping_method_details,shipping_address:e.shipping_address,details:e.details,paymentMethodsFilled:function(e){return t.isPaymentMethodSelected=e}}})],1),e._v(" "),n("div",{staticClass:"col-lg-5 col-md-6 mb-5"},[n("WebsiteOrderFormStepsTemplate2CartSummary",{attrs:{shipping_value:e.shipping_method_value}}),e._v(" "),n("WebsiteOrderFormStepsTemplate2BtnOrder",{attrs:{shipping_details:e.shipping_details,shipping_method_id:e.shipping_method_id,shipping_method_value:e.shipping_method_value,billing_details:e.billing_details,payment_details:e.details_payment,isPaymentMethodSelected:e.isPaymentMethodSelected},on:{errors:e.errors,showThankYouPage:e.showThankYouPage,customer:e.customer,order_nunber:e.order_nunber,order_id:e.order_id}})],1)])])])}),[function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("div",{staticClass:"col-md-5 skeletion-effect"},[r("div",{staticClass:"cart-totals"},[r("div",{staticClass:"d-flex justify-content-between align-items-center mb-4"},[r("div",{staticClass:"h2 skeletion-animation"})]),t._v(" "),r("div",{staticClass:"cart-total-widget shadow rounded bg-secondary"},[r("ul",{staticClass:"product-list"},[r("li",[r("p",{staticClass:"text skeletion-animation"})]),t._v(" "),r("li",[r("p",{staticClass:"text skeletion-animation"})]),t._v(" "),r("li",[r("p",{staticClass:"text skeletion-animation"})])]),t._v(" "),r("div",{staticClass:"d-flex align-items-center flex-column text-center p-4"},[r("button",{staticClass:"btn text skeletion-animation btn-block"})])])])])}],!1,null,null,null);e.default=component.exports;installComponents(component,{WebsiteOrderFormStepsTemplate2BillingAddressForm:r(917).default,WebsiteOrderFormStepsTemplate2CartSummary:r(786).default,WebsiteOrderFormStepsTemplate2BtnOrder:r(787).default})}}]);