$( function() {
  $.datepicker.setDefaults({
    dateFormat: 'yy.mm.dd',
    prevText: '',
    nextText: '',
    monthNames: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
    monthNamesShort: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
    dayNames: ['일', '월', '화', '수', '목', '금', '토'],
    dayNamesShort: ['일', '월', '화', '수', '목', '금', '토'],
    dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
    showMonthAfterYear: true,
    yearSuffix: '년',
    endDate: '0d',
    autoclose: true,

    onSelect: function(selectedDate) {
      if(!$(this).data().datepicker.first){
          $(this).data().datepicker.inline = true
          $(this).data().datepicker.first = selectedDate;
      }else{
          if(selectedDate > $(this).data().datepicker.first){
              $(this).val($(this).data().datepicker.first+" - "+selectedDate);
              if (typeof submitFilter === 'function') {
                  submitFilter();
              }
          }else{
            $(this).val(selectedDate+" - "+$(this).data().datepicker.first);
              if (typeof submitFilter === 'function') {
                  submitFilter();
              }
          }
          $(this).data().datepicker.inline = false;
      }
        appendAllBtn();
    },

    onClose:function(){
      delete $(this).data().datepicker.first;
      $(this).data().datepicker.inline = false;
    },
    beforeShow: function() {
        appendAllBtn();
    },
    onChangeMonthYear: function() {
        appendAllBtn();
    }

  });

  function appendAllBtn() {
    setTimeout(function() {
        if (!document.getElementById('calendarAllBtn')) {
            const elem = document.createElement('div');
            elem.setAttribute("class", "calendar__all");

            const btn = document.createElement('button');
            btn.setAttribute("id", "calendarAllBtn");
            const newContent = document.createTextNode("전체");
            btn.append(newContent);
            elem.appendChild(btn);
            document.getElementById('ui-datepicker-div').prepend(elem);
        }
    }, 1);
  }


  $(function() {
    $('.my-page .calendar input').datepicker({
      showOn: "button",
      buttonImage: "/images/sub/ico_calander.png",
      buttonImageOnly: true,
      buttonText: "Select date"
    })

  });
});
