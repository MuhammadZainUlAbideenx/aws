<template>
  <section
    class="product-detail m-0"
    v-if="$fetchState.pending"
  >
   <WebsiteGlobalComponentsBreadCrumb :page="`product_detail`"/>
   <Component :is="`WebsiteSkeleton${currentlyActiveTemplate}ProductDetailPage`" />

  </section>
  <section class="product-detail m-0" v-else-if="detail && currentlyActiveTemplate == 'Template1'">
    <WebsiteGlobalComponentsBreadCrumb :page="`product_detail`" :product="detail.product.name" />
    <section>
      <div class="container">
        <div class="row">
          <div class="col-lg-2 d-none d-lg-block">
            <h5 class="fw-fold mb-3" v-if="detail && detail.featured_products && detail.featured_products.length > 0">{{$t('web.customer.product_detail.featured_products')}}</h5>
            <Component :is="`${currentlyActiveTemplate}FeaturedProductCard`"

            v-for="featured_product in detail.featured_products"
              modal_id="product_detail_quickview"
              :key="featured_product.id"
              :product="featured_product"
              small
               />
          </div>
          <div class="col-lg-6 col-md-7 col-12 mb-3 mb-md-0 px-5">
            <WebsiteGlobalComponentsProductDetailCarousel
              :media="detail.product.media"
            />

          </div>
          <div class="col-lg-4 col-md-5 col-12">
            <WebsiteGlobalComponentsProductDetailOptions
              :product="detail.product"
            />
          </div>
        </div>
      </div>
    </section>
     <Component :is="`Website${currentlyActiveTemplate}ProductInformation`"  :product="detail.product"/>
    <WebsiteGlobalComponentsFeaturedVendorProfile
      :vendor="detail.product.vendor"
      v-if="
        detail.product.vendor &&
        allSettings &&
        allSettings.general_settings &&
        allSettings.general_settings.is_multi_vendor &&
        allSettings.general_settings.is_multi_vendor == 1
      "
    />
    <WebsiteGlobalComponentsFaqs
      :product="detail.product"
      v-if="detail.product.faq.length > 0"
    />
    <Component :is="`Website${currentlyActiveTemplate}RelatedProductsSection`"
     :products="detail.related_products"
      v-if="detail.related_products.length > 0"
       />
    <WebsiteTemplate1NewsLetterSection />
  </section>
<section class="product-detail m-0" v-else-if="detail && currentlyActiveTemplate == 'Template2'">
    <WebsiteGlobalComponentsBreadCrumb :page="`product_detail`" :product="detail.product.name" />
    <section>
      <div class="container">
        <div class="row">
          <div class="col-lg-6 col-md-6 col-12 mb-3 mb-md-0 pe-lg-5">
            <WebsiteGlobalComponentsProductDetailCarousel
              :media="detail.product.media"
            />

          </div>
          <div class="col-lg-6 col-md-6 col-12 ps-lg-5">
            <div class="sticky-section">
                <WebsiteGlobalComponentsProductDetailOptions
                :product="detail.product"
                />
                <Component :is="`Website${currentlyActiveTemplate}ProductInformation`"  :product="detail.product" class="m-0"/>
            </div>
          </div>
        </div>
      </div>
    </section>
    <WebsiteGlobalComponentsFeaturedVendorProfile
      :vendor="detail.product.vendor"
      v-if="
        detail.product.vendor &&
        allSettings &&
        allSettings.general_settings &&
        allSettings.general_settings.is_multi_vendor &&
        allSettings.general_settings.is_multi_vendor == 1
      "
    />
    <WebsiteGlobalComponentsFaqs
      :product="detail.product"
      v-if="detail.product.faq.length > 0"
    />
    <Component :is="`Website${currentlyActiveTemplate}RelatedProductsSection`"
     :products="detail.related_products"
      v-if="detail.related_products.length > 0"
       />
    <WebsiteTemplate1NewsLetterSection />
  </section>
  <section v-else>
        <Component :is="`Website${currentlyActiveTemplate}404`" />
  </section>
</template>

<script>
import { mapGetters } from "vuex";

export default {
  auth: false,
  data() {
    return {
         currentlyActiveTemplate: "",
      key: 1,
      detail: "",
      seo: {},
    };
  },
    created()
  {
    this.currentlyActiveTemplate = this.allSettings.general_settings.currently_active_theme
  },
  head() {
    return this.seo;
  },
  async fetch() {
    const { data } = await this.$webService.productDetail(
      this.$route.params.slug
    );
    if (data) {
      this.detail = data;
      this.seo = data.product.seo;
    }
  },
  computed: {
    ...mapGetters({
      allSettings: "allDefaultSettings",
    }),
  },
};
</script>

<style>
</style>
