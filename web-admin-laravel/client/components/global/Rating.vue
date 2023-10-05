<template>
    <div class="stars" v-bind:style="{'--rating': rating}" aria-label="Rating of this product is 2.3 out of 5."><span>({{this.rating}})</span></div>
</template>

<script>
export default {
  props:['rating'],
  data(){
    return {
    }
  },
}
</script>
