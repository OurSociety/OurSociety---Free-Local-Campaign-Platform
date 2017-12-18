import Vue from 'vue'
import ThumbnailMap from './components/ThumbnailMap.vue';
import PasswordField from './components/PasswordField.vue';
import PlaceSearch from './components/PlaceSearch.vue';

Vue.config.productionTip = false;

window.Vue = Vue; // export to browser

new Vue({
  el: '#app',
  components: {
    thumbnailMap: ThumbnailMap, // leaflet map
    passwordField: PasswordField, // password strength meter
    placeSearch: PlaceSearch, // password strength meter
  }
});
