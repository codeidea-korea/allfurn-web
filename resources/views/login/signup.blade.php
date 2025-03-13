@extends('layouts.app')

@section('content')
<div class="join_header sticky top-0 h-16 bg-white flex items-center">
    <div class="inner">
        <a class="inline-flex" href="/"><img class="logo" src="./img/logo.svg" alt=""></a>
    </div>
</div>

	<div id="content">
		<div id="content">
		<section class="join_comp flex items-center justify-center">
			<div class="text-center">
				<img class="logo mx-auto" src="./img/logo.svg" alt="">
				<h5 class="my-4 text-primary fs12">올펀 회원가입 완료안내</h5>

				<div class="my-20 py-4 bg-primary text-white rounded">“김고객”님의 올펀 회원가입이<br/>정상적으로 접수 되었습니다.</div>
				<div>올펀 운영자 승인 후 서비스를 이용 가능 합니다.</div>
			</div>
		</section>
	</div>

</div>

<script>
let inN = '0';
let base = '';
// 탭변경
$('.join_type button').on('click', function() {
    $('.form_bottom').removeClass('hidden')
    inN = $(this).data('num')
    $('.join_type button').removeClass('on')
    $(this).addClass('on');
    $('.form_tab_content > .form_box').eq(inN).removeClass('hidden').siblings().addClass('hidden')

    $('#frm')[0].reset();
    $('#register_form-submit').attr('disabled', true);
    if (inN === 0) { $('#add_1_1').prop('checked', true);  } else { $('#add_1_3').prop('checked', true); }

    if (inN === 0) {
        base  = '#wholesale-tab-pane';
    } else if (inN === 1) {
        base  = '#retail-tab-pane';
    } else if (inN === 2) {
        base  = '#furn-sectors-tab-pane';
    } else if (inN === 3) {
        base  = '#normal-tab-pane';
    }
})

// 이미지 변경
const fileUpload = (input) => {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        let img = input.parentNode.querySelector('img');
        if(!img){
            img = document.createElement('img')
        }
        input.nextElementSibling.classList.add('hidden')
        reader.onload = function(e) {
            img.src = e.target.result
            input.parentNode.append(img)
        };
        reader.readAsDataURL(input.files[0]);
    }
}

// 주소 탭 변경
const addressChange = (e) => {
let liN = $(e).parent().index()
	if(liN != 0) { $(e).parent().parent().parent().find('div:nth-child(3) > input').removeAttr('disabled'); } else { $(e).parent().parent().parent().find('div:nth-child(3) > input').attr('disabled', 'disabled'); }
    $(e).parent().parent().next('.add_tab').find('> div').eq(liN).removeClass('hidden').siblings().addClass('hidden')
}
</script>

<script defer src="https://ssl.daumcdn.net/dmaps/map_js_init/postcode.v2.js?autoload=false"></script>
<script defer src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.0/jquery.validate.min.js" ></script>
    <script defer src="/js/validate/messages_ko.min.js" ></script>

<script>
var isProc = false; // 중복등록 방지용
var phoneAuthTime = 300; // 최초 설정 시간(기본 : 초)
var emailAuthTime = 300;
var email_dup_check = false;
var business_code_dup_check = false;

