<template>
  <section v-if="allGenericData && !allGenericData.featured_blog_post">
    <WebsiteSkeletonTemplate1LatestPost/>
  </section>
  <section class="blog blog-home" v-else-if="allGenericData && allGenericData.featured_blog_post.length > 0">
        <div class="container">
          <div class="row">
            <div class="col">
              <h2 class="section-heading">{{ this.$t("web.home.blog.heading.text1") }}<span>{{ this.$t("web.home.blog.heading.text2") }}</span></h2>
              <p class="section-subheading">{{ this.$t("web.home.blog.description") }}</p>
              <VueSlickCarousel v-bind="settings">
                <div v-for="post in allGenericData.featured_blog_post"  :key="post.id">
                  <Template1BlogPostCard :post="post" />
                </div>
              </VueSlickCarousel>
            </div>
          </div>
      </div>
  </section>
  <section v-else>

  </section>
</template>

<script>
import { mapGetters,mapActions } from "vuex";
export default {
  fetch(){

  },
  data(){
    return{
      settings:{
        "slidesToShow": 2,
        "slidesToScroll": 1,
        "autoplay": true,
        "responsive": [
          {
            "breakpoint": 1024,
            "settings": {
              "slidesToShow": 2
            }
          },
          {
            "breakpoint": 600,
            "settings": {
              "slidesToShow": 1
            }
          },
          {
            "breakpoint": 480,
            "settings": {
              "slidesToShow": 1,
              "slidesToScroll": 1
            }
          }
        ]
      }
    }
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
