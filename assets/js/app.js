// Vendor
import 'bootstrap-sass';
import 'jdenticon/dist/jdenticon.js'

// Application
import 'holderjs';
// import 'chart.js';
import './app/autocomplete';
import './app/editor';
import './app/question';
import './app/watermark';
import './app/onboarding';

// Browser
window.$ = window.jQuery = require('jquery');

// VueJS (Un-used)
// import './bootstrap';
// import Vue from 'vue'
// import ProfilePicture from './Components/ProfilePicture.vue';
//
// window.Vue = require('vue');
// window.Inputmask = require('inputmask');
//
// Vue.directive('input-mask', function(el, binding) {
//   new Inputmask({ mask: binding.expression }).mask(el);
// });
//
// const app = new Vue({
//   el: '#app',
//   components: {
//     profilePicture: ProfilePicture,
//   }
// });
