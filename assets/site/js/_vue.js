import Vue from 'vue'
import PasswordField from './components/PasswordField.vue';
import PlaceSearch from './components/PlaceSearch.vue';

window.Vue = Vue;

// Vue.component('PasswordField', require('./components/PasswordField.vue'));

const app = new Vue({
  el: '#app',
  components: {
    passwordField: PasswordField, // password strength meter
    placeSearch: PlaceSearch, // password strength meter
  }
});
