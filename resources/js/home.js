// 가격 노출
$(".label--unexposed").on("click", function () {
  if ($(".radio__box--type01 input").is(":checked") == true) {
    // $(".select-group__dropdown").addClass("active");
    $(".select-group__dropdown").slideDown("");
  }
});
$(".label--exposure").on("click", function () {
  // $(".select-group__dropdown").removeClass("active");
  $(".select-group__dropdown").slideUp("");
});

// 결제 방식
$(".label--payment04").on("click", function () {
  if ($(".radio__box--type01 input").is(":checked") == true) {
    $(".payment__input-wrap").slideDown("");
  }
});
$(".label--payment01, .label--payment02, .label--payment03").on(
  "click",
  function () {
    $(".payment__input-wrap").slideUp("");
  }
);

// 인증 정보 기타 인증
$(".modal__auth-input-wrap").on("click", function () {
  if ($(".modal__auth-input-wrap input").is(":checked") == true) {
    $(".modal__auth-input").slideDown("");
    // $(".modal__border-bottom").css("border-bottom", "0");
  } else {
    $(".modal__auth-input").slideUp("");
    // $(".modal__border-bottom").css("border-bottom", "1px solid #F2F2F2");
  }
});

// 하단 바
$(window).scroll(function () {
  var windowHeight = $(window).innerHeight();
  var documentHeight = $(document).innerHeight();

  if ($(document).scrollTop() > documentHeight - (windowHeight + 237)) {
    $(".registration__footer").addClass("active");
  } else {
    $(".registration__footer").removeClass("active");
  }
});
