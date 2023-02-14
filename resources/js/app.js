require('./bootstrap');

$(function () {
  $(".edit-btn").each(function () {
    $(this).on('click', function () {
      var target = $(this).data('target');
      var modal = document.getElementById(target);
      console.log(modal);
      $(modal).fadeIn();
      return false;
    });
  });
  $("#modal-contents").on('click', function () {
    $('.edit-modal').fadeOut();
    return false;
  })
});
