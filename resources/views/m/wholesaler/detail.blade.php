@extends('layouts.app_m')
@php
    $only_quick = '';
    $header_depth = 'wholesaler';
    $top_title = '';
    $header_banner = '';
@endphp
@section('content')
@include('layouts.header_m')
<div id="content">
    <div class="company_detail_top">
        <div class="banner" style="background-image:url('/img/company_banner.png')">
            <div class="profile_img">
                <img src="@if($data['info']->imgUrl != null) {{$data['info']->imgUrl}} @else /img/profile_img.svg @endif" alt="">
            </div>
        </div>
        <div class="link_box">
            <button class="addLike {{ ($data['info']->isLike == 1) ? 'active' : '' }}" onClick="addLike({{$data['info']->idx}});"><svg><use xlink:href="/img/icon-defs.svg#zzim"></use></svg></button>
            <button><svg><use xlink:href="/img/icon-defs.svg#share"></use></svg></button>
        </div>
        <div class="inner">
            <div class="info">
                <div class="left_box">
                    <h3>{{$data['info']->company_name}}</h3>
                    <div class="tag">
                        <p>{{$data['info']->place}}</p>
                        @foreach($data['category'] as $item)
                            <span>{{$item->name}}</span>
                        @endforeach
                    </div>
                </div>
                <div class="right_box">
                    <div class="link_box">
                        <p>
                            좋아요 수
                            <b>{{$data['info']->likeCnt()}}</b>
                        </p>
                        <p>
                            문의 수
                            <b>{{$data['info']->inquiryCnt}}</b>
                        </p>
                        <p>
                            방문 수
                            <b>{{$data['info']->visitCnt}}</b>
                        </p>
                    </div>
                    <div class="btn_box">
                        <button class="btn btn-primary-line phone" onClick="location.href='/message';"><svg class="w-5 h-5"><use xlink:href="/img/icon-defs.svg#inquiry"></use></svg>문의하기</button>
                        <button class="btn btn-primary" onclick="modalOpen('#company_phone-modal')"><svg class="w-5 h-5"><use xlink:href="/img/m/icon-defs.svg#phone_white"></use></svg>전화번호 확인하기</button>
                    </div>
                </div>
            </div>
            <div class="notice_box">
                <dl class="active">
                    <dt>
                        <p>
                            <svg><use xlink:href="/img/icon-defs.svg#Notice_primary"></use></svg>
                            전화문의 9시부터 6시까지 가능
                        </p>
                        <svg><use xlink:href="/img/icon-defs.svg#Notice_arrow_black"></use></svg>
                    </dt>
                    <dd>
                        공휴일/ 토요일/ 일요일 휴무입니다.<br/>
                        통화 부재 시 문자 남겨 주시면 전화드리겠습니다.
                    </dd>
                </dl>
            </div>
        </div>
    </div>

    <div class="company_detail">
        <div class="community_tab">
            <ul>
                <li class="active"><a href="javascript:;">판매 상품</a></li>
                <li><a href="javascript:;">업체 정보</a></li>
            </ul>
        </div>
        <div class="tab_content">
            <!-- 판매상품 -->
            <div class="active">
                @if( count( $data['event'] ) > 0 )
                <div class="box">
                    <div class="inner">
                        <div class="main_tit mb-5">
                            <h3>{{$data['info']->company_name}} 이벤트 상품</h3>
                        </div>
                        <div class="relative">
                            @foreach( $data['event'] AS $e => $event )
                            @if( $e == 0 )
                            <ul class="prod_list grid1 mb-10">
                            @elseif( $e == 1 )
                            </ul>
                            <ul class="prod_list">
                            @endif
                                <li class="prod_item type02">
                                    <div class="img_box">
                                        <a href="/product/detail/{{$event->idx}}">
                                            <img src="{{$event->imgUrl}}" alt="">
                                            <!-- span><b>호텔같은 내 침실로!</b><br>#20조 한정 할인 특가 #호텔형 침대</span //-->
                                        </a>
                                        <button class="zzim_btn prd_{{$event->idx}} {{ ($event->isInterest == 1) ? 'active' : '' }}" pidx="{{$event->idx}}"><svg><use xlink:href="/img/icon-defs.svg#zzim"></use></svg></button>
                                    </div>
                                    <div class="txt_box">
                                        <a href="./prod_detail.php">
                                            <strong>내 침실을 휴향지 호텔 처럼!  20조 한정 할인 특가를 진행합니다.</strong>
                                            <span>올펀가구</span>
                                        </a>
                                    </div>
                                </li>
                            @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                @endif
                @if( count( $data['recommend'] ) > 0 )
                <div class="box overflow-hidden">
                    <div class="inner">
                        <div class="main_tit mb-10">
                            <h3>{{$data['info']->company_name}} 추천 상품</h3>
                        </div>
                        <div class="relative recommand_prod">
                            <div class="slide_box prod_slide">
                                <ul class="swiper-wrapper">
                                    @foreach( $data['recommend'] AS $r => $recommend )
                                    <li class="swiper-slide prod_item">
                                        <div class="img_box">
                                            <a href="/product/detail/{{$recommend->idx}}"><img src="{{$recommend->imgUrl}}" alt="{{$recommend->name}}"></a>
                                            <button class="zzim_btn prd_{{$recommend->idx}} {{ ($recommend->isInterest == 1) ? 'active' : '' }}" pidx="{{$recommend->idx}}"><svg><use xlink:href="/img/icon-defs.svg#zzim"></use></svg></button>
                                        </div>
                                        <div class="txt_box">
                                            <a href="/product/detail/{{$recommend->idx}}">
                                                <span>{{$data['info']->company_name}}</span>
                                                <p>{{$recommend->name}}</p>
                                                <b>
                                                    @if( $recommend->pay_type == 1 )
                                                        {{number_format( $recommend->price )}}원
                                                    @else
                                                        {{$recommend->pay_type_text}}
                                                    @endif
                                                </b>
                                            </a>
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                @if( count( $data['list'] ) > 0 )
                <div class="box">
                    <div class="inner">
                        <div class="sub_filter">
                            <div class="filter_box">
                                <button onclick="modalOpen('#filter_category-modal')">카테고리</button>
                                <button onclick="modalOpen('#filter_align-modal')">최신 상품 등록순</button>
                            </div>
                            <div class="total">전체 {{$data['list']->count()}}개</div>
                        </div>
                        <div class="relative">
                            <ul class="prod_list">
                                @foreach( $data['list'] AS $l => $list )
                                <li class="prod_item">
                                    <div class="img_box">
                                        <a href="/product/detail/{{$list->idx}}"><img src="{{$list->imgUrl}}" alt="{{$list->name}}"></a>
                                        <button class="zzim_btn prd_{{$list->idx}} {{ ($list->isInterest == 1) ? 'active' : '' }}" pidx="{{$list->idx}}"><svg><use xlink:href="/img/icon-defs.svg#zzim"></use></svg></button>
                                    </div>
                                    <div class="txt_box">
                                        <a href="/product/detail/{{$list->idx}}">
                                            <span>{{$data['info']->company_name}}</span>
                                            <p>{{$list->name}}</p>
                                            <b>
                                                @if( $list->pay_type == 1 )
                                                    {{number_format( $list->price )}}원
                                                @else
                                                    {{$list->pay_type_text}}
                                                @endif
                                            </b>
                                        </a>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>

                    </div>
                </div>
                @endif
            </div>

            <!-- 업체정보 -->
            <div class="detail">
                <div class="inner">
                    <div class="info">
                        <table>
                            <colgroup>
                                <col width="100px">
                                <col width="*">
                            </colgroup>
                            <tr>
                                <th>대표자</th>
                                <td>{{$data['info']->owner_name}}</td>
                            </tr>
                            <tr>
                                <th>대표전화</th>
                                <td>{{$data['info']->phone_number}}</td>
                            </tr>
                            <tr>
                                <th>근무일</th>
                                <td>{{$data['info']->work_day}}</td>
                            </tr>
                            <tr>
                                <th>발주방법</th>
                                <td>{{$data['info']->how_order}}</td>
                            </tr>
                            <tr>
                                <th>담당자</th>
                                <td>{{$data['info']->manager}}</td>
                            </tr>
                            <tr>
                                <th>담당자연락처</th>
                                <td>{{$data['info']->manager_number}}</td>
                            </tr>
                            <tr>
                                <th>웹사이트</th>
                                <td colspan="3"><a @if(strpos($data['info']->website, 'http') !== false) href="{{$data['info']->website}}" target="_blank" @endif>{{$data['info']->website}}</a></td>
                            </tr>
                            <tr>
                                <th>주소</th>
                                <td colspan="3">{{$data['info']->business_address .' '.$data['info']->business_address}}</td>
                            </tr>
                        </table>
                    </div>
                    <?php echo str_replace('\"', '', html_entity_decode($data['info']->introduce)); ?>
                </div>
            </div>

        </div>
    </div>
    <!-- 업체 전화번호 모달 -->
    <div class="modal" id="company_phone-modal">
        <div class="modal_bg" onclick="modalClose('#company_phone-modal')"></div>
        <div class="modal_inner modal-md">
            <button class="close_btn" onclick="modalClose('#company_phone-modal')"><svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#Close"></use></svg></button>
            <div class="modal_body company_phone_modal">
                <h4><b>업체</b> 전화번호</h4>
                <table>
                    <tr>
                        <th>업체명</th>
                        <td>{{$data['info']->company_name}}</td>
                    </tr>
                    <tr>
                        <th>전화번호</th>
                        <td><b>{{$data['info']->phone_number}}</b></td>
                    </tr>
                </table>
                <button class="btn btn-primary w-full" onclick="modalClose('#company_phone-modal')">확인</button>
            </div>
        </div>
    </div>
