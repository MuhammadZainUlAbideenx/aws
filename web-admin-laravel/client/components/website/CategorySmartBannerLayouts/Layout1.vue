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
        <div class="col-lg-4 col-md-6 mb-3 mb-lg-0 fadin">
            <div class="col-lg-12 h-50 pb-4" v-if="allFeaturedCategories[1]">
                <div class="card bg-yellow-light border-0 shadow-none">
                    <div class="card-header bg-transparent p-4 pb-0">
                    <nuxt-link :to="`shop?category=${allFeaturedCategories[1].slug}`" class="fw-bold text-dark text-uppercase fs-4 d-block">{{allFeaturedCategories[1].name}}</nuxt-link>
                        <span class="text-dark-50">from {{allFeaturedCategories[1].min_price}}*</span>
                    </div>
                    <img :src="`/backend${allFeaturedCategories[1].image.thumbnails.large.thumbnail}`" alt="" class="rounded">
                </div>
            </div>
            <div class="col-lg-12 h-50 " v-if="allFeaturedCategories[2]">
                <div class="card bg-light border-0 shadow-none">
                    <div class="card-header bg-transparent p-4 pb-0">
                         <nuxt-link :to="`shop?category=${allFeaturedCategories[2].slug}`" class="fw-bold text-dark text-uppercase fs-4 d-block">{{allFeaturedCategories[2].name}} </nuxt-link>
                        <span class="text-dark-50">from {{allFeaturedCategories[2].min_price}}*</span>
                    </div>
                    <img :src="`/backend${allFeaturedCategories[2].image.thumbnails.large.thumbnail}`" alt="" class="rounded">
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-12 d-md-flex last-cat d-lg-block fadin" v-if="allFeaturedCategories[3]">
            <div class="col-lg-12 col-md-6 h-50 pb-4 pb-md-0 pb-lg-4 pe-15">
                <div class="card bg-light border-0 shadow-none">
                    <div class="card-header bg-transparent p-4 pb-0">
                         <nuxt-link :to="`shop?category=${allFeaturedCategories[3].slug}`" class="fw-bold text-dark text-uppercase fs-4 d-block">{{allFeaturedCategories[3].name}} </nuxt-link>
                        <span class="text-dark-50">from {{allFeaturedCategories[3].min_price}}*</span>
                    </div>
                    <img :src="`/backend${allFeaturedCategories[3].image.thumbnails.large.thumbnail}`" alt="" class="rounded">
                </div>
            </div>
            <div class="col-lg-12 col-md-6 h-50 ps-15" v-if="allFeaturedCategories[4]">
                <div class="card bg-blue-light-50 border-0 shadow-none">
                    <div class="card-header bg-transparent p-4 pb-0">
                         <nuxt-link :to="`shop?category=${allFeaturedCategories[4].slug}`" class="fw-bold text-dark text-uppercase fs-4 d-block">{{allFeaturedCategories[4].name}} </nuxt-link>
                        <span class="text-dark-50">from {{allFeaturedCategories[4].min_price}}*</span>
                    </div>
                    <img :src="`/backend${allFeaturedCategories[4].image.thumbnails.large.thumbnail}`" alt="" class="rounded">
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
</style>
