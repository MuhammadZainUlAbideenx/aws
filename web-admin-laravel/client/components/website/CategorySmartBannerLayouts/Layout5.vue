<template>
    <div class="container">
      <div class="row">
               <div class="col-lg-4 col-md-6 mb-3 mb-lg-0 fadin" v-if="allFeaturedCategories[0]" >
            <div class="card bg-pink-light border-0 shadow-none">
                <div class="card-header bg-transparent p-4 pb-0">
                     <nuxt-link :to="`shop?category=${allFeaturedCategories[0].slug}`" class="fw-bold text-dark text-uppercase fs-4 d-block">{{allFeaturedCategories[0].name}} </nuxt-link>
                    <span class="text-dark-50">from {{allFeaturedCategories[0].min_price}}*</span>
                </div>
                <img :src="`/backend${allFeaturedCategories[0].image.thumbnails.large.thumbnail}`" class="rounded" alt="">
            </div>
        </div>
                <div class="col-lg-8 col-md-6 mb-3 mb-lg-0 fadin">
            <div class="col-lg-12 smart_banners_height pb-4" v-if="allFeaturedCategories[1]">
                <div class="card bg-yellow-light border-0 shadow-none">
                    <div class="card-header bg-transparent p-4 pb-0">
                    <nuxt-link :to="`shop?category=${allFeaturedCategories[1].slug}`" class="fw-bold text-dark text-uppercase fs-4 d-block">{{allFeaturedCategories[1].name}}</nuxt-link>
                        <span class="text-dark-50">from {{allFeaturedCategories[1].min_price}}*</span>
                    </div>
                    <img :src="`/backend${allFeaturedCategories[1].image.thumbnails.large.thumbnail}`" alt="" class="rounded">
                </div>
            </div>
            <div class="col-lg-12 smart_banners_height " v-if="allFeaturedCategories[2]">
                <div class="card bg-light border-0 shadow-none">
                    <div class="card-header bg-transparent p-4 pb-0">
                         <nuxt-link :to="`shop?category=${allFeaturedCategories[2].slug}`" class="fw-bold text-dark text-uppercase fs-4 d-block">{{allFeaturedCategories[2].name}} </nuxt-link>
                        <span class="text-dark-50">from {{allFeaturedCategories[2].min_price}}*</span>
                    </div>
                    <img :src="`/backend${allFeaturedCategories[2].image.thumbnails.large.thumbnail}`" alt="" class="rounded">
                </div>
            </div>
        </div>


      </div>
    </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";

export default {
    props:["allFeaturedCategories"],
  data() {
    return {
    };
  },
};
</script>

<style scoped>
.smart_banners_height{
    height: 350px !important;
}
</style>
