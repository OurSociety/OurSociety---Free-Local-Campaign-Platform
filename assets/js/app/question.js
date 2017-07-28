window.disableQuestion = function (e) {
  console.log(e);
};

let $question = $('.js-question');

$question.on('hide.bs.collapse', function () {
  $(this).find(':input').prop('disabled', true);
  $(this).find('.js-question-link').text('Answer Now');
});

$question.on('show.bs.collapse', function () {
  $(this).find(':input').prop('disabled', false);
  $(this).find('.js-question-link').text('Answer Later');
});
