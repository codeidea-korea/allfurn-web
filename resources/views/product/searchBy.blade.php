@extends('layouts.app')

@section('content')
@include('layouts.header')
    <div id="content">
        <section class="sub">
            <div class="inner">
                <div class="main_tit mb-8 flex justify-between items-center">
                    <div class="flex items-center gap-4">
                        <h3><span class="font-base">‘{{$_GET['kw']}}'</span>검색결과</h3>
                    </div>
                </div>
                <div class="sub_category">
                    <ul>
                        <li class="active"><a href="./full_results_prod.php">상품</a></li>
                        <li><a href="/wholesaler/search?kw={{$_GET['kw']}}">업체</a></li>
                    </ul>
                </div>
                <div class="flex items-center gap-2">
                    <div>
                        <a href="javascript:;" class="h-[48px] px-3 border rounded-sm inline-block filter_border filter_dropdown w-[250px] flex justify-between items-center">
                            <p>카테고리</p>
                            <svg class="w-6 h-6 filter_arrow"><use xlink:href="/img/icon-defs.svg#drop_b_arrow"></use></svg>
                        </a>
                        <div class="full_search filter_dropdown_wrap w-[360px]" style="display: none;">
                            <div class="category_list" style="display: block;">
                                <ul>
                                    <li>
                                        <a href="javascript:;">
                                            <i><img class="category__ico" src="https://allfurn-prod-s3-bucket.s3.ap-northeast-2.amazonaws.com/product/65eb364492edcb02df94fb038753c10868ecf25416b2963ce8bf92c626b7eed2.png"></i>
                                            <span>침대/매트리스</span>
                                        </a>
                                        <ul class="depth2">
                                            <li><a href="javascript:;">침대프레임</a></li>
                                            <li><a href="javascript:;">스프링매트리스</a></li>
                                            <li><a href="javascript:;">폼매트리스</a></li>
                                            <li><a href="javascript:;">기능성매트리스</a></li>
                                            <li><a href="javascript:;">협탁</a></li>
                                            <li><a href="javascript:;">돌침대/흙침대</a></li>
                                            <li><a href="javascript:;">기타기능성침대</a></li>
                                            <li><a href="javascript:;">라텍스매트리스</a></li>
                                            <li><a href="javascript:;">토퍼</a></li>
                                            <li><a href="javascript:;">베개/커버</a></li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                            <i><svg><use xlink:href="/img/icon-defs.svg#category_sofa"></use></svg></i>
                                            <span>소파/거실</span>
                                        </a>
                                        <ul class="depth2">
                                            <li><a href="javascript:;">가죽소파</a></li>
                                            <li><a href="javascript:;">인조가죽소파</a></li>
                                            <li><a href="javascript:;">일반패브릭소파</a></li>
                                            <li><a href="javascript:;">기능성패브릭소파</a></li>
                                            <li><a href="javascript:;">리클라이너 소파</a></li>
                                            <li><a href="javascript:;">1인용 소파</a></li>
                                            <li><a href="javascript:;">1인용 리클라이너</a></li>
                                            <li><a href="javascript:;">소파베드</a></li>
                                            <li><a href="javascript:;">좌식소파</a></li>
                                            <li><a href="javascript:;">소파테이블</a></li>
                                            <li><a href="javascript:;">거실장</a></li>
                                            <li><a href="javascript:;">TV스탠드</a></li>
                                            <li><a href="javascript:;">돌소파/흙소파</a></li>
                                            <li><a href="javascript:;">기타</a></li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                            <i><svg><use xlink:href="/img/icon-defs.svg#category_table"></use></svg></i>
                                            <span>식탁/의자</span>
                                        </a>
                                        <ul class="depth2">
                                            <li><a href="javascript:;">우드 식탁</a></li>
                                            <li><a href="javascript:;">세라믹 식탁</a></li>
                                            <li><a href="javascript:;">대리석 식탁</a></li>
                                            <li><a href="javascript:;">기타소재 식탁</a></li>
                                            <li><a href="javascript:;">식탁의자</a></li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                            <i><svg><use xlink:href="/img/icon-defs.svg#category_closet"></use></svg></i>
                                            <span>옷장</span>
                                        </a>
                                        <ul class="depth2">
                                            <li><a href="javascript:;">장롱</a></li>
                                            <li><a href="javascript:;">붙박이장</a></li>
                                            <li><a href="javascript:;">드레스룸</a></li>
                                            <li><a href="javascript:;">캐비닛</a></li>
                                            <li><a href="javascript:;">서랍장</a></li>
                                            <li><a href="javascript:;">수납장</a></li>
                                            <li><a href="javascript:;">행거</a></li>
                                            <li><a href="javascript:;">주방수납장</a></li>
                                            <li><a href="javascript:;">진열장</a></li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                            <i><svg><use xlink:href="/img/icon-defs.svg#category_study"></use></svg></i>
                                            <span>서재/공부방</span>
                                        </a>
                                        <ul class="depth2">
                                            <li><a href="javascript:;">책상</a></li>
                                            <li><a href="javascript:;">의자</a></li>
                                            <li><a href="javascript:;">책장/책꽂이</a></li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                            <i><svg><use xlink:href="/img/icon-defs.svg#category_dressing"></use></svg></i>
                                            <span>화장대/콘솔</span>
                                        </a>
                                        <ul class="depth2">
                                            <li><a href="javascript:;">화장대</a></li>
                                            <li><a href="javascript:;">콘솔</a></li>
                                            <li><a href="javascript:;">전신거울</a></li>
                                            <li><a href="javascript:;">벽거울</a></li>
                                            <li><a href="javascript:;">탁상거울</a></li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                            <i><svg><use xlink:href="/img/icon-defs.svg#category_kids"></use></svg></i>
                                            <span>키즈/주니어</span>
                                        </a>
                                        <ul class="depth2">
                                            <li><a href="javascript:;">일반침대프레임</a></li>
                                            <li><a href="javascript:;">2층침대프레임</a></li>
                                            <li><a href="javascript:;">책상</a></li>
                                            <li><a href="javascript:;">의자</a></li>
                                            <li><a href="javascript:;">키즈소파</a></li>
                                            <li><a href="javascript:;">옷장</a></li>
                                            <li><a href="javascript:;">서랍/수납장</a></li>
                                            <li><a href="javascript:;">층간소음방지매트</a></li>
                                            <li><a href="javascript:;">놀이가구</a></li>
                                            <li><a href="javascript:;">안전문</a></li>
                                            <li><a href="javascript:;">책장/책꽂이</a></li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                            <i><svg><use xlink:href="/img/icon-defs.svg#category_display"></use></svg></i>
                                            <span>진열장/장식장</span>
                                        </a>
                                        <ul class="depth2">
                                            <li><a href="javascript:;">진열장/장식장</a></li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                            <i><svg><use xlink:href="/img/icon-defs.svg#category_office"></use></svg></i>
                                            <span>사무용가구</span>
                                        </a>
                                        <ul class="depth2">
                                            <li><a href="javascript:;">책상</a></li>
                                            <li><a href="javascript:;">의자</a></li>
                                            <li><a href="javascript:;">파티션/패널</a></li>
                                            <li><a href="javascript:;">책장/수납</a></li>
                                            <li><a href="javascript:;">소파</a></li>
                                            <li><a href="javascript:;">테이블</a></li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                            <i><img src="/img/main/obtain_icon.png" alt=""></i>
                                            <span>조달가구</span>
                                        </a>
                                        <ul class="depth2">
                                            <li><a href="javascript:;">사무용가구</a></li>
                                            <li><a href="javascript:;">중역용가구</a></li>
                                            <li><a href="javascript:;">교육용가구</a></li>
                                            <li><a href="javascript:;">사무용의자</a></li>
                                            <li><a href="javascript:;">사무용소파</a></li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                            <i><svg><use xlink:href="/img/icon-defs.svg#category_business"></use></svg></i>
                                            <span>업소용가구</span>
                                        </a>
                                        <ul class="depth2">
                                            <li><a href="javascript:;">테이블</a></li>
                                            <li><a href="javascript:;">의자</a></li>
                                            <li><a href="javascript:;">주문가구</a></li>
                                            <li><a href="javascript:;">기타</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <button class="flex items-center gap-1 h-[48px] px-3 border rounded-sm inline-block filter_border">
                        <svg class="h-4 w-4 text-stone-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-rotate-ccw"><path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/><path d="M3 3v5h5"/></svg>
                        <span>초기화</span>
                    </button>
                </div>

                <div class="sub_filter mt-5">
                    <div class="total"><span>‘{{$_GET['kw']}}'</span> 검색 결과 총 {{number_format($productList['list']->total())}}개의 상품</div>
                    <div class="filter_box">
                        <button onclick="modalOpen('#filter_align-modal02')">신상품순</button>
                    </div>
                </div>
                @if($productList['list']->total() > 0)
                <div class="relative">
                    <ul class="prod_list">
                        @foreach($productList['list'] as $item)
                        <li class="prod_item">
                            <div class="img_box">
                                <a href="/product/detail/{{$item->idx}}"><img src="{{$item->imgUrl}}" alt="{{$item->name}}"></a>
                                <button class="zzim_btn"><svg><use xlink:href="/img/icon-defs.svg#zzim"></use></svg></button>
                            </div>
                            <div class="txt_box">
                                <a href="./prod_detail.php">
                                    <span>{{$item->companyName}}</span>
                                    <p>{{$item->name}}</p>
                                    <b>
                                        @if( $item->is_price_open == 1 )
                                            {{number_format( $item->price )}}원
                                        @else
                                            {{$item->price_text}}
                                        @endif
                                    </b>
                                </a>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif
        </section>
    </div>

    <script>
        // 카테고리 클릭시
        $('.sub_category li').on('click',function(){
            $(this).addClass('active').siblings().removeClass('active')
        })

        // 속성 선택시
        $('.sub_option .dropdown_btn').on('click',function(){
            $(this).toggleClass('active')
            $(this).parent('.sub_option').toggleClass('active')
        })

        // 드롭다운 토글
        $(".filter_dropdown").click(function(event) {
            var $thisDropdown = $(this).next(".filter_dropdown_wrap");
            $(this).toggleClass('active');
            $thisDropdown.toggle();
            $(this).find("svg").toggleClass("active");
            event.stopPropagation(); // 이벤트 전파 방지
        });

        // 드롭다운 항목 선택 이벤트
        $(".filter_dropdown_wrap ul li a").click(function(event) {
            var selectedText = $(this).text();
            var $dropdown = $(this).closest('.filter_dropdown_wrap').prev(".filter_dropdown");
            $dropdown.find("p").text(selectedText);
            $(this).closest(".filter_dropdown_wrap").hide();
            $dropdown.removeClass('active');
            $dropdown.find("svg").removeClass("active");

            // '직접 입력' 선택 시 direct_input_2 표시
            if ($(this).data('target') === "direct_input_2") {
                $('.direct_input_2').show();
            }
            // '소비자 직배 가능' 또는 '매장 배송' 선택 시 direct_input_2 숨김
            else if ($(this).hasClass('direct_input_2_hidden')) {
                $('.direct_input_2').hide();
            }
            // '무료' 또는 '착불' 선택 시 direct_input_2의 상태 변경 없음

            event.stopPropagation(); // 이벤트 전파 방지
        });


        // 드롭다운 영역 밖 클릭 시 드롭다운 닫기
        $(document).click(function(event) {
            if (!$(event.target).closest('.filter_dropdown, .filter_dropdown_wrap').length) {
                $('.filter_dropdown_wrap').hide();
                $('.filter_dropdown').removeClass('active');
                $('.filter_dropdown svg').removeClass("active");
            }
        });

        $('.guide_list a').click(function() {
            // 클릭된 항목의 data-target 값 가져오기
            var targetId = $(this).data('target');

            // 모든 가이드 내용 숨기기
            $('.guide_con').hide();

            // 해당하는 ID를 가진 가이드 내용만 보여주기
            $('#' + targetId).show();
        });

    </script>
@endsection
