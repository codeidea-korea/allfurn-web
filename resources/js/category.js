//filter
let filterItem = 'category-filter__item';

$('.category-filter__arrow').on('click', function  () {
	if($(this).closest('.' + filterItem).hasClass(filterItem +'--active')) {
		$('.' + filterItem).removeClass(filterItem +'--active');
	}else {
		$('.' + filterItem).removeClass(filterItem +'--active');
		$(this).closest('.' + filterItem).toggleClass(filterItem +'--active');
	}
})

$('.' + filterItem).find('button').on('click', function () {
	let select= 'select-button';
	
	$(this).closest('p').toggleClass(select);
	$('.category-filter__footer').addClass('active');

	if($('.category-filter__footer').hasClass('active') === true) {
		$('.category-filter__wrap').css('border-bottom-right-radius', '0');
		$('.category-filter__wrap').css('border-bottom-left-radius', '0');
	}
	
	if($(this).closest('p').hasClass(select)) {
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
	$('.category-filter__data button').remove();
	$('.category-filter__footer').removeClass('active');
	$('.category-filter__box p').removeClass('select-button');
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

	// if($(this).text().trim(' ') === '일반소파') {
	// 	$('.category-menu').removeClass('category-menu--active').addClass('select-menu');
	// 	$('.category-filter').css('display', 'block').addClass('category-filter--active');
	// 	$('.category-refresh').css('display', 'block');

	// 	$('.category-refresh .category-filter__refresh').on('click', function () {
	// 		$('.category-menu__title a').html('카테고리');
	// 		$('.category-menu__item--active i').attr("class", $('.category-menu__item--active i').attr("class").split('--')[0])
			
	// 		$('.category-refresh').css('display', 'none');
	// 		$('.category-filter').css('display', 'none');
	// 		$('.category-menu__item').removeClass('category-menu__item--active');
	// 	});
	// }

	$('.category-menu').removeClass('category-menu--active');

	$.each($('.category-menu__item i'),function (index, item) {
		item.classList = item.classList[0].split('--on')[0];
	})
	$('.category-menu__item').removeClass('category-menu__item--active');
	$(this).closest('.category-menu__sub').parent().addClass('category-menu__item--active');
	$(this).closest('.category-menu__sub').prev().find('i').attr('class', $(this).closest('.category-menu__sub').prev().find('i').attr("class") + '--on');
});

function refresh () {
	$('.modal-category input').prop('checked',false);
	$('.modal-category-2 input').prop('checked',false);
	$('.category-data').css('border', 'none');
	$('.category-type__item-1').removeClass('active');
	$('.category-type__item-2').removeClass('active');
	$('.category-data__wrap--first').html('');
	$('.category-data__wrap--second').html('');
	$('.category-type__item-1 i').attr('class', 'ico__arrow--down14');
	$('.category-type__item-2 i').attr('class', 'ico__arrow--down14');
	$('.category-type__item-1 .category__count').text(' ');
	$('.category-type__item-2 .category__count').text(' ');
	$('.category-filter__wrap').css('border-bottom-right-radius', '5px');
	$('.category-filter__wrap').css('border-bottom-left-radius', '5px');
}

$('.modal__buttons--refresh').on('click' ,function() {
	refresh();
})

$('.category-filter__refresh').on('click' ,function() {
	refresh();
	$('.category-data .category-filter__refresh').css('display', 'none');
})


$('.category-type__item-1').on('click', function () {
	$('.modal-category input').prop('checked',false);
})

$('.category-type__item-2').on('click', function () {
	$('.modal-category-2 input').prop('checked',false);
})

let firstCount = 0;
let secondCount = 0;

$('.modal-category .modal__buttons--search').on('click', function () {
	$('.category-data__wrap--first').html('');
	$('.category-data').css('border', '1px solid #E0E0E0');
	$('.category-data .category-filter__refresh').css('display', 'block');
	firstCount = 0;

	for ( var i = 0; i < $(".modal-category input").length; i++) {
		if ($(".modal-category input:checkbox")[i].checked === true ) {
			$('.category-type__item-1').addClass('active');
			$('.category-type__item-1 i').attr('class', 'ico__arrow--down14-red')
			$('.category-data__wrap--first').append(`<button type='button'><span>` + $('#' + $(".modal-category input:checkbox")[i].id).next('span').text() +`</span></button>`);
			firstCount = firstCount+1;
		}
		$('.category-type__item-1 .category__count').text(firstCount);
	}
})

$('.modal-category-2 .modal__buttons--search').on('click', function () {
	$('.category-data__wrap--second').html('');
	$('.category-data').css('border', '1px solid #E0E0E0');
	$('.category-data .category-filter__refresh').css('display', 'block');
	secondCount = 0;

	for ( var i = 0; i < $(".modal-category-2 input").length; i++) {
		if ($(".modal-category-2 input:checkbox")[i].checked === true ) {
			$('.category-type__item-2').addClass('active');
			$('.category-type__item-2 i').attr('class', 'ico__arrow--down14-red')
			$('.category-data__wrap--second').append(`<button type='button'><span>` + $('#' + $(".modal-category-2 input:checkbox")[i].id).next('span').text() +`</span></button>`);
			secondCount = secondCount+1;
			$('.category-type__item-2 .category__count').text(secondCount);
		}
	}
})