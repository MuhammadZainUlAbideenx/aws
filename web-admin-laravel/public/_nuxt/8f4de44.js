(window.webpackJsonp=window.webpackJsonp||[]).push([[385,34],{1266:function(t,e,l){"use strict";l.r(e);l(43),l(25),l(7),l(4),l(57),l(40),l(58);var c=l(21),n=l(0),o=(l(5),l(129));function r(object,t){var e=Object.keys(object);if(Object.getOwnPropertySymbols){var l=Object.getOwnPropertySymbols(object);t&&(l=l.filter((function(t){return Object.getOwnPropertyDescriptor(object,t).enumerable}))),e.push.apply(e,l)}return e}var v={layout:"admin",middleware:["admin","permission"],meta:{permission:"contact_forms.index",strategy:"read"},data:function(){return{contact_form:"",error:!1}},fetch:function(){var t=this;return Object(n.a)(regeneratorRuntime.mark((function e(){var l,data;return regeneratorRuntime.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,t.$repositories.contact_forms.show(t.$route.params.id);case 2:l=e.sent,data=l.data,t.contact_form=data;case 5:case"end":return e.stop()}}),e)})))()},methods:{},mounted:function(){},computed:function(t){for(var i=1;i<arguments.length;i++){var source=null!=arguments[i]?arguments[i]:{};i%2?r(Object(source),!0).forEach((function(e){Object(c.a)(t,e,source[e])})):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(source)):r(Object(source)).forEach((function(e){Object.defineProperty(t,e,Object.getOwnPropertyDescriptor(source,e))}))}return t}({},Object(o.c)({allActiveLanguages:"General/allActiveLanguages"}))},d=v,m=l(71),component=Object(m.a)(d,(function(){var t=this,e=t.$createElement,l=t._self._c||e;return l("div",[l("div",{staticClass:"content-header"},[l("div",{staticClass:"row g-0"},[l("div",{staticClass:"col-sm-12 px-0"},[l("h2",{staticClass:"m-0 text-body bold"},[t._v("\n          "+t._s(this.$t("contact_form.view_contact_form"))+"\n        ")])]),t._v(" "),l("div",{staticClass:"row"},[l("div",{staticClass:"col-sm-12 px-0"},[l("ol",{staticClass:"breadcrumb float-sm-right text-body"},[l("li",{staticClass:"breadcrumb-item"},[l("nuxt-link",{attrs:{to:t.localePath("/admin/dashboard")}},[t._v(t._s(this.$t("sidebar.home")))])],1),t._v(" "),l("li",{staticClass:"breadcrumb-item"},[l("nuxt-link",{attrs:{to:t.localePath("/admin/contact_forms")}},[t._v(t._s(this.$t("sidebar.contact_form")))])],1),t._v(" "),l("li",{staticClass:"breadcrumb-item active"},[t._v("\n              "+t._s(this.$t("form.view"))+"\n            ")])]),t._v(" "),l("p",{staticClass:"text-body-secondary"},[t._v("\n            "+t._s(this.$t("contact_form.view_description"))+"\n          ")])])])])]),t._v(" "),l("section",{staticClass:"content"},[t.$fetchState.pending?l("div",[l("AdminViewLoader",{attrs:{multilang:!0}})],1):l("div",{staticClass:"container"},[l("div",{staticClass:"row"},[l("div",{staticClass:"col-lg-12"},[l("div",{staticClass:"card gutter-b border-0"},[l("div",{staticClass:"card-body"},[l("div",{staticClass:"row"},[l("div",{staticClass:"col-md-12 px-0"},[l("div",{staticClass:"show-table mb-3"},[l("div",{staticClass:"row justify-content-end"},[l("div",{staticClass:"col-6"},[l("label",{attrs:{for:"input-live form-label"}},[t._v(t._s(this.$t("form.contact_form.name.label")))])]),t._v(" "),l("div",{staticClass:"col-6"},[l("p",[t._v(t._s(t.contact_form.name))])]),t._v(" "),l("div",{staticClass:"col-6"},[l("label",{attrs:{for:"input-live form-label"}},[t._v(t._s(this.$t("form.contact_form.email.label")))])]),t._v(" "),l("div",{staticClass:"col-6"},[l("p",[t._v(t._s(t.contact_form.email))])]),t._v(" "),l("div",{staticClass:"col-6"},[l("label",{attrs:{for:"input-live form-label"}},[t._v(t._s(this.$t("form.contact_form.subject.label")))])]),t._v(" "),l("div",{staticClass:"col-6"},[l("p",[t._v(t._s(t.contact_form.subject))])]),t._v(" "),l("div",{staticClass:"col-6"},[l("label",{attrs:{for:"input-live form-label"}},[t._v(t._s(this.$t("form.contact_form.message.label")))])]),t._v(" "),l("div",{staticClass:"col-6"},[l("p",[t._v(t._s(t.contact_form.message))])])])])])])])])])])])])])}),[],!1,null,null,null);e.default=component.exports;installComponents(component,{AdminViewLoader:l(676).default})},676:function(t,e,l){"use strict";l.r(e);var c={props:["multilang","multilangImage"]},n=l(71),component=Object(n.a)(c,(function(){var t=this,e=t.$createElement,l=t._self._c||e;return l("div",{staticClass:"container skeletion-effect"},[l("div",{staticClass:"row"},[l("div",{staticClass:"col-lg-12"},[l("div",{staticClass:"card gutter-b border-0"},[l("div",{staticClass:"card-body p-4"},[t._m(0),t._v(" "),t.multilang?l("div",[l("hr",{staticClass:"text-primary"}),t._v(" "),l("div",{staticClass:"row"},[l("div",{staticClass:"col-lg-12 py-2"},[l("div",{staticClass:"px-0 pt-3"},[l("h2",{staticClass:"skeletion-animation"}),t._v(" "),l("div",{staticClass:"subheading skeletion-animation"}),t._v(" "),l("div",{staticClass:"row"},[l("div",{staticClass:"col-lg-12 px-0 pt-3 d-flex"},[t._m(1),t._v(" "),l("div",{staticClass:"tab-content p-4",attrs:{id:"myTabContent"}},[l("div",{staticClass:"tab-pane fade active show",attrs:{role:"tabpanel"}},[l("div",{staticClass:"row"},[t.multilangImage?l("div",[t._m(2)]):t._e(),t._v(" "),t._m(3)]),t._v(" "),t._m(4)])])])])])])])]):t._e()])])])])])}),[function(){var t=this,e=t.$createElement,l=t._self._c||e;return l("div",{staticClass:"row"},[l("div",{staticClass:"col-md-6 my-1"},[l("div",{staticClass:"show-table"},[l("div",{staticClass:"row justify-content-end"},[l("div",{staticClass:"col-6"},[l("div",{staticClass:"label skeletion-animation"})]),t._v(" "),l("div",{staticClass:"col-6"},[l("div",{staticClass:"text skeletion-animation"}),t._v(" "),l("div",{staticClass:"text skeletion-animation"})]),t._v(" "),l("div",{staticClass:"col-6"},[l("div",{staticClass:"label skeletion-animation"})]),t._v(" "),l("div",{staticClass:"col-6"},[l("div",{staticClass:"text skeletion-animation"})]),t._v(" "),l("div",{staticClass:"col-6"},[l("div",{staticClass:"label skeletion-animation"})]),t._v(" "),l("div",{staticClass:"col-6"},[l("div",{staticClass:"text skeletion-animation"}),t._v(" "),l("div",{staticClass:"text skeletion-animation"})]),t._v(" "),l("div",{staticClass:"col-6"},[l("div",{staticClass:"label skeletion-animation"})]),t._v(" "),l("div",{staticClass:"col-6"},[l("div",{staticClass:"switch skeletion-animation"})])])])]),t._v(" "),l("div",{staticClass:"col-md-6 my-1"},[l("div",{staticClass:"show-table"},[l("div",{staticClass:"row justify-content-end"},[l("div",{staticClass:"col-6"},[l("div",{staticClass:"label skeletion-animation"})]),t._v(" "),l("div",{staticClass:"col-6"},[l("div",{staticClass:"text skeletion-animation"}),t._v(" "),l("div",{staticClass:"text skeletion-animation"})]),t._v(" "),l("div",{staticClass:"col-6"},[l("div",{staticClass:"label skeletion-animation"})]),t._v(" "),l("div",{staticClass:"col-6"},[l("div",{staticClass:"text skeletion-animation"})]),t._v(" "),l("div",{staticClass:"col-6"},[l("div",{staticClass:"label skeletion-animation"})]),t._v(" "),l("div",{staticClass:"col-6"},[l("div",{staticClass:"text skeletion-animation"}),t._v(" "),l("div",{staticClass:"text skeletion-animation"})]),t._v(" "),l("div",{staticClass:"col-6"},[l("div",{staticClass:"label skeletion-animation"})]),t._v(" "),l("div",{staticClass:"col-6"},[l("div",{staticClass:"switch skeletion-animation"})])])])])])},function(){var t=this,e=t.$createElement,l=t._self._c||e;return l("ul",{staticClass:"nav nav-tabs d-inline-block",attrs:{id:"myTab",role:"tablist "}},[l("div",{staticClass:"tabs"}),t._v(" "),l("div",{staticClass:"tabs"}),t._v(" "),l("div",{staticClass:"tabs"})])},function(){var t=this,e=t.$createElement,l=t._self._c||e;return l("div",{staticClass:"col-md-12 my-1"},[l("div",{attrs:{role:"group"}},[l("div",{staticClass:"label skeletion-animation"}),t._v(" "),l("div",{staticClass:"py-2"},[l("div",{staticClass:"image skeletion-animation"})])])])},function(){var t=this,e=t.$createElement,l=t._self._c||e;return l("div",{staticClass:"col-md-6 my-1"},[l("div",{attrs:{role:"group "}},[l("label",{staticClass:"label skeletion-animation"}),t._v(" "),l("div",{staticClass:"input skeletion-animation"}),t._v(" "),l("div",{staticClass:"subheading skeletion-animation"})])])},function(){var t=this,e=t.$createElement,l=t._self._c||e;return l("div",{staticClass:"row"},[l("div",{staticClass:"col-md-12 my-1"},[l("div",{attrs:{role:"group "}},[l("label",{staticClass:"label skeletion-animation"}),t._v(" "),l("div",{staticClass:"textarea skeletion-animation"}),t._v(" "),l("div",{staticClass:"subheading skeletion-animation"})])])])}],!1,null,null,null);e.default=component.exports}}]);