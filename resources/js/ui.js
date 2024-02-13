
/*!
 * c2-event-handler
 * https://github.com/TheC2Group/event-handler
 * @version 2.5.2 (c) The C2 Group (c2experience.com)
 * @license MIT
 */
var eventHandler=function(){"use strict";var t=function(e,n){var i=this;"string"==typeof e&&e.length&&void 0!==n&&(e.indexOf(" ")>-1?e.split(" ").forEach(function(e){t.call(i,e,n)}):(this._events=this._events||{},this._events[e]=this._events[e]||[],this._events[e].push(n)))},e=function(t,n){var i=this;if("string"==typeof t&&t.length)if(t.indexOf(" ")>-1)t.split(" ").forEach(function(t){e.call(i,t,n)});else if(this._events=this._events||{},t in this._events!=!1)if(void 0!==n){var s=this._events[t].indexOf(n);s>-1&&(1===this._events[t].length?delete this._events[t]:this._events[t].splice(s,1))}else delete this._events[t]},n=function(t){for(var e=this,i=arguments.length,s=Array(i>1?i-1:0),o=1;o<i;o++)s[o-1]=arguments[o];var f=t.lastIndexOf(":");f>-1&&n.call.apply(n,[this,t.substring(0,f)].concat(s)),this._events=this._events||{},t in this._events!=!1&&this._events[t].forEach(function(t){t.apply(e,s)})},i=function(){},s=i.prototype;s.on=t,s.off=e,s.emit=n,s.bind=t,s.unbind=e,s.trigger=n;var o=function(s){return 0===arguments.length?new i:("function"==typeof s&&(s.prototype.on=t,s.prototype.off=e,s.prototype.emit=n),"object"==typeof s&&(s.on=t,s.off=e,s.emit=n),s)};return o.EventConstructor=i,o}();

/*!
* c2-tabs
* https://github.com/TheC2Group/tabs
* @version 2.2.2
* @license MIT (c) The C2 Group (c2experience.com)
*/
var Tabs=function(t,i){"use strict";var a=0,e={tablist:".tab .tab__list",tab:".tab__item",panel:".tab-content .tab-content__panel",prefix:"tab-",hashEnabled:!1,direction:"horizontal"},n=37,l=39,s=38,r=40,o=function(){var t=this.index-1;t<0&&(t=this.len-1),c.call(this,t)},h=function(){var t=this.index+1;t>=this.len&&(t=0),c.call(this,t)},d=function(t,i){return t.which===n&&"horizontal"===this.opts.direction?(t.preventDefault(),void o.call(this,i)):t.which===l&&"horizontal"===this.opts.direction?(t.preventDefault(),void h.call(this,i)):t.which===s&&"vertical"===this.opts.direction?(t.preventDefault(),void o.call(this,i)):t.which===r&&"vertical"===this.opts.direction?(t.preventDefault(),void h.call(this,i)):void 0},c=function(t){if(t!==this.index){var i=this.index;this.index=t,this.$tabs.eq(i).attr({"aria-selected":!1,tabindex:-1}),this.$panels.eq(i).attr({"aria-hidden":!0,tabindex:-1}),this.$tabs.eq(t).attr({"aria-selected":!0,tabindex:0})[0].focus(),this.$panels.eq(t).attr({"aria-hidden":!1,tabindex:0}),this.emit("update",t)}},b=function(){if(document.location.hash){var t=document.location.hash.split("#")[1],i=this.$tabs.filter('[data-hash="'+t+'"]');i.length>0&&c.call(this,i.index())}},p=function(i,n){a+=1,this.count=a,this.opts=t.extend({},e,n),this.$el=t(i),this.$tablist=this.$el.find(this.opts.tab__list),this.$tabs=this.$el.find(this.opts.tab),this.$panels=this.$el.find(this.opts.panel),this._enabled=!0,this.len=this.$tabs.length,this.index=0,function(){var i=this;this.$tablist.attr("role")||this.$tablist.attr("role","tablist"),this.$tabs.each(function(a,e){var n=t(e).attr("id");t(e).attr({role:"tab",tabindex:a===i.index?0:-1,"aria-selected":a===i.index}),n?t(e).attr("data-original-id",!0):t(e).attr({id:i.opts.prefix+i.count+"-"+(a+1)})}),this.$panels.each(function(a,e){var n=t(e).attr("aria-labelledby");t(e).attr({role:"tabpanel",tabindex:a===i.index?0:-1,"aria-hidden":a!==i.index}),n?t(e).attr("data-original-labelledBy",!0):t(e).attr({"aria-labelledby":i.opts.prefix+i.count+"-"+(a+1)})})}.call(this),function(){var i=this;i.$tabs.on("click",function(t){c.call(i,i.$tabs.index(t.currentTarget))}),i.$tabs.on("keydown",function(t){d.call(i,t)}),i.$panels.on("keydown",function(t){t.ctrlKey&&d.call(i,t)}),t(window).on("hashchange",function(){i.opts.hashEnabled&&i._enabled&&b.call(i)})}.call(this),this.opts.hashEnabled&&b.call(this)};return i(p),p.prototype.activate=c,p.prototype.activateNext=h,p.prototype.activatePrevious=o,p.prototype.destroy=function(){(function(){this.$tablist.removeAttr("role"),this.$tabs.each(function(i,a){t(a).attr("id"),t(a).attr("data-original-id")||t(a).removeAttr("id"),t(a).removeAttr("role tabindex aria-selected data-original-id")}),this.$panels.each(function(i,a){t(a).attr("aria-labelledby"),t(a).attr("data-original-labelledBy")||t(a).removeAttr("aria-labelledby"),t(a).removeAttr("role tabindex aria-hidden data-original-labelledBy")})}).call(this),function(){this.$tabs.off("click keydown"),this.$panels.off("keydown"),this._enabled=!1}.call(this)},p}(jQuery,eventHandler);

