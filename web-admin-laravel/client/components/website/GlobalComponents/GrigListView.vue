<template>
  <div class="d-flex">
    <div class="list-view-gird mb-md-0" v-if="currentlyActiveTemplate == 'Template1'">
    <label class="text-medium me-2">{{ $t("view_as") }}</label>
    <a onclick="return false;" href="#" @click="changeView('col-lg-6')" class="gird-icon row-list" :class="grid_class == 'col-lg-6' ? 'active':''"></a>
    <a onclick="return false;" href="#" @click="changeView('col-lg-6')" class="gird-icon two-col" :class="grid_class == 'col-lg-6' ? 'active':''"></a>
    <a onclick="return false;" href="#" @click="changeView('col-lg-4')" class="gird-icon three-col" :class="grid_class == 'col-lg-4' || grid_class == 'col-sm-6 col-lg-4' ? 'active':'' "></a>
    <a onclick="return false;" href="#" @click="changeView('col-lg-3')" class="gird-icon four-col" :class="grid_class == 'col-lg-3' ? 'active':'' || grid_class == 'col-md-3' ? 'active':''"></a>
  </div>
  <div class="list-view-gird bg-secondary w-100 d-none d-lg-block" v-if="currentlyActiveTemplate == 'Template2'">
    <!-- <label class="text-medium me-2">{{ $t("view_as") }}</label> -->
    <a onclick="return false;" href="#" @click="changeView('col-lg-6 col-list')" class="gird-icon row-list me-3" :class="grid_class == 'col-lg-6 col-list' ? 'active':''">
        <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" width="25" height="25" x="0" y="0" viewBox="0 0 24 24" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g transform="matrix(3.061616997868383e-16,1,-1,3.061616997868383e-16,23.999999999999996,-3.552713678800501e-15)"><path xmlns="http://www.w3.org/2000/svg" d="m0 18v5c0 .552.448 1 1 1h5c.552 0 1-.448 1-1v-5c0-.552-.448-1-1-1h-5c-.552 0-1 .448-1 1z" fill="currentColor" data-original="currentColor" class=""></path><path xmlns="http://www.w3.org/2000/svg" d="m6 0h-5c-.552 0-1 .448-1 1v13.5c0 .552.448 1 1 1h5c.552 0 1-.448 1-1v-13.5c0-.552-.448-1-1-1z" fill="currentColor" data-original="currentColor" class=""></path><path xmlns="http://www.w3.org/2000/svg" d="m15.5 14.5v-13.5c0-.552-.448-1-1-1h-5c-.552 0-1 .448-1 1v13.5c0 .552.448 1 1 1h5c.552 0 1-.448 1-1z" fill="currentColor" data-original="currentColor" class=""></path><path xmlns="http://www.w3.org/2000/svg" d="m8.5 18v5c0 .552.448 1 1 1h5c.552 0 1-.448 1-1v-5c0-.552-.448-1-1-1h-5c-.552 0-1 .448-1 1z" fill="currentColor" data-original="currentColor" class=""></path><path xmlns="http://www.w3.org/2000/svg" d="m23 0h-5c-.552 0-1 .448-1 1v13.5c0 .552.448 1 1 1h5c.552 0 1-.448 1-1v-13.5c0-.552-.448-1-1-1z" fill="currentColor" data-original="currentColor" class=""></path><path xmlns="http://www.w3.org/2000/svg" d="m18 24h5c.552 0 1-.448 1-1v-5c0-.552-.448-1-1-1h-5c-.552 0-1 .448-1 1v5c0 .552.448 1 1 1z" fill="currentColor" data-original="currentColor" class=""></path></g></svg>
    </a>
    <a onclick="return false;" href="#" @click="changeView('col-lg-6 last-col-6')" class="gird-icon two-col me-3" :class="grid_class == 'col-lg-6 last-col-6' ? 'active':''">
        <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" width="25" height="25" x="0" y="0" viewBox="0 0 32 32" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><rect xmlns="http://www.w3.org/2000/svg" height="14" rx="1" width="14" x="1" y="17" fill="currentColor" data-original="currentColor" class=""></rect><rect xmlns="http://www.w3.org/2000/svg" height="14" rx="1" width="14" x="17" y="17" fill="currentColor" data-original="currentColor" class=""></rect><rect xmlns="http://www.w3.org/2000/svg" height="14" rx="1" width="14" x="1" y="1" fill="currentColor" data-original="currentColor" class=""></rect><rect xmlns="http://www.w3.org/2000/svg" height="14" rx="1" width="14" x="17" y="1" fill="currentColor" data-original="currentColor" class=""></rect></g></svg>
    </a>
    <a onclick="return false;" href="#" @click="changeView('col-lg-4 last-col-4')" class="gird-icon three-col me-3" :class="grid_class == 'col-lg-4 last-col-4' ? 'active':''">
        <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" width="25" height="25" x="0" y="0" viewBox="0 0 32 32" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><g xmlns="http://www.w3.org/2000/svg"><path d="m22.819 22.818h9.181v9.182h-9.181z" fill="currentColor" data-original="currentColor" class=""></path><path d="m11.643 22.818h8.714v9.182h-8.714z" fill="currentColor" data-original="currentColor" class=""></path><path d="m0 22.818h9.182v9.182h-9.182z" fill="currentColor" data-original="currentColor" class=""></path><path d="m0 11.643h9.182v8.714h-9.182z" fill="currentColor" data-original="currentColor" class=""></path><path d="m11.643 11.643h8.714v8.714h-8.714z" fill="currentColor" data-original="currentColor" class=""></path><path d="m22.819 11.643h9.181v8.714h-9.181z" fill="currentColor" data-original="currentColor" class=""></path><path d="m22.819 0h9.181v9.181h-9.181z" fill="currentColor" data-original="currentColor" class=""></path><path d="m11.643 0h8.714v9.181h-8.714z" fill="currentColor" data-original="currentColor" class=""></path><path d="m0 0h9.182v9.181h-9.182z" fill="currentColor" data-original="currentColor" class=""></path></g></g></svg>
    </a>
    <a onclick="return false;" href="#" @click="changeView('col-lg-3 last-col-3')" class="gird-icon four-col me-3" :class="grid_class == 'col-lg-3 last-col-3' || grid_class == 'col-lg-3 last-col-3' ? 'active':'' ">
        <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" width="25" height="25" x="0" y="0" viewBox="0 0 397.061 397.061" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g>
