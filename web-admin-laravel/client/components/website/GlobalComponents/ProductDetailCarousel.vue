<template>
   <div>
     <div class="product-detail-carousel p-0 bg-transparent" v-if="currentlyActiveTemplate == 'Template1'">
        <VueSlickCarousel ref="c1" :asNavFor="c2" :focusOnSelect="true" class="shadow mb-4">
            <div v-for="file in media" :key="file.id">
              <div class="img-wrap" v-if="file.type == 'image'">
                <img :src="`/backend${file.thumbnails.large.thumbnail}`" :alt="file.alt_text">
              </div>
              <div class="img-wrap" v-if="file.type == 'video'">
                <video width="auto" height="auto" controls :src="`/backend${file.original_media_path}`" :alt="file.alt_text"></video>
              </div>
            </div>
             <div v-if="media.length == 0" >
              <div class="img-wrap" >
                <img src="~/assets/images/defult-product-img.png" alt="">
              </div>
            </div>
        </VueSlickCarousel>
        <VueSlickCarousel ref="c2" :asNavFor="c1" :slidesToShow="4" :focusOnSelect="true">
          <div v-for="file in media" :key="file.id">
            <div class="img-wrap border rounded">
              <img :src="`/backend${file.thumbnails.small.thumbnail}`" :alt="file.alt_text">
            </div>
            </div>
            <div v-if="media.length == 0">
            <div class="img-wrap">
              <img src="~/assets/images/defult-product-img.png" alt="">
            </div>
            </div>
        </VueSlickCarousel>
        <!-- <span class="badge bg-primary">NEW</span>
        <span class="badge bg-danger">On Sale</span>
        <span class="badge bg-success">Featured</span> -->
    </div>
     <div class="product-detail-carousel p-0 bg-transparent" v-if="currentlyActiveTemplate == 'Template2'">
        <!-- <VueSlickCarousel ref="c1" :asNavFor="c2" :focusOnSelect="true">
            <div v-for="file in media" :key="file.id">
              <div class="img-wrap" v-if="file.type == 'image'">
                <img :src="`/backend${file.thumbnails.large.thumbnail}`" :alt="file.alt_text">
              </div>
              <div class="img-wrap" v-if="file.type == 'video'">
                <video width="auto" height="auto" controls :src="`/backend${file.original_media_path}`" :alt="file.alt_text"></video>
              </div>
            </div>
             <div v-if="media.length == 0" >
              <div class="img-wrap" >
                <img src="~/assets/images/defult-product-img.png" alt="">
              </div>
            </div>
        </VueSlickCarousel> -->
        <!-- <VueSlickCarousel ref="c2" :asNavFor="c1" :slidesToShow="4" :focusOnSelect="true">
          <div v-for="file in media" :key="file.id">
            <div class="img-wrap">
              <img :src="`/backend${file.thumbnails.small.thumbnail}`" :alt="file.alt_text">
            </div>
            </div>
            <div v-if="media.length == 0">
            <div class="img-wrap">
              <img src="~/assets/images/defult-product-img.png" alt="">
            </div>
            </div>
        </VueSlickCarousel> -->
        <!-- <span class="badge bg-primary">NEW</span>
        <span class="badge bg-danger">On Sale</span>
        <span class="badge bg-success">Featured</span> -->

        <div v-for="file in media" :key="file.id" class="mb-5">
              <div class="img-wrap" v-if="file.type == 'image'">
                <img :src="`/backend${file.thumbnails.large.thumbnail}`" :alt="file.alt_text">
              </div>
              <div class="img-wrap" v-if="file.type == 'video'">
                <video width="auto" height="auto" controls :src="`/backend${file.original_media_path}`" :alt="file.alt_text"></video>
              </div>
            </div>
             <div v-if="media.length == 0" >
              <div class="img-wrap" >
                <img src="~/assets/images/defult-product-img.png" alt="">
              </div>
        </div>
    </div>
   </div>
</template>

<script>
import { mapGetters } from "vuex";

export default {
  props:['media'],
  data(){
    return {
      c1:undefined,
      c2:undefined,
      currentlyActiveTemplate: "",

    }
  },
    created() {
    this.currentlyActiveTemplate = this.allSettings.general_settings.currently_active_theme;
  },
  mounted(){
    this.c1 = this.$refs.c1
    this.c2 = this.$refs.c2
  },
    computed: {
    ...mapGetters({
      allSettings: "allDefaultSettings",
    }),
  },
};
</script>

<style>

</style>