function openModal(name) {
	$(`${name}`).css('display', 'block');
	$('body').css('overflow', 'hidden');
}

function closeModal(name) {
    if (name === '*') {
        const openModals = document.querySelectorAll('.modal');
        openModals.forEach(modal => {
            closeModal('#' + modal.id);
        })
    } else {
        $(`${name}`).css('display', 'none');
        $('body').css('overflow', '')
    }
}

//검색창
$(".textfield__search").on("propertychange change keyup paste input", function() {
	var currentVal = $(this).val();

	if(!(currentVal === '')) {
		$(this).parent().addClass('textfield--active');
	}else {
		$(this).parent().removeClass('textfield--active');
	}
});

$(".textfield__icon--delete").on('click' , function() {
    $(this).prev().val('');
    $(".textfield").removeClass('textfield--active');
})


$(".card__bookmark").on("click", function () {
  let bookMarkImg = $(this).children("i");
  let bookMarkspan = bookMarkImg.children("span");

  $(this).toggleClass("card__bookmark--active");

  if ($(this).hasClass("card__bookmark--active")) {
    bookMarkImg.attr("class", "ico__bookmark24--on");
    bookMarkspan.text("스크랩 on");
  } else {
    bookMarkImg.attr("class", "ico__bookmark24--off");
    bookMarkspan.text("스크랩 off");
  }
});

// tab control
var actvTabList = function(tabid, actNum){
	var basicTabs = new Tabs('#' + tabid);
	if(!actNum) actNum = 0;

	basicTabs.activate(actNum);
}
$('.tab').each(function(){
	var tabIdx = $(this).attr('id');

	if(!$(this).hasClass('tab-func')){
		var basicTabs = new Tabs('#' + tabIdx);
	}
});

// dropdown control
$(document).on('click', '.dropdown', function (evnet) {
  if(!$(this).hasClass('dropdown--disabled')) $(this).toggleClass('dropdown--active');

	var dropDownItem = $(this)
	  .children(".dropdown__wrap")
	  .children(".dropdown__item");
	var dropDownTitle = $(this).children(".dropdown__title");

	dropDownItem.on("click", function (evnet) {
	  dropDownTitle.text($(this).text().trim(" ").split("\n")[0]);
	});
});

//heart action
$('.category-product__heart').on('click', function (event) {
	event.preventDefault();
	if($('.category-product__heart').hasClass('active')) {
		$(this).find('i').attr('class', 'ico__unheart');
		$(this).removeClass('active');
		$(this).find('span').css('color', '#828282');

	}else {
		$(this).find('i').attr('class', 'ico__heart');
		$(this).addClass('active');
		$(this).find('span').css('color', '#FB4760');
	}
});

$('.ico__more').on('click', function (event) {
    event.stopPropagation();
	event.preventDefault();
	if($(this).hasClass('ico__more--black')){
		$(this).removeClass('ico__more--black');
		$(this).next().css('display', 'none');
	}else {
		$(this).addClass('ico__more--black');
		$(this).next().css('display', 'block');
	}
});

const changeStatus = (orderNum, status, type) => {
    let params = {orderNum, status, type};
    if (status === 'C') {
        params['cancelReason'] = document.getElementById('cancelReason').value;
    }
    fetch('/mypage/order/status', {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(params)
    }).then(result => {
        return result.json()
    }).then(json => {
        if (json.result === 'success') {
            switch(status) {
                case 'R':
                    openModal('#modal-deal');
                    break;
                case 'D':
                    openModal('#modal-send-start');
                    break;
                case 'W':
                    openModal('#modal-send-complete');
                    break;
                case 'C':
                    closeModal('#modal-request-cancel');
                    openModal('#modal-cancel');
                    break;
                case 'F':
                    location.replace(location.href);
                    break;
            }
        } else {
            closeModal('*');
            if (json.code === 'ALREADY_R_CANCEL') {
                openModal('#modal-deal-error');
            } else {
                alert(json.message);
                location.replace(document.referrer);
            }

        }
    });
}
