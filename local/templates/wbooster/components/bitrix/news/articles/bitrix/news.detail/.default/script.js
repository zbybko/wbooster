$(document).ready(function () {
  const timeInnerBlock = document.querySelector('[data-inner="time"]');
  $('.articles-detail').readtime({
    wpm: 160,
    format: '#',
    images: 12,
    readInnerBlock: timeInnerBlock
  });
});
