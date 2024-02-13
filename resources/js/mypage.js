// head
$(".dropdown.dropdown--01").on("click", function () {
  $(this).toggleClass("dropdown--active");
  $(".dropdown.dropdown--02").removeClass("dropdown--active");
  $(".dropdown.dropdown--03").removeClass("dropdown--active");
});

$(".dropdown__item.dropdown__item--01").on("click", function (evnet) {
  evnet.preventDefault();
  $(".dropdown__title.dropdown__title--01").text(
    $(this).text().trim(" ").split("\n")[0]
  );
});

$(".dropdown.dropdown--02").on("click", function () {
  $(this).toggleClass("dropdown--active");
  $(".dropdown.dropdown--01").removeClass("dropdown--active");
  $(".dropdown.dropdown--03").removeClass("dropdown--active");
});

$(".dropdown__item.dropdown__item--02").on("click", function (evnet) {
  evnet.preventDefault();
  $(".dropdown__title.dropdown__title--02").text(
    $(this).text().trim(" ").split("\n")[0]
  );
});

// category-menu
let firstCount = 0;
let secondCount = 0;

$('.category-menu__title').on('click', function() {
	$('.category-menu').toggleClass('category-menu--active');
})

$('.category-menu__item').hover(function() {
	$('.category-menu__sub').removeClass('active');
	$(this).find('.category-menu__sub').addClass('active');
	if(!$(this).find('.category-menu__sub').hasClass('active')) {
		$('.category-menu__wrap').css('width', '250px');
	}else {
		$('.category-menu__wrap').css('width', '500px');
	}
})

$('.category-menu__sub-item').on('click', function() {
	if($(this).text().trim(' ') === '전체') {
		$('.category-menu__title a').html( $(this).closest('.category-menu__sub').prev().text());
	}else {
		$('.category-menu__title a').html( $(this).closest('.category-menu__sub').prev().text() + '>'+ $(this).text());
	}

	if($(this).text().trim(' ') === '일반소파') {
		$('.category-menu').removeClass('category-menu--active').addClass('select-menu');
		$('.category-filter').css('display', 'block').addClass('category-filter--active');
		$('.category-refresh').css('display', 'block');

		$('.category-refresh .category-filter__refresh').on('click', function () {
			$('.category-menu__title a').html('카테고리');
			$('.category-menu__item--active i').attr("class", $('.category-menu__item--active i').attr("class").split('--')[0])

			$('.category-refresh').css('display', 'none');
			$('.category-filter').css('display', 'none');
			$('.category-menu__item').removeClass('category-menu__item--active');
			$('.category-filter__refresh').removeClass('active');
		});
	}

	$('.category-menu').removeClass('category-menu--active');

	$.each($('.category-menu__item i'),function (index, item) {
		item.classList = item.classList[0].split('--on')[0];
	})
	$('.category-menu__item').removeClass('category-menu__item--active');
	$(this).closest('.category-menu__sub').parent().addClass('category-menu__item--active');
	$(this).closest('.category-menu__sub').prev().find('i').attr('class', $(this).closest('.category-menu__sub').prev().find('i').attr("class") + '--on');

});

// like & bookmark
$(".my__info .my__like").on("click", function (evnet) {
  $(this).toggleClass("active");
});

function openModal(name) {
	$(`${name}`).css('display', 'block');
	$('body').css('overflow', 'hidden');
}

function closeModal(name) {
	$(`${name}`).css('display', 'none');
	$('body').css('overflow', '');
}


//filter
$('.category-filter__arrow').on('click', function  () {
	if($(this).closest('.category-filter__item').hasClass('category-filter__item--active')) {
		$('.category-filter__item').removeClass('category-filter__item--active');
	}else {
		$('.category-filter__item').removeClass('category-filter__item--active');
		$(this).closest('.category-filter__item').toggleClass('category-filter__item--active');
	}
})

$('.category-filter__item button').on('click', function () {
	$(this).closest('p').toggleClass('select-button');
	$('.category-filter__footer').addClass('active');

	if($(this).closest('p').hasClass('select-button')) {
		$('.category-filter__data').append(`<button type='button'><span>` + $(this).text() + `</span></button>`);
	}else {
		$('.category-filter__data').innerHTML = $(this);
	}
});

$('.category-filter__title').on('click', function (event) {
	event.preventDefault();
	$('.category-filter__footer').removeClass('active');
	$('.category-filter').toggleClass('category-filter--active');
})

$('.category-filter__refresh').on('click' , function () {
	firstCount = 0;
	secondCount = 0;
	$('.category-type__item-1 .category__count').text(' ');
	$('.category-type__item-2 .category__count').text(' ');
	$('.category-filter__data button').remove();
	$('.category-filter__footer').removeClass('active');
	$('.category-filter__box p').removeClass('select-button');
	if ($('.category-data').length > 0) {
		$('.category-data').css({'border': '0', 'height': 0});
		$('.category-data__wrap button').remove();
	}
	if ($('.category-type').length > 0) {
		$('.category-type__item > a').removeClass('active');
		$('.category-type__item > a i').attr('class', 'ico__arrow--down14');
	}
	if ($('[class*="modal-category"]').length > 0) {
		$('[class*="modal-category"]').find('input').prop('checked', false);
	}
	$('.category-filter__refresh').removeClass('active')
})

//category-menu
$('.category-menu__title').on('click', function() {
	$('.category-menu').toggleClass('category-menu--active');
})

$('.category-menu__item').hover(function() {
	$('.category-menu__sub').removeClass('active');
	$(this).find('.category-menu__sub').addClass('active');
	if(!$(this).find('.category-menu__sub').hasClass('active')) {
		$('.category-menu__wrap').css('width', '250px');
	}else {
		$('.category-menu__wrap').css('width', '500px');
	}
})

