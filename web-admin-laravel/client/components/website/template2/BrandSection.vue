<template><div class="">
      <section class="brand-card skeletion-effect" v-if="allGenericData && allGenericData.brands == null">
            <div class="container">
                 <div class="row">
                <div class="col">
                    <h2
                        class="section-heading-left skeletion-animation text"
                    ></h2>
                </div>
            </div>
                <div class="row">
                    <div class="col-md-2 col-4">
                        <div class="card skeletion-animation border-0 rounded-0" style="height:70px">
                        </div>
                    </div>
                    <div class="col-md-2 col-4">
                        <div class="card skeletion-animation border-0 rounded-0" style="height:70px">
                        </div>
                    </div>
                    <div class="col-md-2 col-4">
                        <div class="card skeletion-animation border-0 rounded-0" style="height:70px">
                        </div>
                    </div>
                    <div class="col-md-2 d-md-block d-none">
                        <div class="card skeletion-animation border-0 rounded-0" style="height:70px">
                        </div>
                    </div>
                    <div class="col-md-2 d-md-block d-none">
                        <div class="card skeletion-animation border-0 rounded-0" style="height:70px">
                        </div>
                    </div>
                    <div class="col-md-2 d-md-block d-none">
                        <div class="card skeletion-animation border-0 rounded-0" style="height:70px">
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-2 col-4">
                        <div class="card skeletion-animation border-0 rounded-0" style="height:70px">
                        </div>
                    </div>
                    <div class="col-md-2 col-4">
                        <div class="card skeletion-animation border-0 rounded-0" style="height:70px">
                        </div>
                    </div>
                    <div class="col-md-2 col-4">
                        <div class="card skeletion-animation border-0 rounded-0" style="height:70px">
                        </div>
                    </div>
                    <div class="col-md-2 d-md-block d-none">
                        <div class="card skeletion-animation border-0 rounded-0" style="height:70px">
                        </div>
                    </div>
                    <div class="col-md-2 d-md-block d-none">
                        <div class="card skeletion-animation border-0 rounded-0" style="height:70px">
                        </div>
                    </div>
                    <div class="col-md-2 d-md-block d-none">
                        <div class="card skeletion-animation border-0 rounded-0" style="height:70px">
                        </div>
                    </div>
                </div>
            </div>
        </section>
  <section class="brand"  v-else-if="allGenericData && allGenericData.brands != null">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="section-heading text-start mb-3"> top brands</h2>
                        <VueSlickCarousel :key="key" v-bind="settings">
                            <div class="p-2" v-for="brand in allGenericData.brands" :key="brand.id"><img :src="`/backend/${brand.image.thumbnails.large.thumbnail}`" alt="" class="img-fluid"></div>
                        </VueSlickCarousel>
                    </div>
                </div>
          </div>
  </section>
    <div v-else>

  </div>
</div>

</template>

<script>
import { mapGetters } from "vuex";
export default {
    data() {
    return {
      key: 1,
      settings: {
              slidesToShow: 7,
              rows:2,
              arrows: false,
              dots:false,
              "autoplay": true,
        responsive: [
          {
            breakpoint: 1024,
            settings: {
              slidesToShow: 6,
              arrows: false,
              dots:false,
            },
          },

          {
            breakpoint: 480,
            settings: {
              slidesToShow:3,
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
