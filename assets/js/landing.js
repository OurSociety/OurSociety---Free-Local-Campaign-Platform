import 'popper.js';
import 'bootstrap';

$('.js-back-to-top').click(function () {
  $('body, html').animate({ scrollTop: 0 }, 500);
});
