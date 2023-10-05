<template>
<section v-if="$fetchState.pending" class="blog-page mt-0">
    <WebsiteGlobalComponentsBreadCrumb :page="`blog_detail`"/>
        <Component :is="`WebsiteSkeleton${currentlyActiveTemplate}BlogDetailPage`" />
  </section>
  <section v-else-if="currentlyActiveTemplate == 'Template1'" class="blog-page mt-0">
    <WebsiteGlobalComponentsBreadCrumb :page="`blog_detail`" :post="detail.name"/>
      <div class="container">
            <div class="row">
                 <!-- Side widgets-->

                <div class="col-lg-12">
                    <!-- Post content-->
                    <article>
                        <!-- Post header-->
                        <header class="mt-5 mb-4">
                            <!-- Post title-->
                            <h1 class="fw-bolder mb-1">{{this.detail.name}}</h1>
                            <!-- Post meta content-->
                            <div class="text-muted fst-italic mb-2">Posted on {{this.detail.created_at}} by {{this.detail.user}}</div>
                            <!-- Post categories-->
                            <a class="badge bg-primary text-decoration-none link-light" href="#!">{{this.detail.news_category.name}}</a>
                        </header>
                        <!-- Preview image figure-->
                        <figure class="mb-4"><img v-if="this.detail.image" class="img-fluid rounded" :src="`/backend${this.detail.image.thumbnails.large.thumbnail}`" alt="..." />
                        <img v-else class="card-img-top rounded-0" src="~/assets/images/blog-img1.jpg" alt="Card image cap">

                        </figure>
                        <!-- Post content-->
                        <section v-html="this.detail.description_web">

                        </section>
                    </article>

                </div>

            </div>
        </div>
    <WebsiteTemplate1NewsLetterSection />
  </section>
    <section v-else-if="currentlyActiveTemplate == 'Template2'" class="blog-page mt-0">
    <WebsiteGlobalComponentsBreadCrumb :page="`blog_detail`" :post="detail.name"/>
      <div class="container">
            <div class="row mt-100 ">
                 <!-- Side widgets-->

                <div class="col-lg-8 blog-page">
                    <!-- Post content-->
                    <article>
                        <!-- Post header-->
                        <header class="mb-4">
                            <!-- Post categories-->
                            <a class="badge bg-primary text-decoration-none link-light mb-30" href="#!">{{this.detail.news_category.name}}</a>
                            <!-- Post title-->
                            <h1 class="fw-bolder mb-30">{{this.detail.name}}</h1>
                            <!-- Post meta content-->
                            <div class="text-muted fs-5 mb-0">{{this.detail.created_at}} - {{this.detail.user}}</div>
                        </header>
                        <!-- Preview image figure-->
                        <figure class="mb-4"><img v-if="this.detail.image" class="img-fluid rounded" :src="`/backend${this.detail.image.thumbnails.large.thumbnail}`" alt="..." />
                        <img v-else class="card-img-top rounded-0" src="~/assets/images/blog-img1.jpg" alt="Card image cap">

                        </figure>
                        <!-- Post content-->
                        <section v-html="this.detail.description_web">

                        </section>
                    </article>

                </div>
                <div class="col-lg-4 ps-md-4 pt-4">
                    <div class="bg-secondary p-4 position-sticky top-0">
                        <div class="mb-50 recent-pro">
                            <h3 class="text-body mb-30">{{$t("latest_posts")}}</h3>
                            <ul class="p-0 m-0" v-if="detail.latest_posts">
                                <li v-for="(post,index) in detail.latest_posts" :key="index">
                                    <div class="col-lg-5 col-md-4">
                                        <nuxt-link :to="`/blog/${post.slug}`"><img class="card-img-top rounded-0" :src="`/backend${post.image.thumbnails.large.thumbnail}`" alt="Card image cap"></nuxt-link>
                                    </div>
                                    <div class="col-lg-7 col-md-8">
                                        <div class="px-md-3 py-3 py-md-0">
                                            <h5 class="mb-30">
                                                <nuxt-link :to="`/blog/${post.slug}`">{{post.name}}</nuxt-link>
                                            </h5>
                                            <span>{{post.created_at}}</span>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <hr>
                        <div class="social-icons mb-50 mt-50">
                            <h3 class="text-body mb-30">{{$t("connect_and_follow")}}</h3>
                            <ul class="d-flex m-0 p-0">
                                <li>
                                    <a href="#" class="facebook text-white">
                                        <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        version="1.1"
                                        xmlns:xlink="http://www.w3.org/1999/xlink"
                                        xmlns:svgjs="http://svgjs.com/svgjs"
                                        width="20"
                                        height="20"
                                        x="0"
                                        y="0"
                                        viewBox="0 0 155.139 155.139"
                                        style="enable-background: new 0 0 512 512"
                                        xml:space="preserve"
                                        class=""
                                    >
                                        <g>
                                        <g xmlns="http://www.w3.org/2000/svg">
                                            <path
                                            id="f_1_"
                                            style=""
                                            d="M89.584,155.139V84.378h23.742l3.562-27.585H89.584V39.184   c0-7.984,2.208-13.425,13.67-13.425l14.595-0.006V1.08C115.325,0.752,106.661,0,96.577,0C75.52,0,61.104,12.853,61.104,36.452   v20.341H37.29v27.585h23.814v70.761H89.584z"
                                            fill="currentColor"
                                            data-original="currentColor"
                                            class=""
                                            ></path>
                                        </g>
                                        <g xmlns="http://www.w3.org/2000/svg"></g>
                                        <g xmlns="http://www.w3.org/2000/svg"></g>
                                        <g xmlns="http://www.w3.org/2000/svg"></g>
                                        <g xmlns="http://www.w3.org/2000/svg"></g>
                                        <g xmlns="http://www.w3.org/2000/svg"></g>
                                        <g xmlns="http://www.w3.org/2000/svg"></g>
                                        <g xmlns="http://www.w3.org/2000/svg"></g>
                                        <g xmlns="http://www.w3.org/2000/svg"></g>
                                        <g xmlns="http://www.w3.org/2000/svg"></g>
                                        <g xmlns="http://www.w3.org/2000/svg"></g>
                                        <g xmlns="http://www.w3.org/2000/svg"></g>
                                        <g xmlns="http://www.w3.org/2000/svg"></g>
                                        <g xmlns="http://www.w3.org/2000/svg"></g>
                                        <g xmlns="http://www.w3.org/2000/svg"></g>
                                        <g xmlns="http://www.w3.org/2000/svg"></g>
                                        </g></svg
                                    ></a>
                                </li>
                                <li class="px-3">
                                    <a href="#" class="twitter text-white">
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        version="1.1"
                                        xmlns:xlink="http://www.w3.org/1999/xlink"
                                        xmlns:svgjs="http://svgjs.com/svgjs"
                                        width="20"
                                        height="20"
                                        x="0"
                                        y="0"
                                        viewBox="0 0 512 512"
                                        style="enable-background: new 0 0 512 512"
                                        xml:space="preserve"
                                        class=""
                                    >
                                        <g>
                                        <g xmlns="http://www.w3.org/2000/svg">
                                            <g>
                                            <path
                                                d="M512,97.248c-19.04,8.352-39.328,13.888-60.48,16.576c21.76-12.992,38.368-33.408,46.176-58.016    c-20.288,12.096-42.688,20.64-66.56,25.408C411.872,60.704,384.416,48,354.464,48c-58.112,0-104.896,47.168-104.896,104.992    c0,8.32,0.704,16.32,2.432,23.936c-87.264-4.256-164.48-46.08-216.352-109.792c-9.056,15.712-14.368,33.696-14.368,53.056    c0,36.352,18.72,68.576,46.624,87.232c-16.864-0.32-33.408-5.216-47.424-12.928c0,0.32,0,0.736,0,1.152    c0,51.008,36.384,93.376,84.096,103.136c-8.544,2.336-17.856,3.456-27.52,3.456c-6.72,0-13.504-0.384-19.872-1.792    c13.6,41.568,52.192,72.128,98.08,73.12c-35.712,27.936-81.056,44.768-130.144,44.768c-8.608,0-16.864-0.384-25.12-1.44    C46.496,446.88,101.6,464,161.024,464c193.152,0,298.752-160,298.752-298.688c0-4.64-0.16-9.12-0.384-13.568    C480.224,136.96,497.728,118.496,512,97.248z"
                                                fill="currentColor"
                                                data-original="currentColor"
                                                class=""
                                            ></path>
                                            </g>
                                        </g>
                                        <g xmlns="http://www.w3.org/2000/svg"></g>
                                        <g xmlns="http://www.w3.org/2000/svg"></g>
                                        <g xmlns="http://www.w3.org/2000/svg"></g>
                                        <g xmlns="http://www.w3.org/2000/svg"></g>
                                        <g xmlns="http://www.w3.org/2000/svg"></g>
                                        <g xmlns="http://www.w3.org/2000/svg"></g>
                                        <g xmlns="http://www.w3.org/2000/svg"></g>
                                        <g xmlns="http://www.w3.org/2000/svg"></g>
                                        <g xmlns="http://www.w3.org/2000/svg"></g>
                                        <g xmlns="http://www.w3.org/2000/svg"></g>
                                        <g xmlns="http://www.w3.org/2000/svg"></g>
                                        <g xmlns="http://www.w3.org/2000/svg"></g>
                                        <g xmlns="http://www.w3.org/2000/svg"></g>
                                        <g xmlns="http://www.w3.org/2000/svg"></g>
                                        <g xmlns="http://www.w3.org/2000/svg"></g>
                                        </g>
                                    </svg>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="linkedin text-white">
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        version="1.1"
                                        xmlns:xlink="http://www.w3.org/1999/xlink"
                                        xmlns:svgjs="http://svgjs.com/svgjs"
                                        width="20"
                                        height="20"
                                        x="0"
                                        y="0"
                                        viewBox="0 0 100 100"
                                        style="enable-background: new 0 0 512 512"
                                        xml:space="preserve"
                                        class=""
                                    >
                                        <g>
                                        <g
                                            xmlns="http://www.w3.org/2000/svg"
                                            id="_x31_0.Linkedin"
                                        >
                                            <path
                                            d="m90 90v-29.3c0-14.4-3.1-25.4-19.9-25.4-8.1 0-13.5 4.4-15.7 8.6h-.2v-7.3h-15.9v53.4h16.6v-26.5c0-7 1.3-13.7 9.9-13.7 8.5 0 8.6 7.9 8.6 14.1v26h16.6z"
                                            fill="currentColor"
                                            data-original="currentColor"
                                            class=""
                                            ></path>
                                            <path
                                            d="m11.3 36.6h16.6v53.4h-16.6z"
                                            fill="currentColor"
                                            data-original="currentColor"
                                            class=""
                                            ></path>
                                            <path
                                            d="m19.6 10c-5.3 0-9.6 4.3-9.6 9.6s4.3 9.7 9.6 9.7 9.6-4.4 9.6-9.7-4.3-9.6-9.6-9.6z"
                                            fill="currentColor"
                                            data-original="currentColor"
                                            class=""
                                            ></path>
                                        </g>
                                        </g>
                                    </svg>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <hr>
                        <WebsiteTemplate2NewsLetterSection class="d-block mt-0" />
                    </div>
                </div>
            </div>
        </div>
  </section>
</template>
<script>
import { mapGetters,mapActions } from "vuex";

export default {
  auth: false,
  data() {
    return {
        detail:'',
        currentlyActiveTemplate: "",
    };
  },
   created()
  {
    this.currentlyActiveTemplate = this.allSettings.general_settings.currently_active_theme
  },
  async fetch(){
         await this.$webService.postDetail(this.$route.params.slug).then(async (res) => {
              this.detail= res.data
            });
  },
      computed:{
    ...mapGetters({
      allSettings: 'allDefaultSettings'
    }),
  },
};
</script>
