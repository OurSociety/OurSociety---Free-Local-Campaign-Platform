import moment from 'moment'
import 'tempusdominus-bootstrap-4'
import 'moment/locale/en-gb'; // import specified locale module
moment.locale('en-gb');
$(function() {

  $('[role=datetime-picker]').each(function() {

    let picker = $(this);
    let date = null;

    if (picker.data('timestamp') && picker.data('timezone-offset')) {
      let timezoneOffset = picker.data('timezone-offset');
      date = new Date(picker.data('timestamp') * 1000);

      picker.parents('form').on('submit', function () {
        let timezoneDiff = timezoneOffset + date.getTimezoneOffset();
        let currentDate = picker.data('DateTimePicker').date();
        let convertedDate = currentDate.add(timezoneDiff, 'minutes');
        picker.data('DateTimePicker').date(convertedDate);
      });
    }

    picker.datetimepicker({
      locale: $(this).data('locale'),
      format: $(this).data('format'),
      date: date ? date : picker.val()
    });
  });

});
