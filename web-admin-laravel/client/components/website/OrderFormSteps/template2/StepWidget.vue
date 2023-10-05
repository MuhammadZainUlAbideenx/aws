<template>
  <div class="row step-count g-0 mb-5">
    <div class="col col-md-offset-1 step-count-step " v-bind:class="{'active':this.step >= 1}">
      <div class="text-center step-count-stepnum">{{$t('web.step_widget.information')}}</div>
      <div class="progress"><div class="progress-bar"></div></div>
      <a href="javascript:void(0)" v-on:click="moveToStep(1)" class="step-count-dot"></a>
    </div>

    <div class="col step-count-step " v-bind:class="{'active':this.step >= 2}">
      <div class="text-center step-count-stepnum">{{$t('web.step_widget.shipping_information')}}</div>
      <div class="progress"><div class="progress-bar"></div></div>
      <a href="javascript:void(0)" v-on:click="moveToStep(2)" class="step-count-dot"></a>
    </div>

    <div class="col step-count-step " v-bind:class="{'active':this.step >= 3}">
      <div class="text-center step-count-stepnum">{{$t('web.step_widget.shipping_method')}}</div>
      <div class="progress"><div class="progress-bar"></div></div>
      <a href="javascript:void(0)" v-on:click="moveToStep(3)" class="step-count-dot"></a>
    </div>

    <div class="col step-count-step " v-bind:class="{'active':this.step >= 4}">
      <div class="text-center step-count-stepnum">{{$t('web.step_widget.payment_information')}}</div>
      <div class="progress"><div class="progress-bar"></div></div>
      <a href="javascript:void(0)" v-on:click="moveToStep(4)" class="step-count-dot"></a>
    </div>
    <div class="col step-count-step " v-bind:class="{'active':this.step >= 5}">
      <div class="text-center step-count-stepnum">{{$t('web.step_widget.complete')}}</div>
      <div class="progress"><div class="progress-bar"></div></div>
      <a href="javascript:void(0)" v-on:click="moveToStep(5)" class="step-count-dot"></a>
    </div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
      data() {
      return {
      }
    },
    props:['step'],
    methods:{
        moveToStep(clickedStep)
        {
            this.$emit("step_clicked", clickedStep);
        }
    }
}
</script>

<style>

</style>