$('.category-menu__sub-item').on('click', function() {
	if($(this).text().trim(' ') === '전체') {
		$('.category-menu__title a').html( $(this).closest('.category-menu__sub').prev().text());
	}else {
		$('.category-menu__title a').html( $(this).closest('.category-menu__sub').prev().text() + '>'+ $(this).text());
	}

	if($(this).text().trim(' ') === '일반소파') {
		$('.category-menu').removeClass('category-menu--active').addClass('select-menu');
		$('.category-filter').css('display', 'block').addClass('category-filter--active');
		$('.category-refresh').css('display', 'block');

		$('.category-refresh .category-filter__refresh').on('click', function () {
			$('.category-menu__title a').html('카테고리');
			$('.category-menu__item--active i').attr("class", $('.category-menu__item--active i').attr("class").split('--')[0])

			$('.category-refresh').css('display', 'none');
			$('.category-filter').css('display', 'none');
			$('.category-menu__item').removeClass('category-menu__item--active');
		});
	}

	$('.category-menu').removeClass('category-menu--active');

	$.each($('.category-menu__item i'),function (index, item) {
		item.classList = item.classList[0].split('--on')[0];
	})
	$('.category-menu__item').removeClass('category-menu__item--active');
	$(this).closest('.category-menu__sub').parent().addClass('category-menu__item--active');
	$(this).closest('.category-menu__sub').prev().find('i').attr('class', $(this).closest('.category-menu__sub').prev().find('i').attr("class") + '--on');
});

$('.buttons-refresh').on('click' ,function() {
	$('.category-type__item > a').removeClass('active');
	$('.category-type__item > a i').attr('class', 'ico__arrow--down14');
	$(this).closest('.modal').find('input').prop('checked', false);
})

$('.buttons-search').on('click', function () {
	$('.category-data__wrap').html('');
	$('.category-data').css('border', '1px solid #E0E0E0');

	for ( var i = 0; i < $(".modal-category input").length; i++) {
		if ($(".modal-category input:checkbox")[i].checked === true ) {
			$('.category-type__item-1').addClass('active');
			$('.category-type__item-1 i').attr('class', 'ico__arrow--down14-red')
			$('.category-data__wrap').append(`<button type='button'><span>` + $('#' + $(".modal-category input:checkbox")[i].id).next('span').text() +`</span></button>`)
		}
	}

	for ( var i = 0; i < $(".modal-category-2 input").length; i++) {
		if ($(".modal-category-2 input:checkbox")[i].checked === true ) {
			$('.category-type__item-2').addClass('active');
			$('.category-type__item-2 i').attr('class', 'ico__arrow--down14-red')
			$('.category-data__wrap').append(`<button type='button'><span>` + $('#' + $(".modal-category-2 input:checkbox")[i].id).next('span').text() +`</span></button>`)
		}
	}

	if ($('.category-data__wrap button').length > 0) {
		$('.category-data').css({'border': '1px solid #E0E0E0', 'height': 'auto'});
		$('.category-filter__refresh').addClass('active');
	} else {
		$('.category-data').css({'border': 0, 'height': 0});
		$('.category-filter__refresh').removeClass('active');
	}
})

$('.modal-category .buttons-refresh').on('click' ,function() {
	$('.category-type__item-1 .category__count').text(' ');
	firstCount = 0;
})

$('.modal-category-2 .buttons-refresh').on('click' ,function() {
	$('.category-type__item-2 .category__count').text(' ');
	secondCount = 0;
})

$('.modal-category .buttons-search').on('click', function () {
	firstCount = 0;

	for ( var i = 0; i < $(".modal-category input").length; i++) {
		if ($(".modal-category input:checkbox")[i].checked === true ) {
			firstCount = firstCount+1;
			$('.category-type__item-1 .category__count').text(firstCount);
		}
	}
})

$('.modal-category-2 .buttons-search').on('click', function () {
	secondCount = 0;

	for ( var i = 0; i < $(".modal-category-2 input").length; i++) {
		if ($(".modal-category-2 input:checkbox")[i].checked === true ) {
			secondCount = secondCount+1;
			$('.category-type__item-2 .category__count').text(secondCount);
		}
	}
})

$(".category-btn.registration-order-btn").on("click", function () {
	var btnText = $(this).children(".category-btn__text");

	if ( btnText.text() == "최근 등록순") {
		btnText.text("등록순");
	} else {
		btnText.text("최근 등록순");
	}
});

$(".order-info__title").on("click", function () {
  $(this).toggleClass("active");
});

$(".password__button").on("click", function () {
  $(".password__container").slideDown("");
});
$(".password__cancel").on("click", function () {
  $(".password__container").slideUp("");
});

//cate click
$('.sub-category .sub-category__item').on("click", function() {
	$('.sub-category .sub-category__item').removeClass("sub-category__item--active");
	$(this).addClass("sub-category__item--active");
});

let cateW = 0;
let cateOverflowItemsArr = [];
const cate = document.querySelector('.sub-category');
const cateItems = document.querySelectorAll('.sub-category .sub-category__item');
let itemLength = cateItems.length;

const CateClickToScroll = () => {
	let target;
	let oL;
	cateItems.forEach(i => {
		cateW = cateW + i.clientWidth + 24;
		if (cateW > 916) {
			i.addEventListener('click', (e) => {
				target = e.target;
				oL = target.offsetLeft;
				cate.scrollLeft = oL/2;
			})
		} else {
			i.addEventListener('click', (e) => {
				target = e.target;
				oL = target.offsetLeft;
				cate.scrollLeft = - oL/2;
			})
		}
	})
}
CateClickToScroll();
