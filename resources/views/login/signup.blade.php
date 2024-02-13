@extends('layouts.master')

@section('header')
    @include('layouts.header.signup-header')
@stop


@section('content')

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

    <div id="container" class="container" style="margin-top:-45px;">
        
        <div class="member">
            
            <div class="inner__large">
                
                <div class="register">
                    
                    <h2 class="register__heading">회원가입</h2>
                    
                    <div class="notice-box">
                        <ul>
                            <li><div class="ico__info"><span class="a11y">정보 아이콘</span></div>회원 가입 후 관리자 승인 여부에 따라 서비스 이용이 가능합니다.</li>
                        </ul>
                    </div>
                    
                    <div class="content">
                        
                        <div class="content__item">
                            
                            <div class="content__title">회원 구분을 선택해주세요.</div>
                            
                            <div class="row" id="register-type">
                                
                                <div class="col-6">
                                    
                                    <div class="text-center tab_title border-bottom border-default-subtle pb-2">가구 사업자</div>
                                    
                                    <div class="row mt-4">

                                        <div class="col-6">
                                            
                                            <button class="btn btn-outline-danger  tab_btn  w-100" id="whole_sale">제조/도매</button>
                                            
                                            <p class="mt-3 p-2">상품 등록이 가능한 사업자 대표 계정입니다.</p>
                                            
                                        </div>
                                        
                                        <div class="col-6">
                                            
                                            <button class="btn btn-outline-danger tab_btn  w-100" id="retail">판매/매장</button>
                                            
                                            <p class="mt-3 p-2">상품 구매, 업체 연락이 가능한 사업자 대표 계정입니다.</p>
                                            
                                        </div>

                                    </div>
                                        
                                </div>
                                
                                <div class="col-6">
                                    
                                    <div class="text-center tab_title border-bottom border-default-subtle pb-2">사업자 외(직원)</div>
                                    
                                    <div class="row mt-4">

                                        <div class="col-6">
                                            
                                            <button class="btn btn-outline-danger  tab_btn  w-100" id="furn_sectors">가구 업종</button>
                                            
                                            <p class="mt-3 p-2">가구 제조/도매, 판매/매장, 유통의 임직원 계정입니다.</p>
                                            
                                        </div>
                                        
                                        <div class="col-6">
                                            
                                            <button class="btn btn-outline-danger tab_btn  w-100" id="normal">기타 가구 관련 업종</button>
                                            
                                            <p class="mt-3 p-2">가구와 연관된 기타 업종 전체(기타 사업자 포함) 입니다.</p>
                                            
                                        </div>

                                    </div>
                                    
                                </div>
                                
                                <div class="col-12 mt-4 text-center text-danger">
                                    일반 소비자는 회원가입이 불가합니다.
                                </div>
                                
                            </div>    
                            
                            
                            <div class="tab tab-func row" >
                                
                                <div class="tab-content">
                                    
                                    <form id="frm" style="display: none;">
                                        
                                        <div class="tab-content__panel" id="wholesale-tab-pane" data-usertype="W">
                                            
                                            <div class="content__item">
                                                
                                                <div class="content__title">회원 정보를 입력해주세요.</div>
                                                
                                                <div class="notice-box">
                                                    <ul>
                                                        <li><div class="ico__info"><span class="a11y">정보 아이콘</span></div>
                                                            가입 승인 이후 대표 계정에 소속된 직원 계정을 생성하실 수 있습니다.
                                                        </li>
                                                    </ul>
                                                </div>
                                                
                                                <div class="form">
                                                    
                                                    <div class="form__list" style="justify-content: start">
                                                        
                                                        <div class="form__label">
                                                            <label class="label label--necessary" for="businesscode">사업자 등록 번호</label>
                                                        </div>
                                                        <div style="position: relative;display:flex;align-items: start;flex:1">
                                                            <div style="flex:2;" class="pe-2">
                                                                <input class="input input--necessary input-guid__input w-100"
                                                                       id="w_businesscode"
                                                                       name="businesscode"
                                                                       type="text"
                                                                       required
                                                                       maxlength="12"
                                                                       placeholder="사업자 등록 번호를 입력해주세요."
                                                                       oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/^(\d{0,3})(\d{0,2})(\d{0,5})$/g, '$1-$2-$3').replace(/\-{1,2}$/g, '');">
                                                            </div>
                                                            <button class="button input-guid__button" style="flex:1" disabled onclick="checkBeforeAuthCode('business_regist_number', 'w')" type="button">중복체크</button>
                                                        </div>
                                                        
                                                    </div>
                                                    
                                                    <div class="form__list">
                                                        
                                                        <div class="form__label">
                                                            <label class="label label--necessary" for="certificate">명함 또는 사업자 등록증</label>
                                                        </div>
                                                        
                                                        <div class="filefield filefield--type-1">
                                                            <div class="file-input file-input--default">
                                                                <img id="w_img"/>
                                                                <input class="input input--necessary file-input__input"
                                                                       id="w_certificate"
                                                                       name="certificate"
                                                                       type="file"
                                                                       required
                                                                       placeholder="이미지 추가"
                                                                >
                                                                <div id="w_ico__gallery-image" class="ico__gallery-image"></div>
                                                                <div id="w_file-input__placeholder" class="file-input__placeholder">이미지 추가</div>
                                                                <a class="ico__sdelete" role="button"><span class="a11y">삭제</span></a>
                                                            </div>
                                                            <div class="form__notice-box">
                                                                <ul>
                                                                    <li>권장 형식: jpg, jpeg, png</li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="form__list">
                                                        <div class="form__label">
                                                            <label class="label label--necessary" for="businessname">업체명</label>
                                                        </div>
                                                        <div class="textfield">
                                                            <input class="input input--necessary textfield__input textfield__input--gray"
                                                                   id="w_businessname"
                                                                   name="businessname"
                                                                   type="text"
                                                                   required
                                                                   placeholder="업체명을 입력해주세요."
                                                            >
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="form__list">
                                                        <div class="form__label">
                                                            <label class="label label--necessary" for="username">대표자</label>
                                                        </div>
                                                        <div class="textfield">
                                                            <input class="input input--necessary textfield__input textfield__input--gray"
                                                                   id="w_username"
                                                                   name="username"
                                                                   type="text"
                                                                   required
                                                                   placeholder="대표자를 입력해주세요.">
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="form__list">
                                                        
                                                        <div class="form__label">
                                                            <label class="label label--necessary" for="w_contact">휴대폰 번호</label>
                                                        </div>
                                                        
                                                        <div class="input-guid" style="position: relative;">
                                                            
                                                            @include('login._country_phone_number', ['id'=>'w_phone_country_number'])
                                                            
                                                            <input class="input input--necessary input-guid__input input-guid__input--gray"
                                                                   id="w_contact"
                                                                   name="contact"
                                                                   type="text"
                                                                   required
                                                                   maxlength="13"
                                                                   placeholder="-없이 숫자만 입력해주세요."
                                                                   style="flex:3"
                                                                   oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/^(\d{0,3})(\d{0,4})(\d{0,4})$/g, '$1-$2-$3').replace(/\-{1,2}$/g, '');"
                                                            >
                                                        </div>
                                                        
                                                    </div>
                                                        
                                                    <div class="form__list">
                                                        <div class="form__label">
                                                            <label class="label label--necessary">사업자 주소</label>
                                                        </div>
                                                        <div class="addressfield">
                                                            <div class="radio radio-tab">
                                                                <label class="radio__item">
                                                                    <input type="radio" class="chkbox__checked chkbox__checked01 location" id="w_domain" name="filter-01" data-value=0 checked>
                                                                    <span>국내</span>
                                                                </label>
                                                                <label class="radio__item">
                                                                    <input type="radio" class="chkbox__checked chkbox__checked02 location" id="w_international" name="filter-01" data-value=1>
                                                                    <span>해외</span>
                                                                </label>
                                                            </div>
                                                            <!-- 국내 -->
                                                            <div class="location--type01 radio-tab-content">
                                                                <div class="input-guid">
                                                                    <input class="input input--necessary input-guid__input"
                                                                           id="w_businessaddress"
                                                                           name="businessaddress"
                                                                           type="text"
                                                                           readonly
                                                                           placeholder="주소를 검색해주세요."
                                                                           onclick="execPostCode('w')"
                                                                    >
                                                                    <button class="button input-guid__button" onclick="execPostCode('w')" type="button">주소 검색</button>
                                                                </div>

                                                            </div>

                                                            <!-- 해외 -->
                                                            <div class="location--type02 radio-tab-content" style="display: none;">
                                                                <div class="dropdown dropdown--type01">
                                                                    <p class="dropdown__title">지역</p>
                                                                    <div class="dropdown__wrap">
                                                                        <a class="dropdown__item" data-value=1>
                                                                            <p>아시아</p>
                                                                        </a>
                                                                        <a class="dropdown__item" data-value=2>
                                                                            <p>아프리카</p>
                                                                        </a>
                                                                        <a class="dropdown__item" data-value=3>
                                                                            <p>북아메리카</p>
                                                                        </a>
                                                                        <a class="dropdown__item" data-value=4>
                                                                            <p>남아메리카</p>
                                                                        </a>
                                                                        <a class="dropdown__item" data-value=5>
                                                                            <p>유럽</p>
                                                                        </a>
                                                                        <a class="dropdown__item" data-value=6>
                                                                            <p>오세아니아</p>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- 상세 -->
                                                            <input class="input input--necessary input-guid__input"
                                                                   id="w_businessaddressdetail"
                                                                   name="businessaddressdetail"
                                                                   type="text"
                                                                   readonly
                                                                   placeholder="상세 주소를 입력해주세요."
                                                                   style="margin-top:10px;"
                                                            >
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="form__list">
                                                        <div class="form__label">
                                                            <label class="label label--necessary" for="useremail">아이디</label>
                                                        </div>
                                                        <div class="input-guid" style="position: relative;">
                                                            <input class="input input--necessary input-guid__input"
                                                                   id="w_useremail"
                                                                   name="useremail"
                                                                   type="text"
                                                                   required
                                                                   placeholder="아이디를 입력해주세요.">
                                                            <button class="button input-guid__button get_code-email" disabled onclick="checkBeforeAuthCode('email', 'w')" type="button">중복체크</button>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="form__list">
                                                        <div class="form__label">
                                                            <label class="label label--necessary" for="userpw">비밀번호</label>
                                                        </div>
                                                        <div class="textfield">
                                                            <input class="input input--necessary textfield__input textfield__input--gray"
                                                                   id="w_userpw"
                                                                   name="userpw"
                                                                   type="password"
                                                                   required
                                                                   minlength="8"
                                                                   placeholder="비밀번호를 입력해주세요."
                                                            >
                                                            <div class="form__notice-box">
                                                                <ul>
                                                                    <li>영문 및 숫자 혼합하여 8자리 이상 입력해주세요.</li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="form__list">
                                                        <div class="form__label">
                                                            <label class="label label--necessary" for="userpwcheck">비밀번호 확인</label>
                                                        </div>
                                                        <div class="textfield">
                                                            <input class="input input--necessary textfield__input textfield__input--gray"
                                                                   id="w_userpwcheck"
                                                                   name="w_userpwcheck"
                                                                   type="password"
                                                                   required
                                                                   minlength="8"
                                                                   placeholder="비밀번호를 다시 입력해주세요."
                                                            >
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                                
                                            </div>
                                            
                                        </div>
                                        
                                        
                                        <div class="tab-content__panel" id="retail-tab-pane" data-usertype="R">
                                            
                                            <div class="content__item">
                                                
                                                <div class="content__title">회원 정보를 입력해주세요.</div>
                                                
                                                <div class="notice-box">
                                                    <ul>
                                                        <li><div class="ico__info"><span class="a11y">정보 아이콘</span></div>
                                                            가입 승인 이후 대표 계정에 소속된 직원 계정을 생성하실 수 있습니다.
                                                        </li>
                                                    </ul>
                                                </div>
                                                
                                                <div class="form">
                                                    
                                                    <div class="form__list" style="justify-content: start">
                                                        
                                                        <div class="form__label">
                                                            <label class="label label--necessary" for="businesscode">사업자 등록 번호</label>
                                                        </div>
                                                        <div style="position: relative;display:flex;align-items: start;flex:1">
                                                            <div style="flex:2;" class="pe-2">
                                                                <input class="input input--necessary input-guid__input w-100"
                                                                       id="r_businesscode"
                                                                       name="businesscode"
                                                                       type="text"
                                                                       required
                                                                       maxlength="12"
                                                                       placeholder="사업자 등록 번호를 입력해주세요."
                                                                       oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/^(\d{0,3})(\d{0,2})(\d{0,5})$/g, '$1-$2-$3').replace(/\-{1,2}$/g, '');">
                                                            </div>
                                                            <button class="button input-guid__button" style="flex:1" disabled onclick="checkBeforeAuthCode('business_regist_number', 'r')" type="button">중복체크</button>
                                                        </div>
                                                        
                                                    </div>
                                                    
                                                    <div class="form__list">
                                                        <div class="form__label">
                                                            <label class="label label--necessary" for="certificate">명함 또는 사업자 등록증</label>
                                                        </div>
                                                        <div class="filefield filefield--type-1">
                                                            <div class="file-input file-input--default">
                                                                <img id="r_img"/>
                                                                <input class="input input--necessary file-input__input"
                                                                       id="r_certificate"
                                                                       name="certificate"
                                                                       type="file"
                                                                       required
                                                                       placeholder="이미지 추가"
                                                                >
                                                                <div id="r_ico__gallery-image" class="ico__gallery-image"></div>
                                                                <div id="r_file-input__placeholder" class="file-input__placeholder">이미지 추가</div>
                                                                <a class="ico__sdelete" role="button"><span class="a11y">삭제</span></a>
                                                            </div>
                                                            <div class="form__notice-box">
                                                                <ul>
                                                                    <li>권장 형식: jpg, jpeg, png</li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="form__list">
                                                        <div class="form__label">
                                                            <label class="label label--necessary" for="businessname">업체명</label>
                                                        </div>
                                                        <div class="textfield">
                                                            <input class="input input--necessary textfield__input textfield__input--gray"
                                                                   id="r_businessname"
                                                                   name="businessname"
                                                                   type="text"
                                                                   required
                                                                   placeholder="업체명을 입력해주세요."
                                                            >
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="form__list">
                                                        <div class="form__label">
                                                            <label class="label label--necessary" for="username">대표자</label>
                                                        </div>
                                                        <div class="textfield">
                                                            <input class="input input--necessary textfield__input textfield__input--gray"
                                                                   id="r_username"
                                                                   name="username"
                                                                   type="text"
                                                                   required
                                                                   placeholder="대표자를 입력해주세요.">
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="form__list">
                                                        <div class="form__label">
                                                            <label class="label label--necessary" for="contact">휴대폰 번호</label>
                                                        </div>
                                                        
                                                        <div class="input-guid" style="position: relative;">
                                                            
                                                            @include('login._country_phone_number', ['id'=>'r_phone_country_number'])
                                                            
                                                            <input class="input input--necessary input-guid__input input-guid__input--gray"
                                                                   id="r_contact"
                                                                   name="contact"
                                                                   type="text"
                                                                   required
                                                                   maxlength="13"
                                                                   style="flex:3"
                                                                   placeholder="-없이 숫자만 입력해주세요."
                                                                   oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/^(\d{0,3})(\d{0,4})(\d{0,4})$/g, '$1-$2-$3').replace(/\-{1,2}$/g, '');">
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="form__list">
                                                        
                                                        <div class="form__label">
                                                            <label class="label label--necessary">사업자 주소</label>
                                                        </div>
                                                        
                                                        <div class="addressfield">
                                                            
                                                            <div class="radio radio-tab">
                                                                <label class="radio__item">
                                                                    <input type="radio" class="chkbox__checked chkbox__checked01 location" id="r_domain" name="filter-01" data-value="0" checked>
                                                                    <span>국내</span>
                                                                </label>
                                                                <label class="radio__item">
                                                                    <input type="radio" class="chkbox__checked chkbox__checked02 location" id="r_international" name="filter-01" data-value="1">
                                                                    <span>해외</span>
                                                                </label>
                                                            </div>
                                                            
                                                            <div class="location--type01 radio-tab-content">
                                                                <div class="input-guid">
                                                                    <input class="input input--necessary input-guid__input"
                                                                          id="r_businessaddress"
                                                                          name="businessaddress"
                                                                           type="text"
                                                                           readonly
                                                                           placeholder="주소를 검색해주세요."
                                                                           onclick="execPostCode('r')">
                                                                    <button class="button input-guid__button" onclick="execPostCode('r')" type="button">주소 검색</button>
                                                                </div>
                                                            </div>

                                                            <div class="location--type02 radio-tab-content" style="display: none;">
                                                                <div class="dropdown dropdown--type01">
                                                                    <p class="dropdown__title">지역</p>
                                                                    <div class="dropdown__wrap">
                                                                        <a class="dropdown__item" data-value=1>
                                                                            <p>아시아</p>
                                                                        </a>
                                                                        <a class="dropdown__item" data-value=2>
                                                                            <p>아프리카</p>
                                                                        </a>
                                                                        <a class="dropdown__item" data-value=3>
                                                                            <p>북아메리카</p>
                                                                        </a>
                                                                        <a class="dropdown__item" data-value=4>
                                                                            <p>남아메리카</p>
                                                                        </a>
                                                                        <a class="dropdown__item" data-value=5>
                                                                            <p>유럽</p>
                                                                        </a>
                                                                        <a class="dropdown__item" data-value=6>
                                                                            <p>오세아니아</p>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <input class="input input--necessary input-guid__input"
                                                                   id="r_businessaddressdetail"
                                                                   name="businessaddressdetail"
                                                                   type="text"
                                                                   readonly
                                                                   placeholder="상세 주소를 입력해주세요."
                                                                   style="margin-top:10px;">
                                                        </div>
                                                        
                                                    </div>
                                                    
                                                    <div class="form__list">
                                                        <div class="form__label">
                                                            <label class="label label--necessary" for="useremail">아이디</label>
                                                        </div>
                                                        <div class="input-guid" style="position: relative;">
                                                            <input class="input input--necessary input-guid__input"
                                                                   id="r_useremail"
                                                                   name="useremail"
                                                                   type="text"
                                                                   required
                                                                   placeholder="아이디를 입력해주세요.">
                                                            <button class="button input-guid__button get_code-email" disabled onclick="checkBeforeAuthCode('email', 'r')" type="button">중복체크</button>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="form__list">
                                                        <div class="form__label">
                                                            <label class="label label--necessary" for="userpw">비밀번호</label>
                                                        </div>
                                                        <div class="textfield">
                                                            <input class="input input--necessary textfield__input textfield__input--gray"
                                                                   id="r_userpw"
                                                                   name="userpw"
                                                                   type="password"
                                                                   required
                                                                   minlength="8"
                                                                   placeholder="비밀번호를 입력해주세요.">
                                                            <div class="form__notice-box">
                                                                <ul>
                                                                    <li>영문 및 숫자 혼합하여 8자리 이상 입력해주세요.</li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="form__list">
                                                        <div class="form__label">
                                                            <label class="label label--necessary" for="userpwcheck">비밀번호 확인</label>
                                                        </div>
                                                        <div class="textfield">
                                                            <input class="input input--necessary textfield__input textfield__input--gray"
                                                                   id="r_userpwcheck"
                                                                   name="r_userpwcheck"
                                                                   type="password"
                                                                   required
                                                                   minlength="8"
                                                                   placeholder="비밀번호를 다시 입력해주세요.">
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                        
                                        
                                        <div class="tab-content__panel" id="furn-sectors-tab-pane" data-usertype="S">
                                            
                                            <div class="content__item">
                                                
                                                <div class="content__title">회원 정보를 입력해주세요.</div>
                                                
                                                <div class="notice-box">
                                                    <ul>
                                                        <li><div class="ico__info"><span class="a11y">정보 아이콘</span></div>
                                                            가입 승인 이후 대표 계정에 소속된 직원 계정을 생성하실 수 있습니다.
                                                        </li>
                                                    </ul>
                                                </div>
                                                
                                                <div class="form">
                                                    
                                                    <div class="form__list">
                                                        
                                                        <div class="form__label">
                                                            <label class="label label--necessary" for="certificate">명함 첨부</label>
                                                        </div>
                                                        
                                                        <div class="filefield filefield--type-2">
                                                            <div class="file-input file-input--default">
                                                                <img id="s_img"/>
                                                                
                                                                <input class="input input--necessary file-input__input"
                                                                       id="s_certificate"
                                                                       name="certificate"
                                                                       type="file"
                                                                       required
                                                                       placeholder="이미지 추가">
                                                                       
                                                                <div id="s_ico__gallery-image" class="ico__gallery-image"></div>
                                                                
                                                                <div id="s_file-input__placeholder" class="file-input__placeholder">이미지 추가</div>
                                                                
                                                                <a class="ico__sdelete" role="button"><span class="a11y">삭제</span></a>
                                                            </div>
                                                            <div class="form__notice-box">
                                                                <ul>
                                                                    <li>권장 형식: jpg, jpeg, png</li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="form__list">
                                                        <div class="form__label">
                                                            <label class="label label--necessary" for="businessname">업체명</label>
                                                        </div>
                                                        <div class="textfield">
                                                            <input class="input input--necessary textfield__input textfield__input--gray"
                                                                   id="s_businessname"
                                                                   name="businessname"
                                                                   type="text"
                                                                   required
                                                                   placeholder="업체명을 입력해주세요.">
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="form__list">
                                                        <div class="form__label">
                                                            <label class="label label--necessary" for="username">성명/직위</label>
                                                        </div>
                                                        <div class="textfield">
                                                            <input class="input input--necessary textfield__input textfield__input--gray"
                                                                   id="s_username"
                                                                   name="username"
                                                                   type="text"
                                                                   required
                                                                   placeholder="성명/직위를 입력해주세요.">
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="form__list">
                                                        
                                                        <div class="form__label">
                                                            <label class="label label--necessary" for="contact">휴대폰 번호</label>
                                                        </div>
                                                        
                                                        <div class="input-guid" style="position: relative;">
                                                            
                                                            @include('login._country_phone_number', ['id'=>'s_phone_country_number'])
                                                            
                                                            <input class="input input--necessary input-guid__input input-guid__input--gray"
                                                                   id="s_contact"
                                                                   name="contact"
                                                                   type="text"
                                                                   required
                                                                   maxlength="13"
                                                                   style="flex:3"
                                                                   placeholder="-없이 숫자만 입력해주세요."
                                                                   oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/^(\d{0,3})(\d{0,4})(\d{0,4})$/g, '$1-$2-$3').replace(/\-{1,2}$/g, '');">
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="form__list">
                                                        
                                                        <div class="form__label">
                                                            <label class="label label--necessary" for="useremail">아이디</label>
                                                        </div>
                                                        
                                                        <div class="input-guid" style="position: relative;">
                                                            <input class="input input--necessary input-guid__input"
                                                                   id="s_useremail"
                                                                   name="useremail"
                                                                   type="text"
                                                                   required
                                                                   placeholder="아이디를 입력해주세요.">
                                                            <button class="button input-guid__button get_code-email" disabled onclick="checkBeforeAuthCode('email', 's')" type="button">중복체크</button>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="form__list">
                                                        <div class="form__label">
                                                            <label class="label label--necessary" for="userpw">비밀번호</label>
                                                        </div>
                                                        <div class="textfield">
                                                            <input class="input input--necessary textfield__input textfield__input--gray"
                                                                   id="s_userpw"
                                                                   name="userpw"
                                                                   type="password"
                                                                   required
                                                                   minlength="8"
                                                                   placeholder="비밀번호를 입력해주세요.">
                                                            <div class="form__notice-box">
                                                                <ul>
                                                                    <li>영문 및 숫자 혼합하여 8자리 이상 입력해주세요.</li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="form__list">
                                                        <div class="form__label">
                                                            <label class="label label--necessary" for="userpwcheck">비밀번호 확인</label>
                                                        </div>
                                                        <div class="textfield">
                                                            <input class="input input--necessary textfield__input textfield__input--gray"
                                                                   id="s_userpwcheck"
                                                                   name="s_userpwcheck"
                                                                   type="password"
                                                                   required
                                                                   minlength="8"
                                                                   placeholder="비밀번호를 다시 입력해주세요."
                                                            >
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        
                                        <div class="tab-content__panel" id="normal-tab-pane" data-usertype="N">
                                            
                                            <div class="content__item">
                                                
                                                <div class="content__title">회원 정보를 입력해주세요.</div>
                                                
                                                <div class="form">
                                                    
                                                    <!-- 명함첨부 -->
                                                    <div class="form__list">
                                                        <div class="form__label">
                                                            <label class="label label--necessary" for="certificate">명함 첨부</label>
                                                        </div>
                                                        <div class="filefield filefield--type-2">
                                                            <div class="file-input file-input--default">
                                                                <img id="n_img"/>
                                                                <input class="input input--necessary file-input__input"
                                                                       id="n_certificate"
                                                                       name="certificate"
                                                                       type="file"
                                                                       required
                                                                       placeholder="이미지 추가"
                                                                >
                                                                <div id="n_ico__gallery-image" class="ico__gallery-image"></div>
                                                                <div id="n_file-input__placeholder" class="file-input__placeholder">이미지 추가</div>
                                                                <a class="ico__sdelete" role="button"><span class="a11y">삭제</span></a>
                                                            </div>
                                                            <div class="form__notice-box">
                                                                <ul>
                                                                    <li>권장 형식: jpg, jpeg, png</li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <!-- 업체명 -->
                                                    <div class="form__list">
                                                        <div class="form__label">
                                                            <label class="label label--necessary" for="businessname">업체명</label>
                                                        </div>
                                                        <div class="textfield">
                                                            <input class="input input--necessary textfield__input textfield__input--gray"
                                                                   id="n_businessname"
                                                                   name="businessname"
                                                                   type="text"
                                                                   required
                                                                   placeholder="업체명을 입력해주세요.">
                                                        </div>
                                                    </div>
                                                    
                                                    <!-- 성명/직위 -->
                                                    <div class="form__list">
                                                        <div class="form__label">
                                                            <label class="label label--necessary" for="username">성명/직위</label>
                                                        </div>
                                                        <div class="textfield">
                                                            <input class="input input--necessary textfield__input textfield__input--gray"
                                                                   id="n_username"
                                                                   name="username"
                                                                   type="text"
                                                                   required
                                                                   placeholder="성명/직위를 입력해주세요.">
                                                        </div>
                                                    </div>
                                                    
                                                    <!-- 휴대폰 번호 -->
                                                    <div class="form__list">
                                                        
                                                        <div class="form__label">
                                                            <label class="label label--necessary" for="n_contact">휴대폰 번호</label>
                                                        </div>
                                                        
                                                        <div class="input-guid" style="position: relative;">
                                                            
                                                            @include('login._country_phone_number', ['id'=>'n_phone_country_number'])
                                                            
                                                            <input class="input input--necessary input-guid__input input-guid__input--gray"
                                                                   id="n_contact"
                                                                   name="contact"
                                                                   type="text"
                                                                   required
                                                                   maxlength="13"
                                                                   style="flex:3"
                                                                   placeholder="-없이 숫자만 입력해주세요."
                                                                   oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/^(\d{0,3})(\d{0,4})(\d{0,4})$/g, '$1-$2-$3').replace(/\-{1,2}$/g, '');">
                                                        </div>
                                                    </div>
                                                    
                                                     <!-- 아이디 -->   
                                                    <div class="form__list">
                                                        
                                                        <div class="form__label">
                                                            <label class="label label--necessary" for="n_useremail">아이디</label>
                                                        </div>
                                                        
                                                        <div class="input-guid" style="position: relative;">
                                                            <input class="input input--necessary input-guid__input"
                                                                   id="n_useremail"
                                                                   name="useremail"
                                                                   type="text"
                                                                   required
                                                                   placeholder="아이디를 입력해주세요.">
                                                            <button class="button input-guid__button get_code-email" disabled onclick="checkBeforeAuthCode('email', 'n')" type="button">중복체크</button>
                                                        </div>
                                                    </div>

                                                    <!-- 비밀번호 -->
                                                    <div class="form__list">
                                                        <div class="form__label">
                                                            <label class="label label--necessary" for="userpw">비밀번호</label>
                                                        </div>
                                                        <div class="textfield">
                                                            <input class="input input--necessary textfield__input textfield__input--gray"
                                                                   id="n_userpw"
                                                                   name="userpw"
                                                                   type="password"
                                                                   required
                                                                   minlength="8"
                                                                   placeholder="비밀번호를 입력해주세요.">
                                                            <div class="form__notice-box">
                                                                <ul>
                                                                    <li>영문 및 숫자 혼합하여 8자리 이상 입력해주세요.</li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <!-- 비밀번호 확인 -->
                                                    <div class="form__list">
                                                        <div class="form__label">
                                                            <label class="label label--necessary" for="n_userpwcheck">비밀번호 확인</label>
                                                        </div>
                                                        <div class="textfield">
                                                            <input class="input input--necessary textfield__input textfield__input--gray"
                                                                   id="n_userpwcheck"
                                                                   name="n_userpwcheck"
                                                                   type="password"
                                                                   required
                                                                   minlength="8"
                                                                   placeholder="비밀번호를 다시 입력해주세요.">
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>


                                        <div class="agreementNsubmit" style="display: none;">
                                            <div class="form__check-box">
                                                <div class="form__title">올펀 약관에 동의해주세요.</div>
                                                <div class="check-box">
                                                    <div class="check-box__list check-box__list--checkall">
                                                        <div class="check-box__label check-box__label--checkall">
                                                            <label for="register-agreement_0" class="category__check">
                                                                <input class="checkbox__input checkbox__input--checkall"
                                                                       id="register-agreement_0"
                                                                       type="checkbox"
                                                                >
                                                                <span>필수 약관 전체 동의</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="check-box__list">
                                                        <div class="check-box__label">
                                                            <label for="register-agreement_1" class="category__check">
                                                                <input class="checkbox__input checkbox__input--necessary"
                                                                       id="register-agreement_1"
                                                                       type="checkbox"
                                                                >
                                                                <span>서비스 이용 약관 동의 (필수)</span>
                                                            </label>
                                                        </div>
                                                        <button class="button check-box__button" type="button" onclick="openModal('#reg-agrmnt_service')">상세 보기</button>
                                                    </div>
                                                    <div class="check-box__list">
                                                        <div class="check-box__label">
                                                            <label for="register-agreement_2" class="category__check">
                                                                <input class="checkbox__input checkbox__input--necessary"
                                                                       id="register-agreement_2"
                                                                       type="checkbox"
                                                                >
                                                                <span>개인정보 활용 동의 (필수)</span>
                                                            </label>
                                                        </div>
                                                        <button class="button check-box__button" type="button" onclick="openModal('#reg-agrmnt_privacy-info')">상세 보기</button>
                                                    </div>
                                                    <div class="check-box__list">
                                                        <div class="check-box__label">
                                                            <label for="register-agreement_3" class="category__check">
                                                                <input class="checkbox__input"
                                                                       id="register-agreement_3"
                                                                       type="checkbox"
                                                                >
                                                                <span>마케팅 정보 활용 동의 (선택)</span>
                                                            </label>
                                                        </div>
                                                        <button class="button check-box__button" type="button" onclick="openModal('#reg-agrmnt_marketing-info')">상세 보기</button>
                                                    </div>
                                                    <div class="check-box__list">
                                                        <div class="check-box__label">
                                                            <label for="register-agreement_4" class="category__check">
                                                                <input class="checkbox__input"
                                                                       id="register-agreement_4"
                                                                       type="checkbox"
                                                                >
                                                                <span>광고성 이용 동의 (선택)</span>
                                                            </label>
                                                        </div>
                                                        <button class="button check-box__button" type="button" onclick="openModal('#reg-agrmnt_promo')">상세 보기</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="button-wrap" style="margin-bottom: 0;">
                                                <button type="button"
                                                        href="#"
                                                        class="button form__submit-button button--solid"
                                                        id="register_form-submit"
                                                        onclick="submitAction()"
                                                >
                                                    가입 완료
                                                </button>
                                            </div>
                                        </div>
                                        
                                    </form>
                                    
                                </div>
                                
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="reg-agrmnt_service" class="modal">
            <div class="modal__container">
                <div class="modal__content">
                    <div class="modal-box__container" style="width: 566px">
                        <div class="modal-box__content">
                            <div class="header">
                                <p>서비스 이용 약관</p>
                            </div>
                            <div class="content">
                                <iframe src="{{env('ALLFURN_API_DOMAIN')}}/res/agreement/agreement.html" style="width: 100%; height: 100%; padding-top: 10px; padding-bottom: 10px; background-color: #f0f0f0;">
                                </iframe>
                            </div>
                            <div class="footer" style="height: 42px"></div>
                            <div class="modal-close">
                                <button type="button" onclick="closeModal('#reg-agrmnt_service')" class="modal__close-button"><span class="a11y">닫기</span></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="reg-agrmnt_privacy-info" class="modal">
            <div class="modal__container">
                <div class="modal__content">
                    <div class="modal-box__container" style="width: 566px">
                        <div class="modal-box__content">
                            <div class="header">
                                <p>개인정보 활용 동의</p>
                            </div>
                            <div class="content">
                                <iframe src="{{env('ALLFURN_API_DOMAIN')}}/res/agreement/privacy.html" style="width: 100%; height: 100%; padding-top: 10px; padding-bottom: 10px; background-color: #f0f0f0;">
                                </iframe>
                            </div>
                            <div class="footer" style="height: 42px"></div>
                            <div class="modal-close">
                                <button type="button" onclick="closeModal('#reg-agrmnt_privacy-info')" class="modal__close-button"><span class="a11y">닫기</span></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="reg-agrmnt_marketing-info" class="modal">
            <div class="modal__container">
                <div class="modal__content">
                    <div class="modal-box__container" style="width: 566px">
                        <div class="modal-box__content">
                            <div class="header">
                                <p>마케팅 정보 활용 동의</p>
                            </div>
                            <div class="content">
                                <iframe src="{{env('ALLFURN_API_DOMAIN')}}/res/agreement/marketing.html" style="width: 100%; height: 100%; padding-top: 10px; padding-bottom: 10px; background-color: #f0f0f0;">
                                </iframe>
                            </div>
                            <div class="footer" style="height: 42px"></div>
                            <div class="modal-close" onclick="closeModal('#reg-agrmnt_marketing-info')">
                                <button type="button" class="modal__close-button"><span class="a11y">닫기</span></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="reg-agrmnt_promo" class="modal">
            <div class="modal__container">
                <div class="modal__content">
                    <div class="modal-box__container" style="width: 566px">
                        <div class="modal-box__content">
                            <div class="header">
                                <p>광고성 이용 동의</p>
                            </div>
                            <div class="content">
                                <iframe src="" style="width: 100%; height: 100%; padding-top: 10px; padding-bottom: 10px; background-color: #f0f0f0;">
                                </iframe>
                            </div>
                            <div class="footer" style="height: 42px"></div>
                            <div class="modal-close" onclick="closeModal('#reg-agrmnt_promo')">
                                <button type="button" class="modal__close-button"><span class="a11y">닫기</span></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 이메일 중복 팝업 -->
        <div id="modal-email--duplicated" class="modal">
            <div class="modal__container" style="width: 350px;">
                <div class="modal__content">
                    <div class="modal-box__container">
                        <div class="modal-box__content">
                            <div class="modal__desc">
                                <p id="email_dupcheck_ment" class="modal__text">
                                    이미 사용중인 이메일 입니다. 다시 확인해주세요.
                                </p>
                            </div>
                            <div class="modal__util">
                                <button type="button" onclick="closeModalWithFocus('#modal-email--duplicated')" class="modal__button"><span>확인</span></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
