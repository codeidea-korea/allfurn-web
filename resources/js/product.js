$(".product-bookmark").on("click", function () {
  $(this).toggleClass("active");
});

$(".order-info__title").on("click", function () {
  $(this).toggleClass("active");
});

const length = $('.left-wrap__img--small').children('li').length;
const nextButton = $('.left-wrap__arrow .ico_next');
const backButton = $('.left-wrap__arrow .ico_back');
let selectImgSrc = '';
let selected = '';

if($('.left-wrap__img--small li').first().hasClass('selected')) {
  backButton.removeClass('active');
  nextButton.addClass('active');
}

$('.left-wrap__img--small button').on('click', function () {
   selectImgSrc = $(this).children('img').attr('src');

  $('.left-wrap__img--small li').removeClass('selected');
  $(this).closest('li').addClass('selected');
  $('.left-wrap__img img').attr('src', selectImgSrc);

  $('.left-wrap__img--small li').each(function(index, item){
    if(item.classList[0] === 'selected') {
      if(index > 0){ 
        backButton.addClass('active');
        nextButton.addClass('active');
      }

      if(index === 0) {
        backButton.removeClass('active');
        nextButton.addClass('active');
      }

      if(index === length-1) {
        backButton.addClass('active');
        nextButton.removeClass('active');
      }
    }
  })
});

$('.product-detail__left-wrap .ico_next').on('click', function () {
  selected = $('.left-wrap__img--small .selected');
  selectImgSrc = selected.next().children('button').children('img').attr('src');

  if(selected.index() === length-2) {
    nextButton.removeClass('active');
    backButton.addClass('active');
  }

  if(selected.index() === 0 || selected.index() < length-2) {
    nextButton.addClass('active');
    backButton.addClass('active');
  } 

  selected.removeClass('selected').next().addClass('selected');
  $('.left-wrap__img img').attr('src', selectImgSrc);
});

$('.product-detail__left-wrap .ico_back').on('click', function () {
  selected = $('.left-wrap__img--small .selected');
  selectImgSrc = selected.prev().children('button').children('img').attr('src');

  if(selected.index() === 1) {
    backButton.removeClass('active');
    nextButton.addClass('active');
  }

  if(selected.index() === 0 || selected.index() > length-2) {
    nextButton.addClass('active');
    backButton.addClass('active');
  } 

  selected.removeClass('selected').prev().addClass('selected');
  $('.left-wrap__img img').attr('src', selectImgSrc);
});







