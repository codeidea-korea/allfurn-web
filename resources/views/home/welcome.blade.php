@extends('layouts.master')

@section('header')
    <header id="header" class="header">
        <div class="head__fixed">
            <div class="inner">
                <div class="head__flex">
                    <h1 class="head__logo"><a href="/"><span class="a11y">All FURN</span></a></h1>
                </div>


                <div class="head__util">
                    <div class="util__link">
                        @if (Auth::check()) 
                            <a href="/message">올톡</a>
                            <a href="/mypage">마이올펀</a>
                            <a href="/help">고객센터</a>
                            <a href="/alarm">
                                <i class="ico__alram"><span class="a11y">알람</span></i>
                                <span class="badge" name="alarm" style="display:none;">1</span>
                            </a>
                            <? if (Auth::user()->type != 'N') { ?>
                            <a href="/cart">
                                <i class="ico__basket"><span class="a11y">장바구니</span></i>
                                <span class="badge" name="cart" style="display:none;">1</span>
                            </a>
                            <? } ?>
                        @else
                            <a href="{{ route('signIn') }}">로그인</a>
                            <a href="{{ route('signUp') }}">회원가입</a>
                        @endif
                    </div>
                </div>
                
            </div>
        </div>
    </header>
@stop

@section('content')

    <div id="container" class="container">
        <div class="inner__full">
            <div class="intro intro__top">
                <div class="inner">
                    <div class="intro__content">
                        <strong class="intro__content-top">세상의 모든 가구 생산공급자 및 판매자, <br>가구관련 종사업종의 모든 분들의 정보가 있는</strong>
                        <h2>올펀(All-Furn)을 만나보세요</h2>
                        <ul>
                            <li>내가 생산 / 공급하는 가구를 판매자들에게 <br>쉽고 빠르게 <b>알릴 수 없을까?</b></li>
                            <li>내 매장에서 팔릴 만한 가구 제품 정보를 <br>쉽고 빠르게 <b>알 수 없을까?</b></li>
                            <li>국내가구만이 아닌, <b>전 세계의 가구제품정보</b>를 <br>쉽고 빠르게 <b>알 수 없을까?</b></li>
                        </ul>
                        <div class="desc"><b>올펀 [All-Furn]은 위 질문에서부터</b> 시작되었습니다.</div>
                        <div class="desc">가구인들의 도소매 사장님들의 비지니스 파트너~! <br>그 외 가구 연계 비지니스를 가지시는 모든 분들을 위한 </div>
                        <div class="desc"><b>대표 어플리케이션 올펀[All-Furn]을 지금 만나보세요~!</b></div>
                    </div>
                    <div class="image"><img src="/ver.1/images/home/allfurn_intro.png" /></div>
                </div>
            </div>
            <div class="intro intro01">
                <div class="inner">
                    <div class="intro__content">
                        <h2>
                            지금 <b>주목받는 가구 신상품</b>과<br>
                            <b>업계 소식</b>을 올펀에서 확인해보세요.
                        </h2>
                        <div class="desc">현재 가구시장에 나오는 <br><b>최신 제품정보 / 판매 트렌드</b>를 눈에 확인할 수 있습니다</div>
                        <div class="desc">매월 업데이트되는 가구들의 정보와 이야기들을 지금 만나보세요~!</div>
                    </div>
                    <div class="image"><img src="/ver.1/images/home/allfurn_intro001.png" /></div>
                </div>
            </div>
            <div class="intro intro02">
                <div class="inner">
                    <div class="intro__content">
                        <h2>
                            생산 / 도매사장님만의 <b>[제품과 회사]를 소개</b>해보세요~!<br>
                            매출은 UP! 거래처정보도 UP!
                        </h2>
                        <div class="desc">약간의 시간을 투자하시면, <br>생산 / 도매 사장님의 <b>미니홈페이지</b>가 만들어집니다.</div>
                        <div class="desc">사장님만의 <b>[제품 소개 미니홈페이지]</b>를 통해 매출의 <br>새로운 영업루트를 지금 만들어보세요</div>
                    </div>
                    <div class="image"><img src="/ver.1/images/home/allfurn_intro002.png" /></div>
                </div>
            </div>
            <div class="intro intro03">
                <div class="inner">
                    <div class="intro__content">
                        <h2>
                            소매사장님 매장에 맞는<br>
                            <b>트렌디한 제품정보</b>가 가득가득!
                        </h2>
                        <div class="desc">국내&해외 가구 제품 정보들을 한눈에 확인이 가능하십니다~!</div>
                        <div class="desc">원하시는 타이밍에 제품기획전까지 고민할 수 있는 <br>최적의 비즈니스 파트너 [올펀]에서 제품 검색 및 소통을 시작해보세요</div>
                    </div>
                    <div class="image"><img src="/ver.1/images/home/allfurn_intro003.png" /></div>
                </div>
            </div>
            <div class="intro intro04">
                <div class="inner">
                    <div class="intro__content">
                        <h2>
                            가구인들의 일상부터 비즈니스 이야기까지<br>
                            커뮤니티에서 공유해보세요.
                        </h2>
                        <div class="desc">가구인만의 언어가 있는 것을 너무나 잘 알고 있습니다.</div>
                        <div class="desc">제품 그리고 배송, A/S 등 가구인 그리고 가구관련 종사를 하고 있는 <br>모든 분이 직접 주인이 되셔서, 이야기 게시판을 만들고 소통 해보세요~!</div>
                    </div>
                    <div class="image"><img src="/ver.1/images/home/allfurn_intro004.png" /></div>
                </div>
            </div>
        </div>
    </div>
@stop
