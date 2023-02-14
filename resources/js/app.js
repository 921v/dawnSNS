require('./bootstrap');

$(function () {
  $(".modalopen").each(function () {
    $(this).on('click', function () {
      var target = $(this).data('target');
      var editmodal = document.getElementById(target);
      console.log(editmodal);
      $(editmodal).fadeIn();
      return false;
    });
  });
  $(".post-edit-btn").on('click', function () {
    $('.editmodal').fadeOut();
    return false;
  })
});
