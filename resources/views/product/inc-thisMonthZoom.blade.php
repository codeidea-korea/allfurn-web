@if( !empty( $zoomData ) )
<?php $items = json_decode( $zoomData->product_info ); ?>
@foreach( $items AS $key => $item )
<li class="swiper-slide">
    <div class="img_box">
        <img src="{{$item->mdp_gimg}}" alt="{{$item->mdp_gname}}">
        <button class="zzim_btn prd_{{$item->mdp_gidx}} {{ ($zoomData->isInterest[$item->mdp_gidx] == 1) ? 'active' : '' }}" pIdx="{{$item->mdp_gidx}}"><svg><use xlink:href="./pc/img/icon-defs.svg#zzim"></use></svg></button>
    </div>
    <div class="txt_box">
        <div>
            <h5>{{$zoomData->company_name}}</h5>
            <p>{{$item->mdp_gname}}</p>
            <b>{{number_format( $item->mdp_gprice )}}원</b>
        </div>
        <a href="/product/detail/{{$item->mdp_gidx}}">제품상세보기</a>
    </div>
</li>
@endforeach
@endif