$(document).ready(function() {
    // 이미지 업로드 관련
    $('[type="file"]').on("change", handleImgFileSelect);
    
    // 사업자등록번호 입력시 중복체크 버튼 활성화
    $('.input-guid__input#w_businesscode, .input-guid__input#r_businesscode').keyup(function () {
        let business_code = $(this).val();
        if (business_code !== "") {
            $(this).parent().parent().find('button').removeAttr("disabled");
        } else {
            $(this).parent().parent().find('button').prop("disabled", true);
        }
    });

    // 아이디 입력시 중복체크 버튼 활성화
    $('.input-guid__input#w_useremail, .input-guid__input#r_useremail, .input-guid__input#s_useremail, .input-guid__input#n_useremail').keyup(function () {
        let email = $(this).val();
        if (email !== "") {
            $(this).parent().parent().find('button').removeAttr("disabled");
        } else {
            $(this).parent().parent().find('button').prop("disabled", true);
        }
    });

    // 가입완료 버튼 활성화
    $('input, .checkbox__input--necessary').change(function () {
        var errors = 0;
        $(base + ' .input-guid__input').map(function() {
            if( $(this).val().length === 0 ) {
                if ( $(this).attr('name') === 'businessaddress' && $(base + ' [name="add_1"]:checked').val() === '2' ) {
                } else {
                    errors++;    
                } 
            }
        });
        if (!$('#register-agreement_1').is(':checked') || !$('#register-agreement_2').is(':checked')) { errors++; }
        if (!email_dup_check) { errors++; }
        if (errors == 0) {
            $('#register_form-submit').removeAttr('disabled');
        } else {
            $('#register_form-submit').prop('disabled', true);
        }
    });

    // validation
    $('#frm').validate({
        rules: {
            businesscode: {required:true, minlength:12, businessCodeDupCheck: true},
            certificate: {required:true},
            businessname: {required:true},
            username: {required:true},
            contact: {required:true},
            businessaddressdetail: {required:true},
            useremail: {required:true, emailDupCheck: true},
            userpw: {required:true, eng_number:true, minlength:8},
            w_userpwcheck: {required:true, minlength:8, equalTo:"#w_userpw"},
            r_userpwcheck: {required:true, minlength:8, equalTo:"#r_userpw"},
            s_userpwcheck: {required:true, minlength:8, equalTo:"#s_userpw"},
            n_userpwcheck: {required:true, minlength:8, equalTo:"#n_userpw"},
            userpwcheck: {required:true, minlength:8, equalTo:base +" #userpw"},
        },
        messages: {
            businesscode: {
                required: "사업자번호를 정확히 입력해주세요",
                minlength: "사업자번호를 정확히 입력해주세요",
                businessCodeDupCheck: "사업자번호 중복체크를 해주세요"
            },
            certificate: "사업자등록증을 확인해주세요",
            businessname: "업체명을 정확히 입력해주세요",
            username: "대표장명을 정확히 입력해주세요",
            contact: "휴대폰 번호를 정확히 입력해주세요",
            businessaddressdetail: "주소를 입력해주세요",
            useremail: {
                required: "아이디를 입력해주세요",
                emailDupCheck: "중복체크를 해주세요.",
            },
            useremail_confirm_w: {
                required: "이메일을 입력해주세요",
                email: "이메일을 정확히 입력해주세요",
                equalTo: "이메일과 일치하지 않습니다",
            },
            useremail_confirm_r: {
                required: "이메일을 입력해주세요",
                email: "이메일을 정확히 입력해주세요",
                equalTo: "이메일과 일치하지 않습니다",
            },
            useremail_confirm_n: {
                required: "이메일을 입력해주세요",
                email: "이메일을 정확히 입력해주세요",
                equalTo: "이메일과 일치하지 않습니다",
            },
            userpw: {
                required: "비밀번호는 입력해주세요",
                eng_number: "비밀번호는 영문 및 숫자 혼합하여 8자리 이상 입력해주세요",
                minlength: "비밀번호는 영문 및 숫자 혼합하여 8자리 이상 입력해주세요",
            },
            userpwcheck: {
                required: "비밀번호확인을 입력해주세요",
                minlength: "비밀번호와 일치하지 않습니다",
                equalTo: "비밀번호와 일치하지 않습니다",
            },
            w_userpwcheck: {
                required: "비밀번호확인을 입력해주세요",
                minlength: "비밀번호와 일치하지 않습니다",
                equalTo: "비밀번호와 일치하지 않습니다",
            },
            r_userpwcheck: {
                required: "비밀번호확인을 입력해주세요",
                minlength: "비밀번호와 일치하지 않습니다",
                equalTo: "비밀번호와 일치하지 않습니다",
            },
            s_userpwcheck: {
                required: "비밀번호확인을 입력해주세요",
                minlength: "비밀번호와 일치하지 않습니다",
                equalTo: "비밀번호와 일치하지 않습니다",
            },
            n_userpwcheck: {
                required: "비밀번호확인을 입력해주세요",
                minlength: "비밀번호와 일치하지 않습니다",
                equalTo: "비밀번호와 일치하지 않습니다",
            }
        }
    });
    

    $.validator.addMethod('eng_number', function( value ) {
        return /[a-z]/.test(value) && /[0-9]/.test(value)
    });


    $.validator.addMethod('emailDupCheck', function(value) {
        return email_dup_check;
    });

    $.validator.addMethod('businessCodeDupCheck', function(value) {
        return business_code_dup_check;
    })
});


// 우편번호/주소 검색
function execPostCode(t) {
    daum.postcode.load(function() {
        new daum.Postcode({
            oncomplete: function(data) {
                var addr = '';

                if (data.userSelectedType === 'R') {
                    addr = data.roadAddress;
                } else {
                    addr = data.jibunAddress;
                }
                $(`#${t}_businessaddress`).val(addr);
                $(`#${t}_businessaddressdetail`).removeAttr('disabled');
                $(`#${t}_businessaddressdetail`).focus();
            }
        }).open();
    });
}

