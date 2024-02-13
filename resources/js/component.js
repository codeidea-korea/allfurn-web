function openModal(name) {
  $(`${name}`).css('display', 'block');
  $('body').css('overflow', 'hidden');
};

function closeModal (name) {
  $(`${name}`).css('display', 'none');
  $('body').css('overflow', 'initial');
}

$('.modal-type--single').on('click', function() {
  openModal('#modal-type--single');
});

$('.modal-type--pair').on('click', function() {
  openModal('#modal-type--pair');
});

$('.modal-type--basic').on('click', function() {
  openModal('#modal-type--basic');
});

$('.modal-close').on('click', function (event) {
  event.preventDefault();
  closeModal('#modal-type--basic');
})

$(".textfield__search").on("propertychange change keyup paste input", function() {
  var currentVal = $(this).val();

  if(!(currentVal === '')) {
    $(this).parent().addClass('textfield--active');
  }else {
    $(this).parent().removeClass('textfield--active');
  }
});

$('.dropdown').on('click', function (evnet) {
  if(!$(this).hasClass('dropdown--disabled')) $(this).toggleClass('dropdown--active');

})

$('.dropdown__item').on('click', function (evnet) {
  evnet.preventDefault();
  $('.dropdown__title').text($(this).text().trim(' ').split('\n')[0]);
})
