<template>
<!-- the below setction is skeleton of instagram and Newsletter field -->
        <!-- <section class="insta-feeds skeletion-effect">
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
        </section> -->
  <section class="insta-feeds">
       <div class="container">
         <div class="row">
           <div class="col">
              <h2 class="section-heading">{{ this.$t("web.home.news.heading.text1") }}<span>{{ this.$t("web.home.news.heading.text2") }}</span></h2>
              <p class="section-subheading">{{ this.$t("web.home.news.description") }}</p>
           </div>
         </div>
      </div>
      <div class="insta-feeds-wrap">
        <VueSlickCarousel v-bind="settings">
          <div><h3><img src="~/assets/images/slider.jpg" alt="..."></h3></div>
          <div><h3><img src="~/assets/images/blog-img1.jpg" alt="..."></h3></div>
          <div><h3><img src="~/assets/images/blog-img2.jpg" alt="..."></h3></div>
          <div><h3><img src="~/assets/images/flash-product-img1.jpg" alt="..."></h3></div>
          <div><h3><img src="~/assets/images/flash-product-img2.jpg" alt="..."></h3></div>
          <div><h3><img src="~/assets/images/product-img-2.jpg" alt="..."></h3></div>
          <div><h3><img src="~/assets/images/flash-product-img1.jpg" alt="..."></h3></div>
          <div><h3><img src="~/assets/images/flash-product-img2.jpg" alt="..."></h3></div>
          <div><h3><img src="~/assets/images/product-img-2.jpg" alt="..."></h3></div>
          <div><h3><img src="~/assets/images/slider.jpg" alt="..."></h3></div>
          <div><h3><img src="~/assets/images/blog-img1.jpg" alt="..."></h3></div>
          <div><h3><img src="~/assets/images/blog-img2.jpg" alt="..."></h3></div>
          <div><h3><img src="~/assets/images/flash-product-img1.jpg" alt="..."></h3></div>
          <div><h3><img src="~/assets/images/flash-product-img2.jpg" alt="..."></h3></div>
          <div><h3><img src="~/assets/images/product-img-2.jpg" alt="..."></h3></div>
          <div><h3><img src="~/assets/images/flash-product-img1.jpg" alt="..."></h3></div>
          <div><h3><img src="~/assets/images/flash-product-img2.jpg" alt="..."></h3></div>
          <div><h3><img src="~/assets/images/product-img-2.jpg" alt="..."></h3></div>
        </VueSlickCarousel>
      </div>
  </section>
</template>

<script>
export default {
  data(){
    return{
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
