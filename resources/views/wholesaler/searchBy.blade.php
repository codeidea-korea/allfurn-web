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
                        <li><a href="/product/search?kw={{$_GET['kw']}}">상품</a></li>
                        <li class="active"><a href="javascript:void(0);">업체</a></li>
                    </ul>
                </div>
                <div class="sub_filter">
                    <div class="filter_box">
                        <button class="" onclick="modalOpen('#filter_category-modal')">카테고리 <b class="txt-primary"></b></button>
                        <button class="" onclick="modalOpen('#filter_location-modal')">소재지 <b class="txt-primary"></b></button>
                    </div>
                </div>
                <div class="sub_filter_result hidden">
                    <div class="filter_on_box">
                        <div class="category">
                            <span>소파/거실 <button onclick="filterRemove(this)"><svg><use xlink:href="/img/icon-defs.svg#x"></use></svg></button></span>
                            <span>식탁/의자 <button onclick="filterRemove(this)"><svg><use xlink:href="/img/icon-defs.svg#x"></use></svg></button></span>
                            <span>수납/서랍장/옷장 <button onclick="filterRemove(this)"><svg><use xlink:href="/img/icon-defs.svg#x"></use></svg></button></span>
                        </div>
                        <div class="location">
                            <span>인천 <button onclick="filterRemove(this)"><svg><use xlink:href="/img/icon-defs.svg#x"></use></svg></button></span>
                            <span>광주 <button onclick="filterRemove(this)"><svg><use xlink:href="/img/icon-defs.svg#x"></use></svg></button></span>
                        </div>
                    </div>
                    <button class="refresh_btn">초기화 <svg><use xlink:href="./img/icon-defs.svg#refresh"></use></svg></button>
                </div>

                <div class="sub_filter mt-5">
                    <div class="total"><span>‘{{$_GET['kw']}}'</span> 검색 결과 총 {{number_format($data['list']->total())}}개의 도매업체</div>
                    <div class="filter_box">
                        <button onclick="modalOpen('#filter_align-modal02')">최신 상품 등록순</button>
                    </div>
                </div>
                @if( $data['list']->total() > 0 )
                <ul class="obtain_list">
                    @foreach($data['list'] as $item)
                    <li>
                        <div class="txt_box">
                            <div>
                                <a href="/wholesaler/detail/{{$item->companyIdx}}">
                                    <img src="/img/icon/crown.png" alt="">
                                    {{$item->companyName}}
                                    <svg><use xlink:href="/img/icon-defs.svg#more_icon"></use></svg>
                                </a>
                                <i>{{$item->location}}</i>
                                <div class="tag">
                                    @foreach( explode(',', $item->categoryName ) AS $cate )
                                    <span>{{$cate}}</span>
                                    @endforeach
                                </div>
                            </div>
                            <button class="zzim_btn {{ $item->isLike == 1 ? 'active' : '' }}" data-company-idx='{{$item->companyIdx}}' onclick="toggleCompanyLike({{$item->companyIdx}})"><svg><use xlink:href="/img/icon-defs.svg#zzim"></use></svg> 좋아요</button>
                        </div>
                        <div class="prod_box">
                            @foreach($item->imgList as $i => $img)
                                @php if( $i > 2 ) continue; @endphp
                            <div class="img_box">
                                <a href="/product/detail/{{$img->idx}}"><img src="{{$img->imgUrl}}" alt=""></a>
                                <button class="zzim_btn prd_{{ $img->idx }} {{ ($img->isInterest == 1) ? 'active' : '' }}" pidx="{{ $img->idx }}"><svg><use xlink:href="/img/icon-defs.svg#zzim"></use></svg></button>
                            </div>
                            @endforeach
                        </div>
                    </li>
                    @endforeach
                </ul>
                @endif
            </div>
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

        function toggleCompanyLike(idx) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url : '/wholesaler/like/' + idx,
                method: 'POST',
                success : function(result) {
                    if (result.success) {
                        if (result.like === 0) {
                            $('.zzim_btn[data-company-idx='+idx+']').removeClass('active');
                        } else {
                            $('.zzim_btn[data-company-idx='+idx+']').addClass('active');
                        }
                    }
                }
            })
        }

    </script>


@endsection
