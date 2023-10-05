<template>
<!-- the below setction is skeleton of instagram and Newsletter field -->
      <section class="insta-feeds skeletion-effect" v-if="$fetchState.pending">
            <div class="container">
                <div class="row">
                <div class="col">
                    <h2 class="section-heading skeletion-animation text"></h2>
                    <p class="section-subheading skeletion-animation litext"></p>
                </div>
                </div>
            </div>
            <div class="insta-feeds-wrap">
                <div class="row g-0">
                    <div class="col"><div class="card-img-top rounded-0 thumb-img skeletion-animation text" src="" alt=""></div></div>
                    <div class="col"><div class="card-img-top rounded-0 thumb-img skeletion-animation text" src="" alt=""></div></div>
                    <div class="col"><div class="card-img-top rounded-0 thumb-img skeletion-animation text" src="" alt=""></div></div>
                    <div class="col"><div class="card-img-top rounded-0 thumb-img skeletion-animation text" src="" alt=""></div></div>
                    <div class="col"><div class="card-img-top rounded-0 thumb-img skeletion-animation text" src="" alt=""></div></div>
                    <div class="col"><div class="card-img-top rounded-0 thumb-img skeletion-animation text" src="" alt=""></div></div>
                    <div class="col"><div class="card-img-top rounded-0 thumb-img skeletion-animation text" src="" alt=""></div></div>
                    <div class="col"><div class="card-img-top rounded-0 thumb-img skeletion-animation text" src="" alt=""></div></div>
                    <div class="col"><div class="card-img-top rounded-0 thumb-img skeletion-animation text" src="" alt=""></div></div>
                </div>
            </div>
        </section>
  <section class="insta-feeds" v-else>
       <div class="container">
         <div class="row">
           <div class="col">
              <h2 class="section-heading">{{ this.$t("web.home.news.heading.text1") }}<span>{{ this.$t("web.home.news.heading.text2") }}</span></h2>
              <p class="section-subheading">{{ this.$t("web.home.news.description") }}</p>
           </div>
         </div>
      </div>
      <div class="insta-feeds-wrap" v-if="instagram && instagram.length > 0">
        <VueSlickCarousel v-bind="settings">
          <div
          v-for="(post,index) in instagram" :key="index">
          <h3 class="img-section">
            <a target="_blank" :href="post['permalink']"><img :src="post['media_url']"  width="450" height="300"/></a>
            </h3>
            </div>
        </VueSlickCarousel>
      </div>
  </section>
</template>

<script>
export default {
    async fetch(){
        const instagram = await this.$webService.fetchInstagramMedia();
        if(instagram){
            this.instagram = instagram.data;
        }
    },
  data(){
    return{
        "instagram" : [],
      settings:{

        "arrows": false,
        "dots": false,
        "infinite": true,
        "slidesToShow": 9,
        "slidesToScroll": 1,
        "autoplay": true,
        "speed": 2000,
        "autoplaySpeed": 2000,
        "cssEase": "linear",
        "responsive": [
          {
            "breakpoint": 1199,
            "settings": {
              "slidesToShow": 8
            }
          },
          {
            "breakpoint": 991,
            "settings": {
              "slidesToShow": 6
            }
          },
          {
            "breakpoint": 767,
            "settings": {
              "slidesToShow": 4
            }
          },
          {
            "breakpoint": 480,
            "settings": {
              "slidesToShow": 2,
              "slidesToScroll": 1
            }
          }
        ]
      }
    }
  }
}
</script>
<style>
</style>