</div>


<script>
    var isProc = false;
    // 상단공지사항
    $('.notice_box dt').on('click',function(){
        $(this).parents('dl').toggleClass('active').siblings().removeClass('active')
    })

    // 판매상품 / 업체 정보 탭
    $('.community_tab li').on('click',function(){
        let liN = $(this).index();

        $(this).addClass('active').siblings().removeClass('active')
        $('.tab_content > div').eq(liN).addClass('active').siblings().removeClass('active')
    })

    // recommand_prod
    const recommand_prod = new Swiper(".recommand_prod .slide_box", {
        slidesPerView: 'auto',
        spaceBetween: 8,

    });

    /*const companyLike = (item)=>{
        $(item).toggleClass('active')
    }*/

    // 좋아요
    function addLike(idx) {
        if (isProc) {
            return;
        }
        isProc = true;

        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url             : '/wholesaler/like/'+idx,
            enctype         : 'multipart/form-data',
            processData     : false,
            contentType     : false,
            data			: {},
            type			: 'POST',
            success: function (result) {
                if (result.success) {
                    if (result.like == 0) {
                        $('.addLike.active').removeClass('active');
                    } else {
                        $('.addLike').addClass('active');
                    }
                } else {
                    alert(reslult.message);
                }

                isProc = false;
            }
        });
    }
</script>
@endsection