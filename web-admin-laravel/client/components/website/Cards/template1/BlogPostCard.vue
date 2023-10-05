<template>
  <div class="card border-1 shadow rounded-0 bg-transparent overflow-hidden h-100">
    <nuxt-link :to="`/blog/${post.slug}`">
      <div class="img-wrap">
        <img v-if="post.image" class="card-img-top rounded-0" :src="`/backend${post.image.thumbnails.medium.thumbnail}`" :alt="post.image.alt_text">
        <img v-else class="card-img-top rounded-0" src="~/assets/images/blog-img1.jpg" alt="Card image cap">
      </div>
    </nuxt-link>
    <div class="card-body">
      <h5 class="mb-2 text-uppercase">
       <nuxt-link :to="`/blog/${post.slug}`">{{post.name}} </nuxt-link>
      </h5>
      <h6 class="mb-2">
          By {{post.user}} on<br> {{post.created_at}}
      </h6>
      <div v-html="post.description_web" class=" mb-3 blog-detail">
      </div>
      <nuxt-link :to="`/blog/${post.slug}`" class="fw-bold">{{$t('read_more')}}</nuxt-link>
    </div>
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
