<template>
  <div class="card page-background">
    <img v-if="image" class="card-img-top rounded-circle border" :src="`/backend${image.thumbnails.medium.thumbnail}`" :alt="image.alt_text">
    <img v-else class="card-img-top rounded-circle border" src="~/assets/images/testimonials-img1.png" alt="alt text">
    <div class="card-body">
      <h6 class="mb-1 text-center">{{review.product.name}}</h6>
      <div class="rating text-center mb-3 d-flex justify-content-center">
        <GlobalRating :rating="review.rating" />
      </div>
      <i class="mb-3">{{review.description}}</i>
      <h6 class="mb-0">{{review.customer.name}}</h6>
      <p class="post-date mb-0 opacity-5">{{review.rating}}</p>
    </div>
  </div>
</template>
<style media="screen">

</style>
<script type="text/javascript">
  export default {
    props:['review'],
    data(){
      return{
      }
    },
  methods:{
  },
  computed:{
    image(){
      if(this.review && this.review.product && this.review.product.media){
        const image =  this.review.product.media.find((single) => single.type == 'image')
        if(image){
          return image
        }
        else{
          return null
        }
      }
      else{
        return null
      }
    }
  }
}
</script>
