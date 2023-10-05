<template>
    <section class="category-card skeletion-effect" v-if="allGenericData && !allGenericData.parent_categories">
        <div class="container">
            <div class="row">
                <div class="col-md-1 col-4">
                    <div class="card skeletion-animation skeletion-animation-bg-color border-0 rounded-circle">
                        <img src="~/assets/images/circle.png" alt="">
                    </div>
                    <div class="d-flex justify-content-center align-items-center">
                        <h2 class="section-heading-left section-heading-left-circle skeletion-animation text mt-3"></h2>
                    </div>
                </div>
                <div class="col-md-1 col-4">
                    <div class="card skeletion-animation border-0 rounded-circle">
                        <img src="~/assets/images/circle.png" alt="">
                    </div>
                    <div class="d-flex justify-content-center align-items-center">
                        <h2 class="section-heading-left section-heading-left-circle skeletion-animation text mt-3"></h2>
                    </div>
                </div>
                <div class="col-md-1 col-4">
                    <div class="card skeletion-animation border-0 rounded-circle">
                        <img src="~/assets/images/circle.png" alt="">
                    </div>
                    <div class="d-flex justify-content-center align-items-center">
                        <h2 class="section-heading-left section-heading-left-circle skeletion-animation text mt-3"></h2>
                    </div>
                </div>
                <div class="col-md-1 col-4">
                    <div class="card skeletion-animation border-0 rounded-circle">
                        <img src="~/assets/images/circle.png" alt="">
                    </div>
                    <div class="d-flex justify-content-center align-items-center">
                        <h2 class="section-heading-left section-heading-left-circle skeletion-animation text mt-3"></h2>
                    </div>
                </div>
                <div class="col-md-1 col-4">
                    <div class="card skeletion-animation border-0 rounded-circle">
                        <img src="~/assets/images/circle.png" alt="">
                    </div>
                    <div class="d-flex justify-content-center align-items-center">
                        <h2 class="section-heading-left section-heading-left-circle skeletion-animation text mt-3"></h2>
                    </div>
                </div>
                <div class="col-md-1 col-4">
                    <div class="card skeletion-animation border-0 rounded-circle">
                        <img src="~/assets/images/circle.png" alt="">
                    </div>
                    <div class="d-flex justify-content-center align-items-center">
                        <h2 class="section-heading-left section-heading-left-circle skeletion-animation text mt-3"></h2>
                    </div>
                </div>
                <div class="col-md-1 col-4">
                    <div class="card skeletion-animation border-0 rounded-circle">
                        <img src="~/assets/images/circle.png" alt="">
                    </div>
                    <div class="d-flex justify-content-center align-items-center">
                        <h2 class="section-heading-left section-heading-left-circle skeletion-animation text mt-3"></h2>
                    </div>
                </div>
                <div class="col-md-1 col-4">
                    <div class="card skeletion-animation border-0 rounded-circle">
                        <img src="~/assets/images/circle.png" alt="">
                    </div>
                    <div class="d-flex justify-content-center align-items-center">
                        <h2 class="section-heading-left section-heading-left-circle skeletion-animation text mt-3"></h2>
                    </div>
                </div>
                <div class="col-md-1 col-4">
                    <div class="card skeletion-animation border-0 rounded-circle">
                        <img src="~/assets/images/circle.png" alt="">
                    </div>
                    <div class="d-flex justify-content-center align-items-center">
                        <h2 class="section-heading-left section-heading-left-circle skeletion-animation text mt-3"></h2>
                    </div>
                </div>
                <div class="col-md-1 col-4">
                    <div class="card skeletion-animation border-0 rounded-circle">
                        <img src="~/assets/images/circle.png" alt="">
                    </div>
                    <div class="d-flex justify-content-center align-items-center">
                        <h2 class="section-heading-left section-heading-left-circle skeletion-animation text mt-3"></h2>
                    </div>
                </div>
                <div class="col-md-1 col-4">
                    <div class="card skeletion-animation border-0 rounded-circle">
                        <img src="~/assets/images/circle.png" alt="">
                    </div>
                    <div class="d-flex justify-content-center align-items-center">
                        <h2 class="section-heading-left section-heading-left-circle skeletion-animation text mt-3"></h2>
                    </div>
                </div>
                <div class="col-md-1 col-4">
                    <div class="card skeletion-animation border-0 rounded-circle">
                        <img src="~/assets/images/circle.png" alt="">
                    </div>
                    <div class="d-flex justify-content-center align-items-center">
                        <h2 class="section-heading-left section-heading-left-circle skeletion-animation text mt-3"></h2>
                    </div>
                </div>

            </div>

        </div>
    </section>
    <section class="category-card mt-100 mb-50 fadin"  v-else-if="allGenericData && allGenericData != null && allGenericData.parent_categories && allGenericData.parent_categories && allGenericData.parent_categories.length > 0">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 category-slider">
                        <VueSlickCarousel :key="key" v-bind="settings">
                            <div class="pe-5 cat-card" v-for="category in allGenericData.parent_categories" :key="category.id">
                                <nuxt-link :to="`shop?category=${category.slug}`">
                                <img :src="`backend${category.icon.original_media_path}`" alt="category-img" class="">
                                </nuxt-link>
                                <p class="fw-bold mb-0">
                                    <nuxt-link :to="`shop?category=${category.slug}`">{{category.name}}</nuxt-link>
                                </p></div>
                        </VueSlickCarousel>
                    </div>
                </div>
            </div>
        </section>
    <div v-else>
    </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
    data() {
        return {
            key: 1,
            settings: {
                slidesToShow: 10,
                infinite: false,
                arrows: true,
                dots: false,
                //   autoplay:true,
                slidesToScroll: 1,
                variableWidth: true,
                responsive: [
                    {
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: 5,
                            arrows: false,
                            dots: false,
                        },
                    },

                    {
                        breakpoint: 576,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 1,
                        },
                    },
                ],
            },
        };
    },
    computed: {
        ...mapGetters({
            allGenericData: 'Web/General/allGenericData'
        }),
    }
}
</script>

<style>
</style>
