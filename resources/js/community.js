if($('.container').hasClass('community')) {

  $(document).click(function(e) {
      
    if ( $(e.target).hasClass('textfield__search') ) {
        
        
        
      if ( $('.search-list').hasClass('active') ) {
          
          $('.search-list').removeClass('active');
          $('.post-list').css('display','block');
          
      } else {
          
          $('.search-list').addClass('active');
          $('.post-list').css('display','none');
          
      }
      
    }
    if (!$(e.target).hasClass('ico__more')) {
        $('.community-reply__box:visible').hide();
    }
  });

  $('.community-comment__text').on('click', function (event) {
    event.preventDefault();
    $(this).closest('.community-comment__box').next('.community-comment__recomment').css('display', 'block');

  })

  $('.recomment__cancle').on('click', function () {
    $(this).closest('.community-comment__recomment').css('display', 'none');
  })

  $('#modal-declaration textarea').on("propertychange change keyup paste input", function() {
    if( $('#modal-declaration textarea').val() != '') {
      $('#modal-declaration .footer button').addClass('active');
    }else {
      $('#modal-declaration .footer button').removeClass('active');
    }
  });

  $('#modal-declaration .footer button').on('click', function () {
    if($(this).hasClass('active')) {
      closeModal('#modal-declaration');
      openModal('#modal-declaration--done');
    }
  })
}


