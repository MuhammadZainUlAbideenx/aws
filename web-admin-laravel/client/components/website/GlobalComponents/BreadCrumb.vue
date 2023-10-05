<template>
  <section class="site-breadcrumb bg-secondary py-3 mt-0 mb-0" >
    <div class="container" v-if="currentlyActiveTemplate == 'Template1'">
      <div class="row">
        <div class="col">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                  <nuxt-link to="/"
                  class="text-medium text-decoration-none">
                  {{this.$t("home")}}
                </nuxt-link>
              </li>
              <li v-if="page == 'blog_detail'" class="breadcrumb-item">
                  <nuxt-link to="/blog"
                  class="text-medium text-decoration-none">
                  {{this.$t("blog")}}
                </nuxt-link>
              </li>
              <li v-if="page == 'product_detail'" class="breadcrumb-item">
                  <nuxt-link to="/shop"
                  class="text-medium text-decoration-none">
                  {{this.$t("products")}}
                </nuxt-link>
              </li>
               <li v-if="page == 'order_details'" class="breadcrumb-item">
                  <nuxt-link to="/customer/orders"
                  class="text-medium text-decoration-none">
                  {{this.$t("my_orders")}}
                </nuxt-link>
              </li>
              <li v-if="page == 'blog_detail'" class="breadcrumb-item active" aria-current="page">{{this.post}}</li>
              <li v-else-if="page == 'product_detail'" class="breadcrumb-item active" aria-current="page">{{this.product}}</li>
              <li v-else-if="page == 'order_details'" class="breadcrumb-item active" aria-current="page">{{$t('order_details')}}</li>
              <li v-else class="breadcrumb-item active" aria-current="page">{{this.$t(this.page)}}</li>
            </ol>
          </nav>
        </div>
      </div>
    </div>

     <div class="container" v-if="currentlyActiveTemplate == 'Template2'">
      <div class="row mx-0">
        <div class="col px-0">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                  <nuxt-link to="/"
                  class="text-gray text-decoration-none">
                  {{this.$t("home")}}
                </nuxt-link>
              </li>
              <li v-if="page == 'blog_detail'" class="breadcrumb-item">
                  <nuxt-link to="/blog"
                  class="text-gray text-decoration-none">
                  {{this.$t("blog")}}
                </nuxt-link>
              </li>
              <li v-if="page == 'product_detail'" class="breadcrumb-item">
                  <nuxt-link to="/shop"
                  class="text-gray text-decoration-none">
                  {{this.$t("products")}}
                </nuxt-link>
              </li>
               <li v-if="page == 'order_details'" class="breadcrumb-item">
                  <nuxt-link to="/customer/orders"
                  class="text-gray text-decoration-none">
                  {{this.$t("my_orders")}}
                </nuxt-link>
              </li>
              <li v-if="page == 'blog_detail'" class="breadcrumb-item active" aria-current="page">{{this.post}}</li>
              <li v-else-if="page == 'product_detail'" class="breadcrumb-item active" aria-current="page">{{this.product}}</li>
              <li v-else-if="page == 'order_details'" class="breadcrumb-item active" aria-current="page">{{$t('order_details')}}</li>
              <li v-else class="breadcrumb-item active" aria-current="page">{{this.$t(this.page)}}</li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
  </section>

</template>

<script>
import { mapGetters,mapActions } from "vuex";
export default {
    props:['page','post','product'],
    data() {
    return {
      currentlyActiveTemplate: "",
    };
  },
  created() {
    this.currentlyActiveTemplate =
      this.allSettings.general_settings.currently_active_theme;
  },
   computed: {
    ...mapGetters({
      allSettings: "allDefaultSettings",
    }),
  },
}
</script>

<style>

</style>
