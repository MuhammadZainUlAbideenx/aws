<template>
    <section class="product-rating-review-sec pt-0 mt-0 ">
        <div class="container p-0">
            <div class="row">
                <div class="col-12">
                    <div class="rat-rev-wrap rounded bg-secondary-light p-4" v-for="(review,index) in reviews" :key="index">
                        <div class="rev-product">
                            <div class="img-wrap" v-if="review.product.media && review.product.media[0] && review.product.media[0].original_media_path">
                                <img :src="`/backend${review.product.media[0].original_media_path}`" class="img-fluid" alt="">
                            </div>
                            <div v-else class="img-wrap" >
                                    <img src="~/assets/images/defult-product-img.png" alt="">
                            </div>
                            <div class="prod-body">
                                <h5 class="prod-title">{{review.product.name}} </h5>
                            </div>
                        </div>
                        <div class="rev-product-detail">
                            <div class="star-rating mx-auto">
                                <GlobalRating :rating="review.rating" />
                            </div>
                            <p>{{review.description}} </p>
                             <div v-if="review.images_url && review.images_url.length>0" >
                        <img class="mx-2" v-for="image_url in review.images_url" :key="image_url" height="100px" width="100px" :src="`/backend${image_url}`" alt="">
                    </div>
                            <div class="d-flex align-items-center">
                                <div class="me-3 opacity-5"> <span>{{review.created_at}}</span></div>
                                <!-- <div class="reviewer rev-verified d-flex align-items-center">
                                    <fa :icon="['fas', 'check-circle']" class="fs-5 me-2"/>
                                    <span class="opacity-5">Verified Purchase</span>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import { mapGetters } from "vuex";
export default {
      props: ["reviews"],
   data() {
    return {

    };
  },
}
</script>

<style>

</style>