function step1Next(){
    if(inN < 0) {
        modalOpen('#step1-modal');
    } else {
        $('.form_tab_content > .form_box').eq(inN).removeClass('hidden').siblings().addClass('hidden')

        $('#frm2')[0].reset();
        $('#frm3')[0].reset();
        $('#register_form-submit').attr('disabled', true);
        if (inN === 0) { $('#add_1_1').prop('checked', true);  } else { $('#add_1_3').prop('checked', true); }

        $('.nextBtn').removeClass('hidden')
    }
}
// 사용중 이메일, 사업자번호 체크
function checkBeforeAuthCode(type, t) {
    if ( type === 'business_regist_number' ) {
        if($(`#${t}_businesscode`).val().replaceAll('-','').length != 10){
            $(`#${t}_businesscode`).parent().find('label').text('잘못된 사업자 등록번호입니다.');
            $('#email_dupcheck_ment').html('잘못된 사업자 등록번호입니다.');
            modalOpen('#modal-email--duplicated');
            return;
        }
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: '/member/checkUsingBusinessNumber',
            data: {
                'business_number': $(`#${t}_businesscode`).val().replaceAll('-','')
            },
            type: 'POST',
            dataType: 'json',
            success: function(result) {
                if (result == 0) {
                    $(`#${t}_businesscode`).parent().find('label').text('사용가능한 사업자번호 입니다.');
                    $('#email_dupcheck_ment').html('사용가능한 사업자번호 입니다.');
                    $(`#${t}_businesscode`).removeClass('error');
                    $(`#${t}_businesscode`).parent().find('label').hide();
                    business_code_dup_check = true;
                } else {
                    $(`#${t}_businesscode`).parent().find('label').text('중복된 사업자 등록번호입니다.');
                    $('#email_dupcheck_ment').html('중복된 사업자 등록번호입니다.');
                }
                modalOpen('#modal-email--duplicated');
            }
        });
    } else {
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: '/member/checkUsingEmail',
            data: {
                'email': $(`#${t}_useremail`).val()
            },
            type: 'POST',
            dataType: 'json',
            success: function(result) {
                if (result == 0) {
                    $('#email_dupcheck_ment').html('사용가능한 아이디입니다.');
                    $(`#${t}_useremail`).removeClass('error');
                    $(`#${t}_useremail`).parent().find('label').hide();
                    email_dup_check = true;
                } else {
                    $('#email_dupcheck_ment').html('이미 사용중인 아이디입니다. 다시 확인해주세요.');
                }
                modalOpen('#modal-email--duplicated');
            }
        });
    }
}

