$(document).ready(function () {
  "use strict";

  /**
   * @param {element} dropdown
   * @param {string} transition
   * @param {number} delay
   */
  let transitionDropdown = function (dropdown, transition, delay) {
    dropdown.find('.dropdown-menu').first().stop(true, true)[transition](delay);
  }

  let onDropdownShow = function () {
    transitionDropdown($(this), 'slideDown', 300);
  };

  let onDropdownHide = function () {
    transitionDropdown($(this), 'slideUp', 200);
  };

  let $dropdowns = $('.dropdown');
  $dropdowns.on('show.bs.dropdown', onDropdownShow);
  $dropdowns.on('hide.bs.dropdown', onDropdownHide);
});
