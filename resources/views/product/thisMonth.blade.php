@extends('layouts.master')

@section('header')
    @include('layouts.header.main-header')
@endsection

@section('content')
    <div id="container" class="container" style="margin-bottom: -40px;">
        <div class="inner">
            <div class="content wholesaler__best">
                <!-- 상품 광고 -->
                @if((count($data['product_4']) + count($data['product_6'])) > 0)
                    <div class="wholesaler__best__product">
                        <h2>{{date("m")}}월의 Best 상품</h2>
                        <ul class="product__list--flex4">
                            @foreach($data['product_4'] as $item)
                                <li>
                                    <a href="/product/detail/{{$item->idx}}" target="_blank" title="{{$item->name}} 상세 페이지 이동">
                                        <div class="best__product-img">
                                            <img src="{{$item->imgUrl}}" alt="item01" style="object-fit:cover;">
                                            <p class="best__product-badge">{{$item->companyName}}</p>
                                        </div>
                                        <p class="best__product-text">{{$item->name}}</p>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                        <ul class="product__list--flex6">
                            @foreach($data['product_6'] as $item)
                                <li style="margin-right: 10px">
                                    <a href="/product/detail/{{$item->idx}}" target="_blank" title="{{$item->name}} 상세 페이지 이동">
                                        <div class="best__product-img">
                                            <img src="{{$item->imgUrl}}" alt="img_best01" style="object-fit:cover;">
                                        </div>
                                        <h4>{{$item->companyName}}</h4>
                                        <p>{{$item->name}}</p>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <!-- 배너 광고 -->
                @if(count($data['banner']) > 0)
                    <div class="wholesaler__best__banner">
                        <h2>{{date("m")}}월의 Best 도매상</h2>
                        <ul>
                            @foreach($data['banner'] as $key=>$item)
                                @if($item->attachment != null) 
                                <li>
                                    <?php
                                        $link = '';
                                        switch ($item->web_link_type) {
                                            case 0: //Url
                                                $link = $item->web_link;
                                                break;
                                            case 1: //상품
                                                $link = $item->web_link;
                                                break;
                                            case 2: //업체
                                                $link = $item->web_link;
                                                break;
                                            case 3: //커뮤니티
                                                $link = $item->web_link;
                                                break;
                                            default: //공지사항
                                                $link = '/help/notice/';
                                                break;
                                        }
                                    ?>
                                    <a href="{{$link}}" target="_blank" title="{{$item->name}} 상세 페이지 이동">
                                        <img src="{{preImgUrl().$item->attachment->folder}}/{{$item->attachment->filename}}" alt="wsc_img0{{$key}}">
                                    </a>
                                </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- 키워드 광고 -->
                @if(count($data['keyword']) > 0)
                    <div class="wholesaler__best__keyword">
                        <h2>{{date("m")}}월의 Best 키워드</h2>
                        <ul>
                            @foreach($data['keyword'] as $item)
                                <?php
                                    $link = '';
                                    switch ($item->web_link_type) {
                                        case 0: //Url
                                            $link = $item->web_link;
                                            break;
                                        case 1: //상품
                                            $link = $item->web_link;
                                            break;
                                        case 2: //업체
                                            $link = $item->web_link;
                                            break;
                                        case 3: //커뮤니티
                                            $link = $item->web_link;
                                            break;
                                        default: //공지사항
                                            $link = '/help/notice/';
                                            break;
                                    }
                                ?>
                                <li onclick="location.href='{{$link}}'">
                                    <span>#</span>
                                    <p>{{$item->keyword_name}}</p>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>

    </script>
@endsection