@endsection

@section('script')
    <script src="https://ssl.daumcdn.net/dmaps/map_js_init/postcode.v2.js?autoload=false"></script>
    <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.0/jquery.validate.min.js" ></script>

    <script>
        var isProc = false; // 중복등록 방지용
        let base = '[aria-hidden="false"] ';
        var phoneAuthTime = 300; // 최초 설정 시간(기본 : 초)
        var emailAuthTime = 300;
        var email_dup_check = false;
        var business_code_dup_check = false;

        function TimerStart(type){
            if (type == 'phone') {
                phoneTid=setInterval('authTimer("phone")',1000)
            } else {
                emailTid=setInterval('authTimer("email")',1000)
            }
        };

        // 인증번호 카운팅
        function authTimer(type) {   // 1초씩 카운트
            if (type == 'phone') {
                timer = Math.floor(phoneAuthTime / 60) + ":" + String(phoneAuthTime % 60).padStart(2, '0'); // 남은 시간 계산
                $('.input-guid__input_timer.phone').text(timer);     // div 영역에 보여줌
                phoneAuthTime--;

                if (phoneAuthTime < 0) {          // 시간이 종료 되었으면..
                    clearInterval(phoneTid);     // 타이머 해제
                    endTimer(type);
                    phoneAuthTime = 300;
                }
            } else {
                timer = Math.floor(emailAuthTime / 60) + ":" + String(emailAuthTime % 60).padStart(2, '0'); // 남은 시간 계산
                $('.input-guid__input_timer.email').text(timer);     // div 영역에 보여줌
                emailAuthTime--;

                if (emailAuthTime < 0) {          // 시간이 종료 되었으면..
                    clearInterval(emailTid);     // 타이머 해제
                    endTimer(type);
                    emailAuthTime = 300;
                }
            }
        }

        // 인증번호 카운팅 종료
        function endTimer(type) {
            $('.input-guid__input_timer.'+type).text('');
            $(base + '.input-guid__input.'+type).val('');
            $(base + '.input-guid__input.'+type+', ' + base + '.input-guid__button.'+type).attr('disabled', true);

            $(base + '.form__notification.'+type+'_auth .notification_text').text('입력시간이만료되었습니다.인증번호를재전송해주세요.');
            $(base + '.form__notification.'+type+'_auth').css('display','block');
            $(base + '.form__notification.'+type+'_auth').addClass('error');
        }
        

        $(document).ready(function() {
            
            // 탭별 추가화
            $('.tab_btn').click(function() {
                

                $('.tab-content__panel').hide();
                
                // $('.tab_title').parent().removeClass('active');
                
                // $(this).parent().addClass('active');
                
                $('.tab_btn').removeClass('btn-danger');
                
                $('.tab_btn').addClass('btn-outline-danger');
                
                $(this).removeClass('btn-outline-danger');
                
                $(this).addClass('btn-danger');
                
                
                if ( $(this).attr('id') === 'whole_sale' ) {
                    

                    
                    $('#wholesale-tab-pane').show();
                    
                    base = '#wholesale-tab-pane';
                    
                    
                } else if ( $(this).attr('id') === 'retail' ) {
                    
                    $('#retail-tab-pane').show();
                    
                    base = '#retail-tab-pane';
                    
                } else if ( $(this).attr('id') === 'furn_sectors' ) {
                    
                    $('#furn-sectors-tab-pane').show();
                    
                    base = '#furn-sectors-tab-pane';
                    
                } else if ( $(this).attr('id') === 'normal' ) {
                    
                    $('#normal-tab-pane').show();
                    
                    base = '#normal-tab-pane';
                    
                }
                
                
                $('.agreementNsubmit').css('display', 'block');
                $('input').val('');
                $('.phone_auth, .email_auth').css('display', 'none');
                $('#register_form-submit').attr('disabled', true);

                $('.checkbox__input').prop("checked", false);
                $('.checkbox__input').val(false);
                
                $('#frm').css('display', 'block');
                
            })
            

            $('[type="file"]').on("change", handleImgFileSelect);
            
            
            $('input:radio[name=filter-01]').click(function () {
                
                var p_id = ''
                
                if ( $(this).attr('id') === 'w_domain' ) {
                    p_id = '#wholesale-tab-pane'
                } else if ( $(this).attr('id') === 'r_domain' ) {
                    p_id = '#retail-tab-pane'
                }
                
                $(p_id + ' .location--type01.radio-tab-content').css('display','none');
                $(p_id + ' .location--type02.radio-tab-content').css('display','none');

                if ($(this).is($('.chkbox__checked01'))) {
                    $(p_id + ' .location--type01.radio-tab-content').css('display','block');
                } else {
                    $(p_id + ' .location--type02.radio-tab-content').css('display','block');
                }

                $(p_id + ' .dropdown__title').text('지역');
                $(p_id + ' .dropdown__title').data('domestic_type', 0);
                $(p_id + ' [name="businessaddress"]').val("");
                $(p_id + ' [name="businessaddressdetail"]').val("");
                $(p_id + ' [name="businessaddressdetail"]').prop('readonly', true);
                
            })
            
            
            $('.dropdown__item').click(function() {
                $(this).parents('.dropdown').find('.dropdown__title').data('domestic_type', $(this).data('value'));
                $(base + ' [name="businessaddressdetail"]').val("");
                $(base + ' [name="businessaddressdetail"]').removeAttr('readonly');
                $(base + ' [name="businessaddressdetail"]').focus();
            })
            
             
            $('.input-guid__input#w_useremail, .input-guid__input#r_useremail, .input-guid__input#s_useremail, .input-guid__input#n_useremail').keyup(function () {
                let email = $(this).val();
                // var filter = /^([a-zA-Z0-9_.-])+@(([a-zA-Z0-9-])+.)+([a-zA-Z0-9]{2,4})+$/;
                // if (email != "" && filter.test(email)) {
                if (email !== "") {
                    $(this).parent().find('button').removeAttr("disabled");
                } else {
                    $(this).parent().find('button').prop("disabled", true);
                }
            });
            
            
            $('.input-guid__input#w_businesscode, .input-guid__input#r_businesscode').keyup(function () {
                let business_code = $(this).val();
                if (business_code !== "") {
                    $(this).parent().parent().find('button').removeAttr("disabled");
                } else {
                    $(this).parent().parent().find('button').prop("disabled", true);
                }
            });
            

            //set initial state.
            $('.checkbox__input').prop("checked", false);
            $('.checkbox__input').val(false);

            $('.checkbox__input').not('.checkbox__input--checkall').change(function() {
                $(this).val($(this).is(':checked'));

                if (!$(this).is(':checked')) {
                    $('#register-agreement_0').prop("checked", $(this).is(':checked'));

                } else {
                    let obj = $('.checkbox__input').not('.checkbox__input--checkall');
                    let checked = 0;
                    for (i = 0; i < obj.length; i++) {
                        if (obj[i].checked === true) {
                            checked += 1;
                        }
                    }

                    if (checked == 4) {
                        $('#register-agreement_0').prop("checked", $(this).is(':checked'));
                    }
                }
            });

            $('#register-agreement_0').click(function() {
                $('.checkbox__input').prop("checked", $(this).is(':checked'));
                $('.checkbox__input').val($(this).is(':checked'));
            });


            $('input, .checkbox__input--necessary').change(function () {
                
                var errors = 0;
                
                $(base + ' .input-guid__input').map(function() {
                    
                    if( $(this).val().length === 0 ) {
                        
                        if ( $(this).attr('name') === 'businessaddress' && $(base + ' [name="filter-01"]:checked').data('value') === 1 ) {
                        } else {
                            errors++;    
                        }  
                        
                    }
                    
                });
                
                
                if (!$('#register-agreement_1').is(':checked') || !$('#register-agreement_2').is(':checked')) {
                    errors++;
                }
                
                
                if (!email_dup_check) {
                    errors++;
                }
                
                
                if (errors == 0) {
                    $('#register_form-submit').removeAttr('disabled');
                } else {
                    $('#register_form-submit').prop('disabled', true);
                }
                
            });
            

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
                    }
                }
            });

            actvTabList('register-type', 99)
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
                        $(`#${t}_businessaddressdetail`).removeAttr('readonly');
                        $(`#${t}_businessaddressdetail`).focus();
                    }
                }).open();
            });
        }
        

        // 사용중 이메일, 사업자번호 체크
        function checkBeforeAuthCode(type, t) {
            
            if ( type === 'business_regist_number' ) {
                
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
                            $('#email_dupcheck_ment').html('사용가능한 사업자번호 입니다.');
                            $(`#${t}_businesscode`).removeClass('error');
                            $(`#${t}_businesscode`).parent().find('label').hide();
                            business_code_dup_check = true;
                        } else {
                            $('#email_dupcheck_ment').html('이미 사용중인 사업자번호 입니다. 다시 확인해주세요.');
                        }
                    
                        openModal('#modal-email--duplicated');
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
                    
                        openModal('#modal-email--duplicated');
                    }
                });
                
            }
            
        }






        // 인증번호 전송 ('phone': 전화번호 / 'email': 이메일)
        function authCode(type) {
            var data = new Object() ;
            data.target = type == 'phone' ? $(base + '#contact').val().replace(/-/g, '') : $(base + '#useremail').val() ;
            data.type = type == 'phone' ? "S" : "E" ;

            $.ajax({
                url				: '/signup/sendAuthCode',
                contentType: "application/x-www-form-urlencoded; charset=UTF-8",
                data			: data,
                type			: 'POST',
                dataType		: 'json',
                xhrFields: {
                    withCredentials: false
                },
                success : function(result) {
                    
                    if (result.success) {
                        $(base + ' .form__list.' + type + '_auth').css('display','flex');
                        $(base + ' .input-guid__input.'+type+', [aria-hidden="false"] .input-guid__button.'+type).removeAttr('disabled');
                        $(base + ' .form__notification.'+type+'_auth').css('display','none');
                        $(base + ' .get_code-'+type).text('인증번호 재전송');

                        TimerStart(type);
                    } else {
                        alert(result.message);
                    }
                }
            });
        }



        

        // 인증번호 확인 ('phone': 전화번호 / 'email': 이메일)
        function confirmAuthCode(type) {
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url				: '/signup/confirmAuthCode',
                data			: {
                    'type'    : type == 'phone' ? 'S' : 'E',
                    'target'  : type == 'phone' ? $(base + ' #contact').val().replace(/-/g, '') : $(base + ' #useremail').val(),
                    'code'    : $(base + '.input-guid__input.'+type).val()
                },
                type			: 'POST',
                dataType		: 'json',
                success		: function(result) {
                    if (result.success) {
                        if (type == 'phone') {
                            clearInterval(phoneTid);

                            $(base + '#contact').attr('disabled', true);
                        } else {
                            clearInterval(emailTid);

                            $(base + '#useremail').attr('disabled', true);
                        }

                        $(base + '.input-guid__input_timer.'+type).text('');
                        $(base + '.form__notification.'+type+'_auth .notification_text').text('인증되었습니다.');
                        $(base + '.get_code-'+type+', ' + base + '.input-guid__input.'+type+', ' + base + '.input-guid__button.'+type).attr('disabled', true);
                        $(base + '.form__notification.'+type+'_auth').removeClass('error');
                        $(base + '.form__notification.'+type+'_auth').css('display','block');

                        $(base + '.input-guid__input.email').removeClass('error');

                    } else {
                        $(base + '.form__notification.'+type+'_auth .notification_text').text('인증번호가일치하지않습니다.다시확인해주세요.');
                        $(base + '.form__notification.'+type+'_auth').addClass('error');
                        $(base + '.form__notification.'+type+'_auth').css('display','block');
                    }
                }
            });
        }
        

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
                        $('#w_ico__gallery-image').hide();
                        $('#w_file-input__placeholder').hide();
                        
                    } else if ( attr_id === 'r_certificate' ) {
                        
                        $('#r_img').attr('src', e.target.result);
                        $('#r_img').css({'width':'inherit','height':'inherit'});
                        $('#r_ico__gallery-image').hide();
                        $('#r_file-input__placeholder').hide();
                        
                    } else if ( attr_id === 's_certificate' ) {
                        
                        $('#s_img').attr('src', e.target.result);
                        $('#s_img').css({'width':'inherit','height':'inherit'});
                        $('#s_ico__gallery-image').hide();
                        $('#s_file-input__placeholder').hide();
                        
                    } else if ( attr_id === 'n_certificate' ) {
                        
                        $('#n_img').attr('src', e.target.result);
                        $('#n_img').css({'width':'inherit','height':'inherit'});
                        $('#n_ico__gallery-image').hide();
                        $('#n_file-input__placeholder').hide();
                        
                    }
                    
                    // $(base + ' .ico__gallery-image, .file-input__placeholder').hide();
                    
                }
                
                reader.readAsDataURL(f);
                
            });
            
        }




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
                form.append('isDomestic', $(base + ' [name="filter-01"]:checked').data('value'));
                if ($(base + ' [name="filter-01"]:checked').data('value') === 1) {
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


        function closeModalWithFocus(name)
        {
            closeModal(name);
            $(base + ' #useremail').focus();
        }
        
    </script>
        
@endsection


