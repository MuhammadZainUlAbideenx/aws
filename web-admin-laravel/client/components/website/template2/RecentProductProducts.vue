<template>
    <section v-if="$fetchState.pending">
        <WebsiteSkeletonTemplate2LatestProducts />
    </section>
    <section class="featured-items" v-else-if="$fetchState.error">
        <div class="row">
            <div class="col-md-12">
                <AdminLoader />
            </div>
        </div>
    </section>
    <section
        class="new-arrival-products"
        v-else
    >
        <div class="container">
            <div class="row">
                <div class="col text-center">
                    <h2 class="section-heading text-start mb-3">
                       {{$t('new_arrivals')}}
                    </h2>
                </div>
            </div>
            <div class="row products-section">
                    <div class="col-md-4 col-12" v-for="product in allLatestProducts" :key="product.id" >
                    <div class="card new-arrival-card py-3">
                        <div class="row g-0">
                            <div class="col-lg-4 col-md-12 col-4">
                                 <nuxt-link :to="`/product/${product.slug}`">
                                <img
                                    v-if="product.media.length > 0" :src="`/backend${product.media[0].thumbnails.small.thumbnail}`"
                                    class="img-fluid"
                                    alt="new arrival"
                                />
                                 </nuxt-link>
                            </div>
                            <div class="col-lg-8 col-md-12 col-8 d-flex align-items-center">
                                <div class="card-body">
                                    <h6 class="card-title fw-bold">
                                        <nuxt-link :to="`/product/${product.slug}`">
                                            {{product.name}}
                                        </nuxt-link>

                                    </h6>
                                    <div class="rating mb-2">
                                        <div class="rating">
                                            <GlobalRating :rating="product.reviews_average_rating" />
                                        </div>
                                    </div>
                                    <!-- <div class="rating d-flex justify-content-start mb-2">
                      <GlobalRating />
                  </div> -->
                                    <span class="text-primary fw-bold"
                                        >{{product.display_price}}</span
                                    >
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>

        </div>
    </section>
</template>

<script>
import { mapGetters, mapActions } from "vuex";

export default {
    async fetch() {
        if (!this.allLatestProducts) {
            await this.fetchLatestProducts();
        }
    },
    methods: {
        ...mapActions({
            fetchLatestProducts: "Web/General/fetchLatestProducts",
        }),
    },
    computed: {
        ...mapGetters({
            allLatestProducts: "Web/General/allLatestProducts",
        }),
    },
    data() {
        return {
            settings: {
                infinite: true,
                slidesToShow: 3,
                rows: 1,
                slidesPerRow: 1,
                arrows: false,
                responsive: [
                    {
                        breakpoint: 1199,
                        settings: {
                            slidesToShow: 2,
                        },
                    },
                    {
                        breakpoint: 991,
                        settings: {
                            slidesToShow: 1,
                        },
                    },
                    {
                        breakpoint: 575,
                        settings: {
                            slidesToShow: 2,
                        },
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1,
                        },
                    },
                ],
            },
        };
    },
};
</script>

<style></style>
