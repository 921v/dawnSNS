//モーダル表示
$(function () {
  $('.modalopen').each(function () {
    $(this).on('click', function () {
      var target = $(this).data('target');
      var modal = document.getElementById(target);
      console.log(modal);
      $(modal).fadeIn();
      $('.overlay').fadeIn();
      $('body').addClass('no_scroll');
      return false;
    });
  });

  //背景で消えるようにする
  $('.overlay').on('click', function () {
    $('.overlay, .editmodal').fadeOut();
    $('body').removeClass('no_scroll');
    return false;
  });
});

$('.accordion-title').click(function () {
  $('span').toggleClass('add');
});
