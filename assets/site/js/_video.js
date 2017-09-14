$(function () {
  // Pause YouTube videos on tab switch.
  $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    let $videos = $(e.relatedTarget.hash).find('iframe');
    $videos.each(function(index, iframe){
      $(iframe).attr("src", $(iframe).attr("src"));
    });
  });
});
