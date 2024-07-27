$(document).ready(function () {
  $('.c-page').readtime({
    wpm: 200,
    format: '#',
    images: 12,
    callback: function (result) {
      console.log(result); // Выводит результат в консоль
    }
  });
});
