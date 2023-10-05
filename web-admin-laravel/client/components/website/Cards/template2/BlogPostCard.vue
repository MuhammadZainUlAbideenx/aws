<template>
  <div class="card border-0 rounded-0 bg-transparent p-0 h-100 blog-hover">
    <nuxt-link :to="`/blog/${post.slug}`" class="h-100">
      <div class="img-wrap h-100">
        <img v-if="post.image" class="card-img-top rounded-0" :src="`/backend${post.image.thumbnails.medium.thumbnail}`" :alt="post.image.alt_text">
        <img v-else class="card-img-top rounded-0" src="~/assets/images/blog-img1.jpg" alt="Card image cap">
      </div>
         <div class="blog-heading">
           <h1><nuxt-link :to="`/blog/${post.slug}`">{{post.name}}</nuxt-link></h1>
          </div>
    </nuxt-link>

  </div>
</template>
<style media="screen">

</style>
<script type="text/javascript">
  export default {
    props:['post'],
    data(){
      return{
      }
    },
  methods:{
  },
  computed:{
  }
}
</script>
