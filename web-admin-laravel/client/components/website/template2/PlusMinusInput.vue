<template>
  <div id="plus-minus-counter">
    <div class="counter">{{ counter }}</div>
    <button class="icon-up" type="button" @click="increase"><fa :icon="['fas', 'plus']" class="" /></button>
    <button class="icon-down" type="button" @click="decrease"><fa :icon="['fas', 'minus']" class="" /></button>
    <button class="icon-reset" type="button" @click="reset"><fa :icon="['fas', 'times']" class="" /></button>
  </div>
</template>

<script>
  export default {
    data(){
      return {
        counter: 1,
      }
    },
    mounted(){
      if(this.initial){
        this.counter = this.initial
      }
      else{
        this.counter = this.min
      }
    },
    props:{
      max:{
        required:false
      },
    min:{
      default:1,
      required:false
    },
    initial:{
      required:false
    }
    },
    methods: {
      increase() {
          if(this.max){
            if(this.counter < this.max){
             this.counter++;
             this.$emit('input',this.counter)
             this.$emit('change')
            }
          }
        else{
          this.$emit('input',this.counter)
          this.$emit('change')
          this.counter++
        }
      },
      decrease() {
        if(this.counter >this.min){
          this.counter--;
          this.$emit('input',this.counter)
          this.$emit('change')
        }
      },
      reset() {
        var count = this.counter
        if(this.initial){
          this.counter = this.initial
        }
        else{
          this.counter = this.min;
        }
        if(this.counter != count){
          this.$emit('change')
        }
        this.$emit('input',this.counter)
      }
    },
  }
</script>


<style>

</style>
