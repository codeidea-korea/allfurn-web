@extends('layouts.app')

@section('content')
@include('layouts.header')

<div id=content>
    <section class="sub_section wholesaler_con03">
        
        <div class="inner">
            <div class="main_tit mb-8 flex justify-between items-center">
                <div class="flex items-center gap-4">
                    <h3>이달의 도매</h3>
                </div>
            </div>
        </div>

        <div class="inner">
            <ul class="obtain_list">
                @if((count($wholesalerList) > 0) )
                    @foreach ($wholesalerList as $wholesaler)
                        <li>
                            <div class="txt_box">
                                <div>
                                    <a href="javascript:detailGo({{ $wholesaler->company_idx }})">
                                        @if($loop->index<20)
                                            <img src="/img/icon/crown.png" alt="">
                                        @endif
                                        {{ $wholesaler->company_name }}
                                        <svg><use xlink:href="/img/icon-defs.svg#more_icon"></use></svg>
                                    </a>
                                    <i>{{ $wholesaler->location }}</i>
                                    <div class="tag">
                                        @foreach ( $wholesaler->categoryList as $category )
                                            <span>{{ $category->name }}</span>
                                        @endforeach
                                    </div>
                                </div>
                                <button class="zzim_btn {{ $wholesaler->isCompanyInterest == 1 ? 'active' : '' }}" data-company-idx='{{$wholesaler->company_idx}}' onclick="toggleCompanyLike({{$wholesaler->company_idx}})"><svg><use xlink:href="/img/icon-defs.svg#zzim"></use></svg> 좋아요</button>
                            </div>
                            <div class="prod_box">
                                @foreach ($wholesaler->productList as $product)
                                    <div class="img_box">
                                        <a href="/product/detail/{{ $product->productIdx }}"><img src="{{ $product->imgUrl }}" alt=""></a>
                                        <button class="zzim_btn prd_{{ $product->productIdx }} {{ $product->isInterest == 1 ? 'active' : '' }}" pidx="{{ $product->productIdx }}"><svg><use xlink:href="/img/icon-defs.svg#zzim"></use></svg></button>
                                    </div>
                                @endforeach
                            </div>
                        </li>
                    @endforeach
                @else
                    데이터가 없습니다.
                @endif
            </ul>
        </div>

    </section>
</div>
<script>
    function detailGo(idx){
        $('#loadingContainer').show();
        location.href = '/wholesaler/detail/'+idx;
    }
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
