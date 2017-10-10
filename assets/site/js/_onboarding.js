import $ from 'jquery';
import 'selectize';
import '../../../node_modules/selectize/dist/css/selectize.bootstrap3.css';

let convertToAutocomplete = function (index, element) {
  element = $(element);
  element.selectize({
    maxItems: element.data('max-items') || 1,
    maxOptions: element.data('max-options') || 10,
    hideSelected: element.data('hide-selected'),
    closeAfterSelect: element.data('close-after-select'),
    create: !element.data('exact-match'),
    persist: false,
    render: {
      'option_create': function(data, escape) {
        return '<div class="create">🔍 <strong> ' + escape(data.input) + '</strong>&hellip;</div>';
      }
    },
    load: function (query, callback) {
      let data = {};

      data[element.data('filter-field') || element.attr('name')] = query;

      let dependentOn = element.data('dependent-on');
      let $dependentOn = $('#' + dependentOn);
      if (dependentOn && $dependentOn.val()) {
        data[element.data('dependent-on-field')] = $dependentOn.val();
      }
      $.ajax({
        url: element.data('url'),
        dataType: 'json',
        data: data,
        error: function() {
          callback();
        },
        success: function(res) {
          callback($.map(res.data, function (name, id) {
            return {value: id, text: name};
          }));
        }
      });
    }
  });
};

// $('[aria-autocomplete="both"]').each(convertToAutocomplete);
$('#electoral-district-id').each(convertToAutocomplete);
