// Load lodash
window._ = require('lodash');

// Load jQuery
window.$ = window.jQuery = require('jquery');

// Load Bootstrap 3.x JS
require('bootstrap-sass');

// Load/configure Axios
window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.headers.common['X-CSRF-TOKEN'] = document.head.querySelector('meta[name="csrf-token"]').content;

// Load VueJS 2.x
window.Vue = require('vue');
