//モーダル表示
$(function () {
  $('.modalopen').each(function () {
    $(this).on('click', function () {
      var target = $(this).data('target');
      var modal = document.getElementById(target);
      console.log(modal);
      $(modal).fadeIn();
      $('.overlay').fadeIn();
      //return false;
    });
  });

  //背景で消えるようにする
  $('.overlay').on('click', function () {
    $('.overlay, .editmodal').fadeOut();
    return false;
  });
});

//$('#save').click(function () {
//var editPost = $('#editPost').val();
//$(".post-text").text(editPost);
//});

$('.accordion-title').click(function () {
  $('.arrow').toggleClass('add');
});
