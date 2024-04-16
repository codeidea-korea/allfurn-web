@extends('layouts.app')

@section('content')
@include('layouts.header')
<div id="content">
    <section class="sub_section sub_section_top thismonth_detail">
        <div class="inner">
            @if( count( $dealbrand ) > 0 )
            <div class="relative popular_prod type02">
                <div class="slide_box overflow-hidden">
                    @foreach( $dealbrand AS $key => $brand )
                    <div class="detail_box">
                        <ul class="">
                            <li class="popular_banner">
                                <img src="{{$brand->mainImgUrl}}" class="h-[716px]" alt="{{$brand->company_name}}">
                                <div class="txt_box">
                                    <p>
                                        <b>{{$brand->subtext1}}</b><br/>
                                        {{$brand->subtext2}}
                                    </p>
                                    <a href="/wholesaler/detail/{{$brand->company_idx}}"><b>{{$brand->company_name}} </b> 홈페이지 가기</a>
                                </div>
                            </li>
                            <?php $prd_info = json_decode($brand->product_info);?>
                            @foreach( $prd_info AS $i => $info )
                            <li class="prod_item">
                                <div class="img_box">
                                    <a href="/product/detail/{{$info->mdp_gidx}}"><img src="{{$info->mdp_gimg}}" alt="{{$info->mdp_gname}}"></a>
                                    <button class="zzim_btn prd_{{$info->mdp_gidx}} {{ ($brand->isInterest[$info->mdp_gidx] == 1) ? 'active' : '' }}" pIdx="{{$info->mdp_gidx}}"><svg><use xlink:href="/img/icon-defs.svg#zzim"></use></svg></button>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                        <div class="bot_btn">
                            <button class="zoom_btn flex items-center gap-1" data-company_idx="{{$brand->company_idx}}"><svg><use xlink:href="/img/icon-defs.svg#zoom"></use></svg>확대보기</button>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </section>
</div>
<!-- 확대보기 -->
<div class="modal" id="zoom_view-modal">
    <div class="modal_bg" onclick="modalClose('#zoom_view-modal')"></div>
    <div class="modal_inner modal-lg zoom_view_wrap">
        <div class="count_pager dark_type"><b>1</b> / 12</div>
        <button class="close_btn" onclick="modalClose('#zoom_view-modal')"><svg class="w-11 h-11"><use xlink:href="/img/icon-defs.svg#Close"></use></svg></button>
        <div class="modal_body">
            <div class="slide_box zoom_prod_list">
                <ul class="swiper-wrapper">
                    <li class="swiper-slide">
                        <div class="img_box">
                            <img src="/img/zoom_thumb.png" alt="">
                            <button class="zzim_btn"><svg><use xlink:href="/img/icon-defs.svg#zzim"></use></svg></button>
                        </div>
                        <div class="txt_box">
                            <div>
                                <h5>올펀가구</h5>
                                <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                <b>112,500원</b>
                            </div>
                            <a href="./prod_detail.php">제품상세보기</a>
                        </div>
                    </li>
                    <li class="swiper-slide">
                        <div class="img_box">
                            <img src="/img/zoom_thumb.png" alt="">
                            <button class="zzim_btn"><svg><use xlink:href="/img/icon-defs.svg#zzim"></use></svg></button>
                        </div>
                        <div class="txt_box">
                            <div>
                                <h5>올펀가구</h5>
                                <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                <b>112,500원</b>
                            </div>
                            <a href="./prod_detail.php">제품상세보기</a>
                        </div>
                    </li>
                    <li class="swiper-slide">
                        <div class="img_box">
                            <img src="/img/zoom_thumb.png" alt="">
                            <button class="zzim_btn"><svg><use xlink:href="/img/icon-defs.svg#zzim"></use></svg></button>
                        </div>
                        <div class="txt_box">
                            <div>
                                <h5>올펀가구</h5>
                                <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                <b>112,500원</b>
                            </div>
                            <a href="./prod_detail.php">제품상세보기</a>
                        </div>
                    </li>
                </ul>
            </div>
            <button class="slide_arrow prev type03"><svg><use xlink:href="/img/icon-defs.svg#slide_arrow_white"></use></svg></button>
            <button class="slide_arrow next type03"><svg><use xlink:href="/img/icon-defs.svg#slide_arrow_white"></use></svg></button>
        </div>
    </div>
</div>
<script type="text/javascript">
    // zoom_prod_list
    function zoomStart() {
        const zoom_prod_list = new Swiper(".zoom_prod_list", {
            slidesPerView: 1,
            spaceBetween: 120,
            navigation: {
                nextEl: ".zoom_view_wrap .slide_arrow.next",
                prevEl: ".zoom_view_wrap .slide_arrow.prev",
            },
            pagination: {
                el: ".zoom_view_wrap .count_pager",
                type: "fraction",
            },
        });
    }

    $(document)
        .on('click', '.zoom_btn', function() {
            var company_idx = $(this).data('company_idx');
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type : "GET",
                url : "/product/thisMonthDetail",
                data : {
                    'cIdx' : company_idx
                },
                success : function(res){
                    console.log( res );
                    $('#zoom_view-modal .zoom_prod_list > ul').empty().html(res);
                    zoomStart();
                    modalOpen('#zoom_view-modal')
                },
                error : function(XMLHttpRequest, textStatus, errorThrown){
                    alert("통신 실패.")
                }
            });
        })
    ;
</script>
@endsection