function email_check( email ) {    
    var regex=/([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
    return (email != '' && email != 'undefined' && regex.test(email)); 
}

$("input[type=email]").blur(function(){
  var email = $(this).val();
  if( email == '' || email == 'undefined') return;
  if(! email_check(email) ) {
  	$(this).val('');
    $(this).focus();
    return false;
  }
});
// 가입완료 처리
function submitAction() {
    if (isProc) {
        return;
    }
    isProc = true;

    // let userType = $('.tab-content__panel[aria-hidden="false"]').data('usertype');
    let userType = '';
    if ( base === '#wholesale-tab-pane' ) userType = 'W';
    else if ( base === '#retail-tab-pane' ) userType = 'R';
    else if ( base === '#furn-sectors-tab-pane' ) userType = 'S';
    else if ( base === '#normal-tab-pane' ) userType = 'N';

    let suffix = '';
    if ( userType === 'W' ) suffix = 'w'
    else if ( userType === 'R' ) suffix = 'r';
    else if ( userType === 'S' ) suffix = 's';
    else if ( userType === 'N' ) suffix = 'n';

    var form = new FormData();
    form.append("userType", userType);
    form.append('name', $(`#${suffix}_username`).val());
    form.append("file", $(base + ' [type="file"]')[0].files[0]);
    form.append('phone', $(`#${suffix}_contact`).val().replace(/-/g, ''));
    form.append('phone_country_number', $(`#${suffix}_phone_country_number`).val());
    form.append('email', $(`#${suffix}_useremail`).val());
    form.append('password', $(`#${suffix}_userpw`).val());
    form.append('agreementServicePolicy', $('#register-agreement_1').is(':checked') ? 1 : 0);
    form.append('agreementPrivacy', $('#register-agreement_2').is(':checked') ? 1 : 0);
    form.append('agreementMarketing', $('#register-agreement_3').is(':checked') ? 1 : 0);
    form.append('agreementAd', $('#register-agreement_4').is(':checked') ? 1 : 0);
    if ( userType === 'W' || userType === 'R' ) {
        form.append('businessLicenseNumber', $(`#${suffix}_businesscode`).val().replace(/-/g, ''));
    }
    form.append('companyName', $(`#${suffix}_businessname`).val());
    if (userType != "N" && userType != "S") {
        form.append('isDomestic', $(base + ' [name="add_1"]:checked').val() == 1 ? 2 : 1);
        if ($(base + ' [name="add_1"]:checked').val() === 1) {
            form.append('domesticType', $(base + ' .dropdown__title').data('domestic_type'));
            form.append('address', $(base + ' .dropdown__title').text());
        } else {
            form.append('address', $(base + ' [name="businessaddress"]').val());
        }
        form.append('addressDetail', $(base + ' [name="businessaddressdetail"]').val());
    }

    $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: '/member/createUser',
        enctype: 'multipart/form-data',
        processData: false,
        contentType: false,
        data: form,
        type: 'POST',
        success: function(result) {
            if (result.success) {
                location.replace('/signup/success');
                isProc = false;
                
            } else {
                switch (result.code) {
                    case 1001:
                        openModal('#modal-email--duplicated');
                        isProc = false;
                        break;
                    default:
                        alert(result.message);
                        isProc = false;
                        break;
                }
            }
        }
    });
}

// 이미지 컨트롤
function handleImgFileSelect(e) {
    var files = e.target.files;
    var filesArr = Array.prototype.slice.call(files);
    var reg = /(.*?)\/(jpg|jpeg|png|bmp)$/;
    var attr_id = $(this).attr('id');
    filesArr.forEach(function (f) {
        if (!f.type.match(reg)) {
            alert("확장자는 이미지 확장자만 가능합니다.");
            return;
        }
        sel_file = f;
        var reader = new FileReader();
        reader.onload = function (e) {
            if ( attr_id === 'w_certificate' ) {
                $('#w_img').attr('src', e.target.result);
                $('#w_img').css({'width':'inherit','height':'inherit'});
                $('#w_file-input').hide();
            } else if ( attr_id === 'r_certificate' ) {
                $('#r_img').attr('src', e.target.result);
                $('#r_img').css({'width':'inherit','height':'inherit'});
                $('#r_file-input').hide();
            } else if ( attr_id === 's_certificate' ) {
                $('#s_img').attr('src', e.target.result);
                $('#s_img').css({'width':'inherit','height':'inherit'});
                $('#s_file-input').hide();
            } else if ( attr_id === 'n_certificate' ) {
                $('#n_img').attr('src', e.target.result);
                $('#n_img').css({'width':'inherit','height':'inherit'});
                $('#n_file-input').hide();
            }
        }
        reader.readAsDataURL(f);
    });
}
</script>

<div class="modal" id="modal-email--duplicated">
    <div class="modal_bg" onclick="modalClose('#modal-email--duplicated')"></div>
    <div class="modal_inner modal-sm">
        <button type="button" class="close_btn" onclick="modalClose('#modal-email--duplicated')"><svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#Close"></use></svg></button>
        <div class="modal_body agree_modal_body">
            <p class="text-center py-4"><b id='email_dupcheck_ment'>이미 사용중인 이메일 입니다.<br>다시 확인해주세요.</b></p>
            <div class="flex gap-2 justify-center">
                <button type="button" class="btn btn-primary w-1/2 mt-5" onclick="modalClose('#modal-email--duplicated');">확인</button>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="smscode_time_over">
    <div class="modal_bg" onclick="modalClose('#smscode_time_over')"></div>
    <div class="modal_inner modal-sm">
        <button class="close_btn" onclick="modalClose('#smscode_time_over')" type="button"><svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#Close"></use></svg></button>
        <div class="modal_body agree_modal_body">
            <p class="text-center py-4"><b>유효시간이 만료되었습니다.<br>인증코드를 재발송해주세요.</b></p>
            <div class="flex gap-2 justify-center">
                <button class="btn btn-primary w-1/2 mt-5" onclick="modalClose('#smscode_time_over')" type="button">확인</button>
            </div>
        </div>
    </div>
</div>


@endsection




