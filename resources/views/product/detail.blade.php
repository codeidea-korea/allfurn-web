@extends('layouts.app')

@section('content')
    @include('layouts.header')
    <div id="content">
        <div class="prod_detail_top">
            <div class="inner">
                <div class="img_box">
                    <div class="left_thumb swiper-initialized swiper-vertical swiper-pointer-events swiper-backface-hidden swiper-thumbs">
                        <ul class="swiper-wrapper" id="swiper-wrapper-f6c110c827f43c9bc" aria-live="polite" style="transform: translate3d(0px, 0px, 0px);">
                            @foreach($data['detail']->attachment as $key=>$item)
                                @if($key < 8)

                                    <li class="swiper-slide swiper-slide-visible" role="group" aria-label="3 / 9" style="margin-bottom: 8px;">
                                        <img src="{{$item['imgUrl']}}" alt="{{$data['detail']->name}}">
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                        <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span></div>
                    <div class="big_thumb swiper-initialized swiper-horizontal swiper-pointer-events swiper-backface-hidden">
                        <ul class="swiper-wrapper" id="swiper-wrapper-92df3f73b1030c925" aria-live="polite" style="transform: translate3d(0px, 0px, 0px);">

                            @foreach($data['detail']->attachment as $key=>$item)
                                @if($key < 8)

                                    <li class="swiper-slide" role="group" aria-label="3 / 8" style="width: 528px;">
                                        <img src="{{$item['imgUrl']}}" alt="{{$data['detail']->name}}">
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                        <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span></div>
                </div>
                <div class="txt_box">
                    <div class="name">
                        @if( $data['detail']->diff <= 30 )
                            <div class="tag">
                                @if( $data['detail']->diff <= 30 )
                                    <span class="new">NEW</span>
                                @endif
                                <span class="event">이벤트</span>
                            </div>
                        @endif
                        <h4>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</h4>
                    </div>
                    <div class="info">
                        <p>업체 문의</p>
                        <hr>
                        <div class="company_info">
                            <b>{{$data['detail']->companyName}}</b>
                            <a href="/wholesaler/detail/{{$data['detail']->company_idx}}" class="txt-gray">업체 보러가기 <svg><use xlink:href="/img/icon-defs.svg#more_icon"></use></svg></a>
                        </div>
                        <div class="link_box">
                            <button class="btn btn-line4 nohover zzim_btn prd_{{$data['detail']->idx}} {{ ($data['detail']->isInterest == 1) ? 'active' : '' }}" pidx="{{$data['detail']->idx}}"><svg><use xlink:href="/img/icon-defs.svg#zzim"></use></svg>좋아요</button>
                            <button class="btn btn-line4 nohover" onclick="copyUrl()"><svg><use xlink:href="/img/icon-defs.svg#share"></use></svg>공유하기</button>
                            <button class="btn btn-line4 nohover inquiry"><svg><use xlink:href="/img/icon-defs.svg#inquiry"></use></svg>문의 하기</button>
                        </div>
                    </div>
                    <div class="btn_box">
                        <button class="btn btn-primary-line phone" onclick="modalOpen('#company_phone-modal')"><svg class="w-5 h-5"><use xlink:href="/img/icon-defs.svg#phone"></use></svg>전화번호 확인하기</button>
                        <button class="btn btn-primary"><svg class="w-5 h-5"><use xlink:href="/img/icon-defs.svg#estimate"></use></svg>견적서 받기</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="prod_detail">
            <div class="info_quick">
                <a href="./company_detail.php" class="btn btn-line4 nohover com_link txt-gray">업체 보러가기 <svg><use xlink:href="/img/icon-defs.svg#more_icon"></use></svg></a>
                <div class="flex gap-2 my-3">
                    <button class="btn btn-line4 nohover zzim_btn"><svg><use xlink:href="/img/icon-defs.svg#zzim"></use></svg>좋아요</button>
                    <button class="btn btn-line4 nohover"><svg><use xlink:href="/img/icon-defs.svg#share"></use></svg>공유하기</button>
                </div>
                <button class="btn btn-line4 nohover inquiry"><svg><use xlink:href="/img/icon-defs.svg#inquiry"></use></svg>문의하기</button>

                <button class="btn btn-primary estimate"><svg class="w-5 h-5"><use xlink:href="/img/icon-defs.svg#estimate"></use></svg>견적서 받기</button>
            </div>
            <div class="inner">
                <?php echo str_replace('\"', '', str_replace('width: 300px;', 'width: fit-content;',html_entity_decode($data['detail']->product_detail))); ?>
            </div>
        </div>
    </div>


    <!-- 공유 팝업 -->
    <div class="modal" id="alert-modal">
        <div class="modal_bg" onclick="modalClose('#alert-modal')"></div>
        <div class="modal_inner modal-md">
            <button class="close_btn" onclick="modalClose('#alert-modal')"><svg class="w-11 h-11"><use xlink:href="/img/icon-defs.svg#Close"></use></svg></button>
            <div class="modal_body company_phone_modal">
                <h4>링크가 복사되었습니다.</h4><br />
                <button class="btn btn-primary w-full" onclick="modalClose('#alert-modal')">확인</button>
            </div>
        </div>
    </div>

    <!-- 업체 전화번호 모달 -->
    <div class="modal" id="company_phone-modal">
        <div class="modal_bg" onclick="modalClose('#company_phone-modal')"></div>
        <div class="modal_inner modal-md">
            <button class="close_btn" onclick="modalClose('#company_phone-modal')"><svg class="w-11 h-11"><use xlink:href="/img/icon-defs.svg#Close"></use></svg></button>
            <div class="modal_body company_phone_modal">
                <h4><b>업체</b> 전화번호</h4>
                <table>
                    <tbody><tr>
                        <th>업체명</th>
                        <td>{{$data['detail']->companyName}}</td>
                    </tr>
                    <tr>
                        <th>전화번호</th>
                        <td><b>{{$data['detail']->companyPhoneNumber}}</b></td>
                    </tr>
                    </tbody></table>
                <button class="btn btn-primary w-full" onclick="modalClose('#company_phone-modal')">확인</button>
            </div>
        </div>
    </div>
    <script type="text/javascript">

        const detail_thumb_list = new Swiper(".prod_detail_top .left_thumb", {
            slidesPerView: 'auto',
            direction: "vertical",
            spaceBetween: 8,
        });

        // thismonth_con01
        const detail_thumb = new Swiper(".prod_detail_top .big_thumb", {
            slidesPerView: 1,
            spaceBetween: 0,
            thumbs: {
                swiper: detail_thumb_list,
            },
        });

        $(window).on('scroll load',function(e){
            let detailTop = $('.prod_detail').offset().top;
            let winH = $(window).height();

            if(e.currentTarget.scrollY > (detailTop - (winH/2))){
                $('.prod_detail .info_quick').addClass('active')
            }else{
                $('.prod_detail .info_quick').removeClass('active')
            }
        })
        
        function copyUrl() {
            var dummy   = document.createElement("input");
            var text    = location.href;

            document.body.appendChild(dummy);
            dummy.value = text;
            dummy.select();
            document.execCommand("copy");
            document.body.removeChild(dummy);

            modalOpen('#alert-modal')
        }
    </script>
@endsection
