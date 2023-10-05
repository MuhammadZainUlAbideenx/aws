<template>
    <section v-if="allGenericData && !allGenericData.featured_blog_post">
        <WebsiteSkeletonTemplate2LatestPost />
    </section>
    <section class="blog" v-else-if="allGenericData && allGenericData.featured_blog_post.length > 0">
        <div class="container">
            <div class="row">
                <div class="blog-sec">
                    <div class="row">
                        <div class="col-md-12 mb-50">
                            <h2 class="section-heading text-start mb-0 p-0">Blog and News</h2>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 d-flex justify-content-between flex-column">
                            <div class="col-md-12 position-relative h-50 blog-hover" v-if="(allGenericData.featured_blog_post[0] && allGenericData.featured_blog_post[0].image)">
                                <nuxt-link :to="`/blog/${allGenericData.featured_blog_post[0].slug}`"><img :src="`/backend${allGenericData.featured_blog_post[0].image.thumbnails.large.thumbnail}`" alt=""></nuxt-link>
                                <div class="blog-heading">
                                    <h1><nuxt-link :to="`/blog/${allGenericData.featured_blog_post[0].slug}`">{{allGenericData.featured_blog_post[0].name}}</nuxt-link></h1>
                                </div>
                            </div>
                            <div class="col-md-12 pt-3 position-relative h-50 blog-hover" v-if="(allGenericData.featured_blog_post[1] && allGenericData.featured_blog_post[1].image)">
                                <nuxt-link :to="`/blog/${allGenericData.featured_blog_post[1].slug}`"><img :src="`/backend${allGenericData.featured_blog_post[1].image.thumbnails.large.thumbnail}`"  alt=""></nuxt-link>
                                <div class="blog-heading">
                                    <h1><nuxt-link :to="`/blog/${allGenericData.featured_blog_post[1].slug}`">{{allGenericData.featured_blog_post[1].name}}</nuxt-link></h1>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="col-md-12 position-relative h-00 blog-hover" v-if="(allGenericData.featured_blog_post[2] && allGenericData.featured_blog_post[2].image)">
                                <nuxt-link :to="`/blog/${allGenericData.featured_blog_post[2].slug}`"><img :src="`/backend${allGenericData.featured_blog_post[2].image.thumbnails.large.thumbnail}`"  alt=""></nuxt-link>
                                <div class="blog-heading">
                                    <h1><nuxt-link :to="`/blog/${allGenericData.featured_blog_post[2].slug}`">{{allGenericData.featured_blog_post[2].name}}</nuxt-link></h1>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 d-flex justify-content-between flex-column" >
                            <div class="col-md-12 position-relative h-50 blog-hover" v-if="(allGenericData.featured_blog_post[3] && allGenericData.featured_blog_post[3].image)">
                                <nuxt-link :to="`/blog/${allGenericData.featured_blog_post[3].slug}`"><img :src="`/backend${allGenericData.featured_blog_post[3].image.thumbnails.large.thumbnail}`"  alt=""></nuxt-link>
                                <div class="blog-heading">
                                    <h1><nuxt-link :to="`/blog/${allGenericData.featured_blog_post[3].slug}`">{{allGenericData.featured_blog_post[3].name}}</nuxt-link></h1>
                                </div>
                            </div>
                            <div class="col-md-12 pt-3 position-relative h-50 blog-hover" v-if="(allGenericData.featured_blog_post[4] && allGenericData.featured_blog_post[4].image)">
                                <nuxt-link :to="`/blog/${allGenericData.featured_blog_post[4].slug}`"><img :src="`/backend${allGenericData.featured_blog_post[4].image.thumbnails.large.thumbnail}`"  alt=""></nuxt-link>
                                <div class="blog-heading">
                                    <h1><nuxt-link :to="`/blog/${allGenericData.featured_blog_post[4].slug}`">{{allGenericData.featured_blog_post[4].name}}</nuxt-link></h1>
                                </div>
                            </div>
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
    fetch() {},
    data() {
        return {
        };
    },
    computed: {
        ...mapGetters({
            allGenericData: "Web/General/allGenericData",
        }),
    },
};
</script>

<style></style>
