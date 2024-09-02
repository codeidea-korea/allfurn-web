{{--
<li class="prod_item">
    <div class="img_box">
        <a href="javascript:;"><img src="{{ env('APP_URL') }}/img/prod_thumb.png" alt=""></a>
        <button class="zzim_btn"><svg><use xlink:href="{{ env('APP_URL') }}/img/icon-defs.svg#zzim"></use></svg></button>
    </div>
    <div class="txt_box">
        <a href="javascript:;">
            <span>(주)핀란디아</span>
            <p>핀란디아 오로라월넛(도어)SS침대-서랍형</p>
            <b>업체 문의</b>
        </a>
    </div>
</li>
<li class="prod_item">
    <div class="img_box">
        <a href="javascript:;"><img src="{{ env('APP_URL') }}/img/prod_thumb.png" alt=""></a>
        <button class="zzim_btn"><svg><use xlink:href="{{ env('APP_URL') }}/img/icon-defs.svg#zzim"></use></svg></button>
    </div>
    <div class="txt_box">
        <a href="javascript:;">
            <span>(주)핀란디아</span>
            <p>핀란디아 오로라월넛(도어)SS침대-서랍형</p>
            <b>업체 문의</b>
        </a>
    </div>
</li>
<li class="prod_item">
    <div class="img_box">
        <a href="javascript:;"><img src="{{ env('APP_URL') }}/img/prod_thumb.png" alt=""></a>
        <button class="zzim_btn"><svg><use xlink:href="{{ env('APP_URL') }}/img/icon-defs.svg#zzim"></use></svg></button>
    </div>
    <div class="txt_box">
        <a href="javascript:;">
            <span>(주)핀란디아</span>
            <p>핀란디아 오로라월넛(도어)SS침대-서랍형</p>
            <b>업체 문의</b>
        </a>
    </div>
</li>
<li class="prod_item">
    <div class="img_box">
        <a href="javascript:;"><img src="{{ env('APP_URL') }}/img/prod_thumb.png" alt=""></a>
        <button class="zzim_btn"><svg><use xlink:href="{{ env('APP_URL') }}/img/icon-defs.svg#zzim"></use></svg></button>
    </div>
    <div class="txt_box">
        <a href="javascript:;">
            <span>(주)핀란디아</span>
            <p>핀란디아 오로라월넛(도어)SS침대-서랍형</p>
            <b>업체 문의</b>
        </a>
    </div>
</li>
<li class="prod_item">
    <div class="img_box">
        <a href="javascript:;"><img src="{{ env('APP_URL') }}/img/prod_thumb.png" alt=""></a>
        <button class="zzim_btn"><svg><use xlink:href="{{ env('APP_URL') }}/img/icon-defs.svg#zzim"></use></svg></button>
    </div>
    <div class="txt_box">
        <a href="javascript:;">
            <span>(주)핀란디아</span>
            <p>핀란디아 오로라월넛(도어)SS침대-서랍형</p>
            <b>업체 문의</b>
        </a>
    </div>
</li>
<li class="prod_item">
    <div class="img_box">
        <a href="javascript:;"><img src="{{ env('APP_URL') }}/img/prod_thumb.png" alt=""></a>
        <button class="zzim_btn"><svg><use xlink:href="{{ env('APP_URL') }}/img/icon-defs.svg#zzim"></use></svg></button>
    </div>
    <div class="txt_box">
        <a href="javascript:;">
            <span>(주)핀란디아</span>
            <p>핀란디아 오로라월넛(도어)SS침대-서랍형</p>
            <b>업체 문의</b>
        </a>
    </div>
</li>
--}}

@foreach ($list as $item )
    <li class="prod_item">
        <div class="img_box">
            <a href="javascript:saveDetail({{ $item->idx }})"><img src="{{ $item->imgUrl }}" alt=""></a>
            <!--
            <button class="zzim_btn prd_{{ $item->idx }} {{ ($item->isInterest == 1) ? 'active' : '' }}" pidx="{{ $item->idx }}"><svg><use xlink:href="/img/icon-defs.svg#zzim"></use></svg></button>
-->
        </div>
        <div class="txt_box">
            <a href="javascript:saveDetail({{ $item->idx }})">
                <span>{{$item->companyName}}</span>
                <p>{{ $item->name }}</p>
                <b>{{$item->is_price_open ? number_format($item->price, 0).'원': $item->price_text}}</b>
            </a>
        </div>
    </li>
<li class="prod_item">
    <div class="img_box">
        <a href="javascript:;"><img src="{{ env('APP_URL') }}/img/prod_thumb.png" alt=""></a>
        <!--
        <button class="zzim_btn"><svg><use xlink:href="{{ env('APP_URL') }}/img/icon-defs.svg#zzim"></use></svg></button>
-->
    </div>
    <div class="txt_box">
        <a href="javascript:;">
            <span>(주)핀란디아</span>
            <p>핀란디아 오로라월넛(도어)SS침대-서랍형</p>
            <b>업체 문의</b>
        </a>
    </div>
</li>
@endforeach