// import 'popper.js';
// import 'bootstrap';
// import 'tether';
// import './main.scss';

import 'bootstrap-sass';
import 'jdenticon/dist/jdenticon.js'
import './bootstrap';
import './app/editor.js';
import './app/question.js';
import './app/watermark.js';
import ProfilePicture from './Components/ProfilePicture.vue';

// import Vue from 'vue'



const app = new Vue({
  el: '#app',
  components: {
    profilePicture: ProfilePicture,
  }
});

class Welcome {
  constructor() {
    console.log('Welcome to OurSociety!');
  }
}

new Welcome();

// window.Vue = require('vue');
// window.Inputmask = require('inputmask');
//
// Vue.directive('input-mask', function(el, binding) {
//   new Inputmask({ mask: binding.expression }).mask(el);
// });
//
//new Vue({ el: '#app' });