<g xmlns="http://www.w3.org/2000/svg">
	<g>
		<g>
			<rect x="104.49" y="208.98" width="83.592" height="83.592" fill="currentColor" data-original="currentColor" class=""></rect>
			<rect x="104.49" y="0" width="83.592" height="83.592" fill="currentColor" data-original="currentColor" class=""></rect>
			<rect x="104.49" y="313.469" width="83.592" height="83.592" fill="currentColor" data-original="currentColor" class=""></rect>
			<rect x="104.49" y="104.49" width="83.592" height="83.592" fill="currentColor" data-original="currentColor" class=""></rect>
			<rect x="5.224" y="208.98" width="78.367" height="83.592" fill="currentColor" data-original="currentColor" class=""></rect>
			<rect x="5.224" y="313.469" width="78.367" height="83.592" fill="currentColor" data-original="currentColor" class=""></rect>
			<rect x="5.224" y="0" width="78.367" height="83.592" fill="currentColor" data-original="currentColor" class=""></rect>
			<rect x="5.224" y="104.49" width="78.367" height="83.592" fill="currentColor" data-original="currentColor" class=""></rect>
			<rect x="208.98" y="208.98" width="83.592" height="83.592" fill="currentColor" data-original="currentColor" class=""></rect>
			<rect x="313.469" y="104.49" width="78.367" height="83.592" fill="currentColor" data-original="currentColor" class=""></rect>
			<rect x="313.469" y="208.98" width="78.367" height="83.592" fill="currentColor" data-original="currentColor" class=""></rect>
			<rect x="313.469" y="0" width="78.367" height="83.592" fill="currentColor" data-original="currentColor" class=""></rect>
			<rect x="208.98" y="313.469" width="83.592" height="83.592" fill="currentColor" data-original="currentColor" class=""></rect>
			<rect x="208.98" y="104.49" width="83.592" height="83.592" fill="currentColor" data-original="currentColor" class=""></rect>
			<rect x="208.98" y="0" width="83.592" height="83.592" fill="currentColor" data-original="currentColor" class=""></rect>
			<rect x="313.469" y="313.469" width="78.367" height="83.592" fill="currentColor" data-original="currentColor" class=""></rect>
		</g>
	</g>
</g>
<g xmlns="http://www.w3.org/2000/svg">
</g>
<g xmlns="http://www.w3.org/2000/svg">
</g>
<g xmlns="http://www.w3.org/2000/svg">
</g>
<g xmlns="http://www.w3.org/2000/svg">
</g>
<g xmlns="http://www.w3.org/2000/svg">
</g>
<g xmlns="http://www.w3.org/2000/svg">
</g>
<g xmlns="http://www.w3.org/2000/svg">
</g>
<g xmlns="http://www.w3.org/2000/svg">
</g>
<g xmlns="http://www.w3.org/2000/svg">
</g>
<g xmlns="http://www.w3.org/2000/svg">
</g>
<g xmlns="http://www.w3.org/2000/svg">
</g>
<g xmlns="http://www.w3.org/2000/svg">
</g>
<g xmlns="http://www.w3.org/2000/svg">
</g>
<g xmlns="http://www.w3.org/2000/svg">
</g>
<g xmlns="http://www.w3.org/2000/svg">
</g>
        </g></svg>
    </a>
    <a onclick="return false;" href="#" @click="changeView('col-lg-2 last-col-2')" class="gird-icon six-col" :class="grid_class == 'col-lg-2 last-col-2' ? 'active':'' || grid_class == 'col-lg-2 last-col-2' ? 'active':''">
        <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" width="25" height="25" x="0" y="0" viewBox="0 0 34.25 34.25" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g>
