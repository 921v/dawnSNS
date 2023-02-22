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

  $(function () {
    $(".a-click").click(function () {
      if ($(".arrow").hasClass('.active')) {
        $(".a-contents").slideToggle(300);
        $(".arrow").removeClass(".active");
        $(".arrow").css("transform", "rotateX(0deg)");
      } else {
        $(".a-contents").slideToggle(300);
        $(".arrow").addClass(".active");
        $(".arrow").css("transform", "rotateX(180deg)");
      }
    });
  });


  //背景で消えるようにする
  $('.overlay').on('click', function () {
    $('.overlay, .editmodal').fadeOut();
    $('body').removeClass('no_scroll');
    return false;
  });
});
