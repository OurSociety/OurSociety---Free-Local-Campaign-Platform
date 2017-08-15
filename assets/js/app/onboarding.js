import 'selectize';
import '../../../node_modules/selectize/dist/css/selectize.bootstrap3.css'

let xhr;
// let select_state, $select_state;
let select_city, $select_city;

// $select_state = $('#select-onboarding-state').selectize({
//   onChange: function(value) {
//     if (!value.length) return;
//     select_city.disable();
//     select_city.clearOptions();
//     select_city.load(function(callback) {
//       xhr && xhr.abort();
//       xhr = $.ajax({
//         url: 'https://jsonp.afeld.me/?url=http://api.sba.gov/geodata/primary_city_links_for_state_of/' + value + '.json',
//         success: function(results) {
//           select_city.enable();
//           callback(results);
//         },
//         error: function() {
//           callback();
//         }
//       })
//     });
//   }
// });

$select_city = $('#electoral-district-id').selectize();

// select_city  = $select_city[0].selectize;
// select_state = $select_state[0].selectize;

// select_city.disable();
