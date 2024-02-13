const toggleUsermenu = document.querySelector(".usermenu-toggle");
const usermenu = document.querySelector(".content__usermenu");
let toggleChecked;
let menuStatus;

const toggleNavi = document.querySelector(".navi-toggle");
const navi = document.querySelector(".content__navi");
let buttonChecked;
let naviStatus;


$("window").on("load", () => {

  if (toggleUsermenu === null) return; else {toggleChecked = toggleUsermenu.getAttribute('aria-checked');}
  if (usermenu === null) return; else {menuStatus = usermenu.getAttribute('aria-hidden');}

  if (toggleNavi === null) return; else {buttonChecked = toggleNavi.getAttribute('aria-checked');}
  if (navi === null) return; else {naviStatus = navi.getAttribute('aria-hidden');}
})

$(document).on('click', '.list-insearch-toggle', function() {
    let checked = $(this).attr('aria-checked');
    if (checked === 'true') {
        $(this).attr('aria-checked', false);
        $('.list-insearch').attr('aria-hidden', true);
        $('.list-insearch-history').attr('aria-hidden', true);
    } else {
        $(this).attr('aria-checked', true);
        $('.list-insearch').attr('aria-hidden', false);
        $('.list-insearch-history').attr('aria-hidden', false);
    }
})

$(document).on('click', '.list-insearch-close', function() {
    location.replace('/message');
})

$(document).on('click', '.navi-toggle', function() {
    let checked = $(this).attr('aria-checked');
    if (checked === 'true') {
        $(this).attr('aria-checked', false);
        $('.content__navi').attr('aria-hidden', true);
    } else {
        $(this).attr('aria-checked', true);
        $('.content__navi').attr('aria-hidden', false);
    }
})

$(document).on('click', '.dialogue-insearch-close, .dialogue-insearch-toggle', function() {
    let checked = $('.dialogue-insearch-toggle').attr('aria-checked');
    if (checked === 'true') {
        $('.dialogue-insearch-toggle').attr('aria-checked', false);
        $('.dialogue-insearch').attr('aria-hidden', true);
    } else {
        $('.dialogue-insearch-toggle').attr('aria-checked', true);
        $('.dialogue-insearch').attr('aria-hidden', false);
    }
})

$(document).on('click', '.usermenu-toggle', function() {
     let checked = $(this).attr('aria-checked');
     if (checked === 'true') {
         $(this).attr('aria-checked', false);
         $('.content__usermenu').attr('aria-hidden', true);
     } else {
         $(this).attr('aria-checked', true);
         $('.content__usermenu').attr('aria-hidden', false);
     }
});

const DialogueHeight = () => {
  const dialogue = document.querySelector('#dialogue');
  const quotation = document.querySelector('.product-quotation');

  if (quotation === null) {return;} else {
    let targeH = quotation.clientHeight;
    dialogue.style.height = `calc(100% - 73px - ${targeH}px)`;
  }
}
DialogueHeight();

function DeleteBottomTarget() {
  document.querySelector(".product-quotation").style.display = 'none';
  DialogueHeight();
}

function ResetInput() {
  document.getElementById("chatbox").placeholder = '';
}


$("#chatbox").on("propertychange change keyup keydown paste input", function() {
	var currentVal = $(this).val();

	if(!(currentVal == '')) {
		$(this).parent().parent().find('.message-submit').attr('disabled', 'false');
	} else {
		$(this).parent().parent().find('.message-submit').attr('disabled', 'true');
	}
})

$('.aside-list__item').click( function() {
  $('.aside-list__item').removeClass('aside-list__item--active');
  $(this).addClass('aside-list__item--active');
})

//chatbox
$("#chatbox").on("propertychange change keyup paste input", function() {
	var currentVal = $(this).val();

	if(!(currentVal === '')) {
		$(this).parent().addClass('textfield--active');
	}else {
		$(this).parent().removeClass('textfield--active');
	}
});
