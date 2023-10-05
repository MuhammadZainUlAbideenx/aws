<template>
    <section v-if="$fetchState.pending">
        <WebsiteSkeletonTemplate2NewArrival />
    </section>
    <section class="featured-items" v-else-if="$fetchState.error">
        <div class="row">
            <div class="col-md-12">
                <AdminLoader />
            </div>
        </div>
    </section>
    <section
        class="new-arrivals"
        v-else-if="
            categoriesWhichHaveProducts &&
            categoriesWhichHaveProducts.length > 0
        "
    >
        <div class="container">
            <div class="row">
                <div class="col text-center">
                    <h2 class="section-heading">
                        {{
                            this.$t(
                                "web.home.new_arrival_products.heading.text1"
                            )
                        }}
                    </h2>
                    <img src="~/assets/images/separator.png" alt="" />
                    <p class="section-subheading mt-2">
                        {{
                            this.$t("web.home.new_arrival_products.description")
                        }}
                    </p>
                </div>
            </div>
            <div
                class="row categories-section"
                v-for="(category, index) in categoriesWhichHaveProducts"
                :key="category.id"
            >
            <!-- Right Section in a Loop -->
            <div class="row" v-if="index % 2 == 0">
                   <div
                    class="col-lg-6 col-md-5 order-md-1 order-2"
                >
                    <VueSlickCarousel v-bind="settings">
                        <div
                            v-for="product in category.products"
                            :key="product.id"
                            class="mt-md-0 mt-4"
                        >
                            <Template2NewArrivalProductCard
                                :product="product"
                            />
                        </div>
                    </VueSlickCarousel>
                </div>
                <div class="col-lg-6 col-md-7 order-md-2 order-1">
                    <div
                        class="new-arrival-static-banner h-100  rounded px-0"
                    >
                        <div class="img-wrap position-relative">
                            <img
                                :src="`backend${category.image.thumbnails.medium.thumbnail}`"
                                alt="category-banner"
                                class="h-100 w-100"
                            />
                            <div class="position-absolute start-0 col-6 ps-3 py-4">
                                <h3 class="fw-bold my-3">
                                    {{category.name}}
                                </h3>
                                <p class="d-md-block d-none">
                                       {{category.description}}
                                </p>
                                <nuxt-link
                                    :to="{
                                        path: '/shop',
                                        query: { category: category.slug },
                                    }"
                                    class="arrival-link"
                                >
                                    {{$t('view_all_collection')}}
                                </nuxt-link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Left Section in a Loop -->
            <div  class="row" v-if="index % 2 == 1">
                 <div class="col-lg-6 col-md-7">
                    <div
                        class="new-arrival-static-banner text-dark h-100 rounded px-0"
                    >
                        <div class="img-wrap position-relative">
                            <img
                               :src="`backend${category.image.thumbnails.medium.thumbnail}`"
                                alt="category-banner"
                                class="h-100 w-100"
                            />
                            <div class="position-absolute end-0 ps-lg-3 py-4 pe-3">
                                <h2 class="fw-bold mb-1">
                                    {{category.name}}
                                </h2>
                                <h4 class="fw-bold mb-3 d-md-block d-none">
                                   {{category.description}}
                                </h4>
                                <nuxt-link
                                    :to="{
                                        path: '/shop',
                                        query: { category: category.slug },
                                    }"
                                    class="btn btn-secondary text-white text-uppercase"
                                >{{$t('shop_now')}}
                                </nuxt-link>
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    class="col-lg-6 col-md-5"
                >
                    <VueSlickCarousel v-bind="settings">
                        <div
                            v-for="product in category.products"
                            :key="product.id"
                            class="mt-md-0 mt-4"
                        >
                            <Template2NewArrivalProductCard
                                :product="product"
                            />
                        </div>
                    </VueSlickCarousel>
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
                autoplay:true,
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
