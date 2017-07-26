Array.from(document.querySelectorAll('.watermark')).forEach(function(el) {
  let temp = el.dataset.watermark + ' — ';
  // Unfortunately string.prototype.repeat isn't supported in all browsers yet.
  for (let i = 0; i < 12; i++) {
    temp += temp;
  }
  el.dataset.watermark = temp;
});
