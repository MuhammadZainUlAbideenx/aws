(window.webpackJsonp=window.webpackJsonp||[]).push([[405,34],{1276:function(t,e,l){"use strict";l.r(e);var c=l(0),n=(l(5),{layout:"admin",middleware:["admin","permission"],meta:{permission:"currencies.index",strategy:"read"},data:function(){return{currency:"",error:!1}},fetch:function(){var t=this;return Object(c.a)(regeneratorRuntime.mark((function e(){var l,data;return regeneratorRuntime.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,t.$repositories.currencies.show(t.$route.params.id);case 2:l=e.sent,data=l.data,t.currency=data;case 5:case"end":return e.stop()}}),e)})))()},methods:{},mounted:function(){}}),o=l(71),component=Object(o.a)(n,(function(){var t=this,e=t.$createElement,l=t._self._c||e;return l("div",[l("div",{staticClass:"content-header"},[l("div",{staticClass:"row g-0 mb-2"},[l("div",{staticClass:"col-sm-12 px-0"},[l("h2",{staticClass:"m-0 text-body bold"},[t._v("\n          "+t._s(this.$t("form.currency.view_currency"))+"\n        ")])]),t._v(" "),l("div",{staticClass:"row"},[l("div",{staticClass:"col-sm-12 px-0"},[l("ol",{staticClass:"breadcrumb float-sm-right text-body"},[l("li",{staticClass:"breadcrumb-item"},[l("nuxt-link",{attrs:{to:t.localePath("/admin/dashboard")}},[t._v(t._s(this.$t("sidebar.home")))])],1),t._v(" "),l("li",{staticClass:"breadcrumb-item"},[l("nuxt-link",{attrs:{to:t.localePath("/admin/currencies")}},[t._v(t._s(this.$t("sidebar.currency")))])],1),t._v(" "),l("li",{staticClass:"breadcrumb-item active"},[t._v("\n              "+t._s(this.$t("form.view"))+"\n            ")])]),t._v(" "),l("p",{staticClass:"text-body-secondary"},[t._v("\n            "+t._s(this.$t("form.currency.view_description"))+"\n          ")])])])])]),t._v(" "),l("section",{staticClass:"content"},[t.$fetchState.pending?l("div",[l("AdminViewLoader")],1):l("div",{staticClass:"container"},[l("div",{staticClass:"card gutter-b border-0"},[l("div",{staticClass:"card-body"},[l("div",{staticClass:"row mb-2"},[l("div",{staticClass:"show-table px-0 mb-0"},[l("div",{staticClass:"row justify-content-end"},[l("div",{staticClass:"col-3"},[l("label",{attrs:{for:"input-live form-label"}},[t._v(t._s(this.$t("form.currency.name.label")))])]),t._v(" "),l("div",{staticClass:"col-3"},[l("p",[t._v(t._s(t.currency.name))])]),t._v(" "),l("div",{staticClass:"col-3"},[l("label",{attrs:{for:"input-live form-label"}},[t._v(t._s(this.$t("form.currency.direction.label")))])]),t._v(" "),l("div",{staticClass:"col-3"},[l("p",[t._v(t._s(t.currency.direction))])]),t._v(" "),l("div",{staticClass:"col-3"},[l("label",{attrs:{for:"input-live form-label"}},[t._v(t._s(this.$t("form.currency.code.label")))])]),t._v(" "),l("div",{staticClass:"col-3"},[l("p",[t._v(t._s(t.currency.code))])]),t._v(" "),l("div",{staticClass:"col-3"},[l("label",{attrs:{for:"input-live form-label"}},[t._v(t._s(this.$t("form.currency.symbol.label")))])]),t._v(" "),l("div",{staticClass:"col-3"},[l("p",[t._v(t._s(t.currency.symbol))])]),t._v(" "),l("div",{staticClass:"col-3"},[l("label",{attrs:{for:"input-live form-label"}},[t._v(t._s(this.$t("form.currency.decimal_places.label")))])]),t._v(" "),l("div",{staticClass:"col-3"},[l("p",[t._v(t._s(t.currency.decimal_places))])]),t._v(" "),l("div",{staticClass:"col-3"},[l("label",{attrs:{for:"input-live form-label"}},[t._v(t._s(this.$t("form.currency.status.label")))])]),t._v(" "),l("div",{staticClass:"col-3"},[l("div",{staticClass:"form-switch d-flex align-items-center"},[l("input",{staticClass:"form-check-input",attrs:{type:"checkbox",id:"flexSwitchCheckChecked",disabled:""},domProps:{checked:t.currency.is_active?"checked":""}})])]),t._v(" "),l("div",{staticClass:"col-3"},[l("label",{attrs:{for:"input-live form-label"}},[t._v(t._s(this.$t("form.currency.is_default.label")))])]),t._v(" "),l("div",{staticClass:"col-3"},[l("div",{staticClass:"form-switch d-flex align-items-center"},[l("input",{staticClass:"form-check-input",attrs:{type:"checkbox",id:"flexSwitchCheckChecked",disabled:""},domProps:{checked:t.currency.is_default?"checked":""}})])])])])])])])])])])}),[],!1,null,null,null);e.default=component.exports;installComponents(component,{AdminViewLoader:l(676).default})},676:function(t,e,l){"use strict";l.r(e);var c={props:["multilang","multilangImage"]},n=l(71),component=Object(n.a)(c,(function(){var t=this,e=t.$createElement,l=t._self._c||e;return l("div",{staticClass:"container skeletion-effect"},[l("div",{staticClass:"row"},[l("div",{staticClass:"col-lg-12"},[l("div",{staticClass:"card gutter-b border-0"},[l("div",{staticClass:"card-body p-4"},[t._m(0),t._v(" "),t.multilang?l("div",[l("hr",{staticClass:"text-primary"}),t._v(" "),l("div",{staticClass:"row"},[l("div",{staticClass:"col-lg-12 py-2"},[l("div",{staticClass:"px-0 pt-3"},[l("h2",{staticClass:"skeletion-animation"}),t._v(" "),l("div",{staticClass:"subheading skeletion-animation"}),t._v(" "),l("div",{staticClass:"row"},[l("div",{staticClass:"col-lg-12 px-0 pt-3 d-flex"},[t._m(1),t._v(" "),l("div",{staticClass:"tab-content p-4",attrs:{id:"myTabContent"}},[l("div",{staticClass:"tab-pane fade active show",attrs:{role:"tabpanel"}},[l("div",{staticClass:"row"},[t.multilangImage?l("div",[t._m(2)]):t._e(),t._v(" "),t._m(3)]),t._v(" "),t._m(4)])])])])])])])]):t._e()])])])])])}),[function(){var t=this,e=t.$createElement,l=t._self._c||e;return l("div",{staticClass:"row"},[l("div",{staticClass:"col-md-6 my-1"},[l("div",{staticClass:"show-table"},[l("div",{staticClass:"row justify-content-end"},[l("div",{staticClass:"col-6"},[l("div",{staticClass:"label skeletion-animation"})]),t._v(" "),l("div",{staticClass:"col-6"},[l("div",{staticClass:"text skeletion-animation"}),t._v(" "),l("div",{staticClass:"text skeletion-animation"})]),t._v(" "),l("div",{staticClass:"col-6"},[l("div",{staticClass:"label skeletion-animation"})]),t._v(" "),l("div",{staticClass:"col-6"},[l("div",{staticClass:"text skeletion-animation"})]),t._v(" "),l("div",{staticClass:"col-6"},[l("div",{staticClass:"label skeletion-animation"})]),t._v(" "),l("div",{staticClass:"col-6"},[l("div",{staticClass:"text skeletion-animation"}),t._v(" "),l("div",{staticClass:"text skeletion-animation"})]),t._v(" "),l("div",{staticClass:"col-6"},[l("div",{staticClass:"label skeletion-animation"})]),t._v(" "),l("div",{staticClass:"col-6"},[l("div",{staticClass:"switch skeletion-animation"})])])])]),t._v(" "),l("div",{staticClass:"col-md-6 my-1"},[l("div",{staticClass:"show-table"},[l("div",{staticClass:"row justify-content-end"},[l("div",{staticClass:"col-6"},[l("div",{staticClass:"label skeletion-animation"})]),t._v(" "),l("div",{staticClass:"col-6"},[l("div",{staticClass:"text skeletion-animation"}),t._v(" "),l("div",{staticClass:"text skeletion-animation"})]),t._v(" "),l("div",{staticClass:"col-6"},[l("div",{staticClass:"label skeletion-animation"})]),t._v(" "),l("div",{staticClass:"col-6"},[l("div",{staticClass:"text skeletion-animation"})]),t._v(" "),l("div",{staticClass:"col-6"},[l("div",{staticClass:"label skeletion-animation"})]),t._v(" "),l("div",{staticClass:"col-6"},[l("div",{staticClass:"text skeletion-animation"}),t._v(" "),l("div",{staticClass:"text skeletion-animation"})]),t._v(" "),l("div",{staticClass:"col-6"},[l("div",{staticClass:"label skeletion-animation"})]),t._v(" "),l("div",{staticClass:"col-6"},[l("div",{staticClass:"switch skeletion-animation"})])])])])])},function(){var t=this,e=t.$createElement,l=t._self._c||e;return l("ul",{staticClass:"nav nav-tabs d-inline-block",attrs:{id:"myTab",role:"tablist "}},[l("div",{staticClass:"tabs"}),t._v(" "),l("div",{staticClass:"tabs"}),t._v(" "),l("div",{staticClass:"tabs"})])},function(){var t=this,e=t.$createElement,l=t._self._c||e;return l("div",{staticClass:"col-md-12 my-1"},[l("div",{attrs:{role:"group"}},[l("div",{staticClass:"label skeletion-animation"}),t._v(" "),l("div",{staticClass:"py-2"},[l("div",{staticClass:"image skeletion-animation"})])])])},function(){var t=this,e=t.$createElement,l=t._self._c||e;return l("div",{staticClass:"col-md-6 my-1"},[l("div",{attrs:{role:"group "}},[l("label",{staticClass:"label skeletion-animation"}),t._v(" "),l("div",{staticClass:"input skeletion-animation"}),t._v(" "),l("div",{staticClass:"subheading skeletion-animation"})])])},function(){var t=this,e=t.$createElement,l=t._self._c||e;return l("div",{staticClass:"row"},[l("div",{staticClass:"col-md-12 my-1"},[l("div",{attrs:{role:"group "}},[l("label",{staticClass:"label skeletion-animation"}),t._v(" "),l("div",{staticClass:"textarea skeletion-animation"}),t._v(" "),l("div",{staticClass:"subheading skeletion-animation"})])])])}],!1,null,null,null);e.default=component.exports}}]);