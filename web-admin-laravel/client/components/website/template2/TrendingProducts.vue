<template>
    <section v-if="$fetchState.pending">
        <WebsiteSkeletonTemplate2TrendingProducts />
    </section>
    <section class="featured-items" v-else-if="$fetchState.error">
        <div class="row">
            <div class="col-md-12">
                <AdminLoader />
            </div>
        </div>
    </section>
    <section
        class="trending-products"
        v-else-if="
            categoriesWhichHaveProducts &&
            categoriesWhichHaveProducts.length > 0
        "
    >
        <div class="container">
            <div class="row heading">
                <div class="col-md-7 text-center">
                    <h2 class="section-heading text-start mb-3">
                        {{$t('trending_products')}}
                    </h2>
                </div>
                <div class="col-md-5 text-md-end">
                    <nuxt-link to=""
                        >{{$t('web.about_us.view_more')}}
                        <fa :icon="['fas', 'arrow-right']" class="ms-1"
                    /></nuxt-link>
                </div>
            </div>
            <div class="row product-section">
                <div class="col-lg-6">
                    <div class="row">
                        <div class="col-md-6 pe-md-0">
                            <VueSlickCarousel
                                ref="c1"
                                :asNavFor="$refs.c2"
                                :slidesToShow="1"
                                :arrows="false"
                                :autoplay="true"
                                :focusOnSelect="false"
                                :speed="1000"
                                :loop="true"
                            >
                                <div class="card trending-card">
                                    <div class="">
                                        <img
                                            src="~assets/images/trending.png"
                                            alt="trending-products"
                                        />
                                        <div class="card-body bg-transparent">
                                            <h6 class="fw-bold">
                                                Quis Nostrum Exer
                                            </h6>
                                            <div
                                                class="rating text-warning mb-1"
                                            >
                                                <fa
                                                    :icon="['fas', 'star']"
                                                    class="me-0"
                                                />
                                                <fa :icon="['fas', 'star']" />
                                                <fa :icon="['fas', 'star']" />
                                                <fa :icon="['fas', 'star']" />
                                                <fa :icon="['fas', 'star']" />
                                            </div>
                                            <!-- <div class="rating d-flex justify-content-start mb-2">
                      <GlobalRating />
                  </div> -->
                                            <span class="text-primary fw-bold"
                                                >$274.00</span
                                            >
                                        </div>
                                    </div>
                                </div>
                                 <div class="card trending-card">
                                    <div class="">
                                        <img
                                            src="~assets/images/trending.png"
                                            alt="trending-products"
                                        />
                                        <div class="card-body bg-transparent">
                                            <h6 class="fw-bold">
                                                Quis Nostrum Exer
                                            </h6>
                                            <div
                                                class="rating text-warning mb-1"
                                            >
                                                <fa
                                                    :icon="['fas', 'star']"
                                                    class="me-0"
                                                />
                                                <fa :icon="['fas', 'star']" />
                                                <fa :icon="['fas', 'star']" />
                                                <fa :icon="['fas', 'star']" />
                                                <fa :icon="['fas', 'star']" />
                                            </div>
                                            <!-- <div class="rating d-flex justify-content-start mb-2">
                      <GlobalRating />
                  </div> -->
                                            <span class="text-primary fw-bold"
                                                >$274.00</span
                                            >
                                        </div>
                                    </div>
                                </div>
                            </VueSlickCarousel>
                        </div>
                        <div class="col-md-6 ps-0 d-md-block d-none">
                            <VueSlickCarousel
                                ref="c2"
                                :asNavFor="$refs.c1"
                                :slidesToShow="3"
                                :arrows="false"
                                :autoplay="true"
                                :vertical="true"
                                :focusOnSelect="false"
                                :speed="1000"
                                :loop="true"
                            >
                                <div class="">
                                    <div class="card trending-card-small">
                                        <div class="row">
                                            <div class="col-md-5">
                                                <img
                                                    src="~assets/images/trending.png"
                                                    alt="trending-products"
                                                    class="img-fluid"
                                                />
                                            </div>
                                            <div class="col-md-7">
                                                <div class="card-body bg-transparent">
                                                    <h6 class="fw-bold mb-0">
                                                        Quis Nostrum Exer
                                                    </h6>
                                                    <div
                                                        class="rating text-warning"
                                                    >
                                                        <fa
                                                            :icon="[
                                                                'fas',
                                                                'star',
                                                            ]"
                                                            class="me-0"
                                                        />
                                                        <fa
                                                            :icon="[
                                                                'fas',
                                                                'star',
                                                            ]"
                                                        />
                                                        <fa
                                                            :icon="[
                                                                'fas',
                                                                'star',
                                                            ]"
                                                        />
                                                        <fa
                                                            :icon="[
                                                                'fas',
                                                                'star',
                                                            ]"
                                                        />
                                                        <fa
                                                            :icon="[
                                                                'fas',
                                                                'star',
                                                            ]"
                                                        />
                                                    </div>
                                                    <!-- <div class="rating d-flex justify-content-start mb-2">
                      <GlobalRating />
                  </div> -->
                                                    <span
                                                        class="text-primary fw-bold mb-0"
                                                        >$274.00</span
                                                    >
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="">
                                    <div class="card trending-card-small">
                                        <div class="row">
                                            <div class="col-md-5">
                                                <img
                                                    src="~assets/images/trending.png"
                                                    alt="trending-products" class="img-fluid"
                                                />
                                            </div>
                                            <div class="col-md-7">
                                                <div class="card-body bg-transparent">
                                                    <h6 class="fw-bold mb-0">
                                                        Quis Nostrum Exer
                                                    </h6>
                                                    <div
                                                        class="rating text-warning"
                                                    >
                                                        <fa
                                                            :icon="[
                                                                'fas',
                                                                'star',
                                                            ]"
                                                            class="me-0"
                                                        />
                                                        <fa
                                                            :icon="[
                                                                'fas',
                                                                'star',
                                                            ]"
                                                        />
                                                        <fa
                                                            :icon="[
                                                                'fas',
                                                                'star',
                                                            ]"
                                                        />
                                                        <fa
                                                            :icon="[
                                                                'fas',
                                                                'star',
                                                            ]"
                                                        />
                                                        <fa
                                                            :icon="[
                                                                'fas',
                                                                'star',
                                                            ]"
                                                        />
                                                    </div>
                                                    <!-- <div class="rating d-flex justify-content-start mb-2">
                      <GlobalRating />
                  </div> -->
                                                    <span
                                                        class="text-primary fw-bold mb-0"
                                                        >$274.00</span
                                                    >
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="">
                                    <div class="card trending-card-small">
                                        <div class="row">
                                            <div class="col-md-5">
                                                <img
                                                    src="~assets/images/trending.png"
                                                    alt="trending-products" class="img-fluid"
                                                />
                                            </div>
                                            <div class="col-md-7">
                                                <div class="card-body bg-transparent">
                                                    <h6 class="fw-bold mb-0">
                                                        Quis Nostrum Exer
                                                    </h6>
                                                    <div
                                                        class="rating text-warning"
                                                    >
                                                        <fa
                                                            :icon="[
                                                                'fas',
                                                                'star',
                                                            ]"
                                                            class="me-0"
                                                        />
                                                        <fa
                                                            :icon="[
                                                                'fas',
                                                                'star',
                                                            ]"
                                                        />
                                                        <fa
                                                            :icon="[
                                                                'fas',
                                                                'star',
                                                            ]"
                                                        />
                                                        <fa
                                                            :icon="[
                                                                'fas',
                                                                'star',
                                                            ]"
                                                        />
                                                        <fa
                                                            :icon="[
                                                                'fas',
                                                                'star',
                                                            ]"
                                                        />
                                                    </div>
                                                    <!-- <div class="rating d-flex justify-content-start mb-2">
                      <GlobalRating />
                  </div> -->
                                                    <span
                                                        class="text-primary fw-bold mb-0"
                                                        >$274.00</span
                                                    >
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="">
                                    <div class="card trending-card-small">
                                        <div class="row">
                                            <div class="col-md-5">
                                                <img
                                                    src="~assets/images/trending.png"
                                                    alt="trending-products" class="img-fluid"
                                                />
                                            </div>
                                            <div class="col-md-7">
                                                <div class="card-body bg-transparent">
                                                    <h6 class="fw-bold mb-0">
                                                        Quis Nostrum Exer
                                                    </h6>
                                                    <div
                                                        class="rating text-warning"
                                                    >
                                                        <fa
                                                            :icon="[
                                                                'fas',
                                                                'star',
                                                            ]"
                                                            class="me-0"
                                                        />
                                                        <fa
                                                            :icon="[
                                                                'fas',
                                                                'star',
                                                            ]"
                                                        />
                                                        <fa
                                                            :icon="[
                                                                'fas',
                                                                'star',
                                                            ]"
                                                        />
                                                        <fa
                                                            :icon="[
                                                                'fas',
                                                                'star',
                                                            ]"
                                                        />
                                                        <fa
                                                            :icon="[
                                                                'fas',
                                                                'star',
                                                            ]"
                                                        />
                                                    </div>
                                                    <!-- <div class="rating d-flex justify-content-start mb-2">
                      <GlobalRating />
                  </div> -->
                                                    <span
                                                        class="text-primary fw-bold mb-0"
                                                        >$274.00</span
                                                    >
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>




                            </VueSlickCarousel>
                        </div>
                    </div>
                </div>
               <div class="col-lg-6">
                    <div class="row">
                        <div class="col-md-6 pe-md-0">
                            <VueSlickCarousel
                                ref="c1"
                                :asNavFor="$refs.c2"
                                :slidesToShow="1"
                                :arrows="false"
                                :autoplay="true"
                                :focusOnSelect="false"
                                :speed="1000"
                                :loop="true"
                            >
                                <div class="card trending-card">
                                    <div class="">
                                        <img
                                            src="~assets/images/trending.png"
                                            alt="trending-products"
                                        />
                                        <div class="card-body bg-transparent">
                                            <h6 class="fw-bold">
                                                Quis Nostrum Exer
                                            </h6>
                                            <div
                                                class="rating text-warning mb-1"
                                            >
                                                <fa
                                                    :icon="['fas', 'star']"
                                                    class="me-0"
                                                />
                                                <fa :icon="['fas', 'star']" />
                                                <fa :icon="['fas', 'star']" />
                                                <fa :icon="['fas', 'star']" />
                                                <fa :icon="['fas', 'star']" />
                                            </div>
                                            <!-- <div class="rating d-flex justify-content-start mb-2">
                      <GlobalRating />
                  </div> -->
                                            <span class="text-primary fw-bold"
                                                >$274.00</span
                                            >
                                        </div>
                                    </div>
                                </div>
                                 <div class="card trending-card">
                                    <div class="">
                                        <img
                                            src="~assets/images/trending.png"
                                            alt="trending-products"
                                        />
                                        <div class="card-body bg-transparent">
                                            <h6 class="fw-bold">
                                                Quis Nostrum Exer
                                            </h6>
                                            <div
                                                class="rating text-warning mb-1"
                                            >
                                                <fa
                                                    :icon="['fas', 'star']"
                                                    class="me-0"
                                                />
                                                <fa :icon="['fas', 'star']" />
                                                <fa :icon="['fas', 'star']" />
                                                <fa :icon="['fas', 'star']" />
                                                <fa :icon="['fas', 'star']" />
                                            </div>
                                            <!-- <div class="rating d-flex justify-content-start mb-2">
                      <GlobalRating />
                  </div> -->
                                            <span class="text-primary fw-bold"
                                                >$274.00</span
                                            >
                                        </div>
                                    </div>
                                </div>
                            </VueSlickCarousel>
                        </div>
                        <div class="col-md-6 ps-0 d-md-block d-none">
                            <VueSlickCarousel
                                ref="c2"
                                :asNavFor="$refs.c1"
                                :slidesToShow="3"
                                :arrows="false"
                                :autoplay="true"
                                :vertical="true"
                                :focusOnSelect="false"
                                :speed="1000"
                                :loop="true"
                            >
                                <div class="">
                                    <div class="card trending-card-small">
                                        <div class="row">
                                            <div class="col-md-5">
                                                <img
                                                    src="~assets/images/trending.png"
                                                    alt="trending-products" class="img-fluid"
                                                />
                                            </div>
                                            <div class="col-md-7">
                                                <div class="card-body bg-transparent">
                                                    <h6 class="fw-bold mb-0">
                                                        Quis Nostrum Exer
                                                    </h6>
                                                    <div
                                                        class="rating text-warning"
                                                    >
                                                        <fa
                                                            :icon="[
                                                                'fas',
                                                                'star',
                                                            ]"
                                                            class="me-0"
                                                        />
                                                        <fa
                                                            :icon="[
                                                                'fas',
                                                                'star',
                                                            ]"
                                                        />
                                                        <fa
                                                            :icon="[
                                                                'fas',
                                                                'star',
                                                            ]"
                                                        />
                                                        <fa
                                                            :icon="[
                                                                'fas',
                                                                'star',
                                                            ]"
                                                        />
                                                        <fa
                                                            :icon="[
                                                                'fas',
                                                                'star',
                                                            ]"
                                                        />
                                                    </div>
                                                    <!-- <div class="rating d-flex justify-content-start mb-2">
                      <GlobalRating />
                  </div> -->
                                                    <span
                                                        class="text-primary fw-bold mb-0"
                                                        >$274.00</span
                                                    >
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="">
                                    <div class="card trending-card-small">
                                        <div class="row">
                                            <div class="col-md-5">
                                                <img
                                                    src="~assets/images/trending.png"
                                                    alt="trending-products" class="img-fluid"
                                                />
                                            </div>
                                            <div class="col-md-7">
                                                <div class="card-body bg-transparent">
                                                    <h6 class="fw-bold mb-0">
                                                        Quis Nostrum Exer
                                                    </h6>
                                                    <div
                                                        class="rating text-warning"
                                                    >
                                                        <fa
                                                            :icon="[
                                                                'fas',
                                                                'star',
                                                            ]"
                                                            class="me-0"
                                                        />
                                                        <fa
                                                            :icon="[
                                                                'fas',
                                                                'star',
                                                            ]"
                                                        />
                                                        <fa
                                                            :icon="[
                                                                'fas',
                                                                'star',
                                                            ]"
                                                        />
                                                        <fa
                                                            :icon="[
                                                                'fas',
                                                                'star',
                                                            ]"
                                                        />
                                                        <fa
                                                            :icon="[
                                                                'fas',
                                                                'star',
                                                            ]"
                                                        />
                                                    </div>
                                                    <!-- <div class="rating d-flex justify-content-start mb-2">
                      <GlobalRating />
                  </div> -->
                                                    <span
                                                        class="text-primary fw-bold mb-0"
                                                        >$274.00</span
                                                    >
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="">
                                    <div class="card trending-card-small">
                                        <div class="row">
                                            <div class="col-md-5">
                                                <img
                                                    src="~assets/images/trending.png"
                                                    alt="trending-products" class="img-fluid"
                                                />
                                            </div>
                                            <div class="col-md-7">
                                                <div class="card-body bg-transparent">
                                                    <h6 class="fw-bold mb-0">
                                                        Quis Nostrum Exer
                                                    </h6>
                                                    <div
                                                        class="rating text-warning"
                                                    >
                                                        <fa
                                                            :icon="[
                                                                'fas',
                                                                'star',
                                                            ]"
                                                            class="me-0"
                                                        />
                                                        <fa
                                                            :icon="[
                                                                'fas',
                                                                'star',
                                                            ]"
                                                        />
                                                        <fa
                                                            :icon="[
                                                                'fas',
                                                                'star',
                                                            ]"
                                                        />
                                                        <fa
                                                            :icon="[
                                                                'fas',
                                                                'star',
                                                            ]"
                                                        />
                                                        <fa
                                                            :icon="[
                                                                'fas',
                                                                'star',
                                                            ]"
                                                        />
                                                    </div>
                                                    <!-- <div class="rating d-flex justify-content-start mb-2">
                      <GlobalRating />
                  </div> -->
                                                    <span
                                                        class="text-primary fw-bold mb-0"
                                                        >$274.00</span
                                                    >
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="">
                                    <div class="card trending-card-small">
                                        <div class="row">
                                            <div class="col-md-5">
                                                <img
                                                    src="~assets/images/trending.png"
                                                    alt="trending-products" class="img-fluid"
                                                />
                                            </div>
                                            <div class="col-md-7">
                                                <div class="card-body bg-transparent">
                                                    <h6 class="fw-bold mb-0">
                                                        Quis Nostrum Exer
                                                    </h6>
                                                    <div
                                                        class="rating text-warning"
                                                    >
                                                        <fa
                                                            :icon="[
                                                                'fas',
                                                                'star',
                                                            ]"
                                                            class="me-0"
                                                        />
                                                        <fa
                                                            :icon="[
                                                                'fas',
                                                                'star',
                                                            ]"
                                                        />
                                                        <fa
                                                            :icon="[
                                                                'fas',
                                                                'star',
                                                            ]"
                                                        />
                                                        <fa
                                                            :icon="[
                                                                'fas',
                                                                'star',
                                                            ]"
                                                        />
                                                        <fa
                                                            :icon="[
                                                                'fas',
                                                                'star',
                                                            ]"
                                                        />
                                                    </div>
                                                    <!-- <div class="rating d-flex justify-content-start mb-2">
                      <GlobalRating />
                  </div> -->
                                                    <span
                                                        class="text-primary fw-bold mb-0"
                                                        >$274.00</span
                                                    >
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>




                            </VueSlickCarousel>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div v-else></div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";

export default {
    async fetch() {
        if (!this.allNewArrivalProducts) {
            await this.fetchNewArrivalProducts();
        }
    },
    methods: {
        ...mapActions({
            fetchNewArrivalProducts: "Web/General/fetchNewArrivalProducts",
        }),
    },
    computed: {
        ...mapGetters({
            allNewArrivalProducts: "Web/General/allNewArrivalProducts",
        }),
        categoriesWhichHaveProducts() {
            if (this.allNewArrivalProducts) {
                return this.allNewArrivalProducts.filter(
                    (category) => category.products.length > 0
                );
            }
            return [];
        },
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