<g xmlns="http://www.w3.org/2000/svg">
	<g>
		<rect width="5.185" height="5.275" fill="currentColor" data-original="currentColor" class=""></rect>
		<rect x="7.132" width="5.187" height="5.275" fill="currentColor" data-original="currentColor" class=""></rect>
		<rect x="14.266" width="5.185" height="5.275" fill="currentColor" data-original="currentColor" class=""></rect>
		<rect x="21.398" width="5.185" height="5.275" fill="currentColor" data-original="currentColor" class=""></rect>
		<rect x="29.064" width="5.186" height="5.275" fill="currentColor" data-original="currentColor" class=""></rect>
		<rect y="7.244" width="5.185" height="5.274" fill="currentColor" data-original="currentColor" class=""></rect>
		<rect x="7.132" y="7.244" width="5.187" height="5.274" fill="currentColor" data-original="currentColor" class=""></rect>
		<rect x="14.266" y="7.244" width="5.185" height="5.274" fill="currentColor" data-original="currentColor" class=""></rect>
		<rect x="21.398" y="7.244" width="5.185" height="5.274" fill="currentColor" data-original="currentColor" class=""></rect>
		<rect x="29.064" y="7.244" width="5.186" height="5.274" fill="currentColor" data-original="currentColor" class=""></rect>
		<rect y="14.487" width="5.185" height="5.275" fill="currentColor" data-original="currentColor" class=""></rect>
		<rect x="7.132" y="14.487" width="5.187" height="5.275" fill="currentColor" data-original="currentColor" class=""></rect>
		<rect x="14.266" y="14.487" width="5.185" height="5.275" fill="currentColor" data-original="currentColor" class=""></rect>
		<rect x="21.398" y="14.487" width="5.185" height="5.275" fill="currentColor" data-original="currentColor" class=""></rect>
		<rect x="29.064" y="14.487" width="5.186" height="5.275" fill="currentColor" data-original="currentColor" class=""></rect>
		<rect y="21.73" width="5.185" height="5.274" fill="currentColor" data-original="currentColor" class=""></rect>
		<rect x="7.132" y="21.73" width="5.187" height="5.274" fill="currentColor" data-original="currentColor" class=""></rect>
		<rect x="14.266" y="21.73" width="5.185" height="5.274" fill="currentColor" data-original="currentColor" class=""></rect>
		<rect x="21.398" y="21.73" width="5.185" height="5.274" fill="currentColor" data-original="currentColor" class=""></rect>
		<rect x="29.064" y="21.73" width="5.186" height="5.274" fill="currentColor" data-original="currentColor" class=""></rect>
		<rect y="28.975" width="5.185" height="5.275" fill="currentColor" data-original="currentColor" class=""></rect>
		<rect x="7.132" y="28.975" width="5.187" height="5.275" fill="currentColor" data-original="currentColor" class=""></rect>
		<rect x="14.266" y="28.975" width="5.185" height="5.275" fill="currentColor" data-original="currentColor" class=""></rect>
		<rect x="21.398" y="28.975" width="5.185" height="5.275" fill="currentColor" data-original="currentColor" class=""></rect>
		<rect x="29.064" y="28.975" width="5.186" height="5.275" fill="currentColor" data-original="currentColor" class=""></rect>
	</g>
</g>
<g xmlns="http://www.w3.org/2000/svg">
</g>
<g xmlns="http://www.w3.org/2000/svg">
</g>
<g xmlns="http://www.w3.org/2000/svg">
</g>
<g xmlns="http://www.w3.org/2000/svg">
</g>
<g xmlns="http://www.w3.org/2000/svg">
</g>
<g xmlns="http://www.w3.org/2000/svg">
</g>
<g xmlns="http://www.w3.org/2000/svg">
</g>
<g xmlns="http://www.w3.org/2000/svg">
</g>
<g xmlns="http://www.w3.org/2000/svg">
</g>
<g xmlns="http://www.w3.org/2000/svg">
</g>
<g xmlns="http://www.w3.org/2000/svg">
</g>
<g xmlns="http://www.w3.org/2000/svg">
</g>
<g xmlns="http://www.w3.org/2000/svg">
</g>
<g xmlns="http://www.w3.org/2000/svg">
</g>
<g xmlns="http://www.w3.org/2000/svg">
</g>
        </g></svg>
    </a>
  </div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";

export default {
props:['grid_class'],
  data() {
    return {
      currentlyActiveTemplate: "",
    };
  },
  created() {
    this.currentlyActiveTemplate =
      this.allSettings.general_settings.currently_active_theme;
  },
  methods:{
    changeView(classToUpdate){
      this.$emit('changeGridClass',classToUpdate)
    }
  },
    computed: {
    ...mapGetters({
      allSettings: "allDefaultSettings",
    }),
  },
}
</script>

<style>

</style>
