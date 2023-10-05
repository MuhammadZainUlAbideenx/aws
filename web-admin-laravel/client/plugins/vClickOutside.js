import Vue from 'vue'
import vClickOutside from 'v-click-outside'

Vue.use(vClickOutside)
Vue.component("vClickOutside", vClickOutside);

Vue.directive('ripple', vClickOutside)
