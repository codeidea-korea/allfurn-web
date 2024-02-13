@extends('layouts.master')

@section('header')
    @include('layouts.header.main-header')
@endsection

@section('content')
    <div id="container" class="container">
        <div class="inner">
            <div class="content">
                <div class="wholesaler__company">
                    <div class="company__info">
                        <div class="company__desc company__desc--type02">
                            <div class="company__img company__img--circle">
                                <img src="@if($data['info']->imgUrl != null) {{$data['info']->imgUrl}} @else /images/sub/thumbnail@2x.png @endif" alt="썸네일">
                            </div>
                            <div class="company__text-wrap">
                                <div class="company__name">
                                    <p class="name">{{$data['info']->company_name}}</p>
                                    @if($data['info']->isNew == 1)
                                        <p class="badge">NEW</p>
                                    @endif
                                </div>
                                <p class="company__location">{{$data['info']->business_address}}</p>
                                <ul>
                                    @foreach($data['category'] as $item)
                                        <li class="company__product">{{$item->name}}</li>
                                    @endforeach
                                </ul>
                                <ul class="company__count-wrap">
                                    <li>
                                        <p class="num">{{$data['info']->likeCnt()}}</p>
                                        <p class="text">좋아요 수</p>
                                    </li>
                                    <li>
                                        <p class="num">{{$data['info']->inquiryCnt}}</p>
                                        <p class="text">문의 수</p>
                                    </li>
                                    <li>
                                        <p class="num">{{$data['info']->visitCnt}}</p>
                                        <p class="text">방문 수</p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="company__right-wrap">
                            <div class="company__share" onclick="copyUrl()">
                                <i class="ico__share28"><span class="a11y">공유</span></i>
                                <p>공유</p>
                            </div>
                            <div class="company__like @if($data['info']->isLike > 0) active @endif " onclick="addLike({{$data['info']->idx}})">
                                <i class="like"><span class="a11y">좋아요</span></i>
                                <p>좋아요</p>
                            </div>
                        </div>

                        <!-- 공유 팝업 -->
                        <div id="alert-modal" class="alert-modal">
                            <div class="alert-modal__container">
                                <div class="alert-modal__top">
                                    <p>
                                        링크가 복사되었습니다.
                                    </p>
                                </div>
                                <div class="alert-modal__bottom">
                                    <button type="button" class="button button--solid" onclick="closeModal('#alert-modal')">
                                        확인
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab tab--type02" id="register-type">
                        <ul class="tab__list" role="tablist">
                            <li><button class="tab__item" role="tab" tabindex="0" aria-selected="true" id="tabs-1">업체 정보</button>
                            </li>
                            <li><button class="tab__item" role="tab" tabindex="-1" aria-selected="false" id="tabs-2">판매 상품</button>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-content__panel" aria-hidden="false" role="tabpanel" tabindex="0"
                                 aria-labelledby="tabs-1">
                                <div class="company__tab01">
                                    <?php echo str_replace('\"', '', html_entity_decode($data['info']->introduce)); ?>
                                    <div class="tab01__text-wrap">
                                        <dl>
                                            <dt>대표자</dt>
                                            <dd>{{$data['info']->owner_name}}</dd>
                                        </dl>
                                        @if($data['info']->business_address != '')
                                            <dl>
                                                <dt>주소</dt>
                                                <dd>{{$data['info']->business_address .' '.$data['info']->business_address}}</dd>
                                            </dl>
                                        @endif
                                        
                                        @if($data['info']->work_day != '')
                                            <dl>
                                                <dt>근무일</dt>
                                                <dd>{{$data['info']->work_day}}</dd>
                                            </dl>
                                        @endif
                                        
                                        @if($data['info']->business_email != '')
                                            <dl>
                                                <dt>이메일</dt>
                                                <dd>{{$data['info']->business_email}}</dd>
                                            </dl>
                                        @endif
                                        
                                        @if($data['info']->phone_number != '')
                                            <dl>
                                                <dt>대표 전화</dt>
                                                <dd>{{$data['info']->phone_number}}</dd>
                                            </dl>
                                        @endif
                                        @if($data['info']->manager != '')
                                        <dl>
                                            <dt>담당자</dt>
                                            <dd>{{$data['info']->manager}}</dd>
                                        </dl>
                                        @endif
                                        @if($data['info']->manager_number != '')
                                            <dl>
                                                <dt>담당자 연락처</dt>
                                                <dd>{{$data['info']->manager_number}}</dd>
                                            </dl>
                                        @endif
                                        
                                        @if($data['info']->fax != '')
                                            <dl>
                                                <dt>FAX</dt>
                                                <dd>{{$data['info']->fax}}</dd>
                                            </dl>
                                        @endif
                                        
                                        @if($data['info']->how_order != '')
                                            <dl>
                                                <dt>발주방법</dt>
                                                <dd>{{$data['info']->how_order}}</dd>
                                            </dl>
                                        @endif
                                        
                                        @if($data['info']->etc)
                                        <dl>
                                            <dt>기타</dt>
                                            <dd>{{ $data['info']->etc }}</dd>
                                        </dl>
                                        @endif
                                        
                                        @if($data['info']->website != '')
                                            <dl>
                                                <dt>웹사이트</dt>
                                                <dd>
                                                    <a @if(strpos($data['info']->website, 'http') !== false) href="{{$data['info']->website}}" target="_blank" @endif>{{$data['info']->website}}</a>
                                                </dd>
                                            </dl>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            <div class="tab-content__panel" aria-hidden="true" role="tabpanel" tabindex="-1"
                                 aria-labelledby="tabs-2">
                                <div class="company__tab02">
                                    @if($data['recommend']->count() > 0)
                                    <div class="product__text--wrap">
                                        <h2 class="product__title">{{$data['info']->company_name}} 추천 상품</h2>
                                    </div>
                                    <ul class="product-list product-list__detail">
                                        @foreach($data['recommend'] as $item)
                                            <li class="product-list__card" style="position: relative;">
                                                <div class="card__bookmark">
                                                    <i class="@if($item->isInterest > 0) ico__bookmark24--on @else ico__bookmark24--off @endif"><span class="a11y">스크랩 off</span></i>
                                                </div>
                                                <a href="/product/detail/{{$item->idx}}" title="{{$item->name}} 상세 화면으로 이동">
                                                    <div class="card__img--wrap">
                                                        <img class="card__img" src="{{$item->imgUrl}}" alt="{{$item->name}}">
                                                        @if($item->isAD > 0)
                                                            <div class="card__badge">AD</div>
                                                        @endif
                                                    </div>
                                                    <div class="card__text--wrap">
                                                        <p class="card__name">
                                                            @if($item->state == 'O')
                                                                (품절)
                                                            @endif
                                                            {{$item->name}}
                                                        </p>
                                                        <p class="card__price">
                                                            @if($item->is_price_open != 0)
                                                                <?php echo number_format($item->price, 0); ?>원
                                                            @else
                                                                {{$item->price_text}}
                                                            @endif
                                                        </p>
                                                    </div>
                                                </a>
                                                @if($item->is_new_product > 0)
                                                    <p class="badge">NEW</p>
                                                @endif
                                                @if($item->state == 'O')
                                                    <a class="dim" style="position:absolute;width:100%;height:100%;top:0;left:0;background-color: #ffffff80" href="/product/detail/{{$item->idx}}"></a>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                    @endif

                                    <div class="product__text--wrap" style="padding-top: 8px;">
                                        <p class="product__count">전체 {{$data['list']->total()}}개</p>

                                        <div class="category-btn category-btn--order" onclick="openModal('#default-modal')">
                                            <p class="category-btn__text">
                                                @if(isset($_GET['so']))
                                                    @switch($_GET['so'])
                                                        @case('search')
                                                            검색 많은 순
                                                            @break
                                                        @case('order')
                                                            주문 많은 순
                                                            @break
                                                        @default
                                                            신상품순
                                                            @break
                                                    @endswitch
                                                @else
                                                    신상품순
                                                @endif
                                            </p>
                                        </div>
                                    </div>

                                    <ul class="product-list wholesaler-list">
                                        @foreach($data['list'] as $item)
                                            <li class="product-list__card"  style="position: relative;">
                                                    <div class="card__bookmark">
                                                        <i class="@if($item->isInterest > 0) ico__bookmark24--on @else ico__bookmark24--off @endif" onclick="addInterestByList('{{$item->idx}}')" data-product_idx="{{$item->idx}}"><span class="a11y">북마크</span></i>
                                                    </div>
                                                <a href="/product/detail/{{$item->idx}}" title="{{$item->name}} 상세 화면으로 이동">
                                                    <div class="card__img--wrap">
                                                        <img class="card__img" src="{{$item->imgUrl}}" alt="{{$item->name}}" style="height:100%">
                                                    </div>
                                                    <div class="card__text--wrap">
                                                        <p class="card__name">{{$item->name}}</p>
                                                        <p class="card__price">
                                                            @if($item->is_price_open != 0)
                                                                <?php echo number_format($item->price, 0); ?>원
                                                            @else
                                                                {{$item->price_text}}
                                                            @endif
                                                        </p>
                                                    </div>
                                                </a>
                                                @if($item->is_new_product == 1)
                                                    <p class="badge">NEW</p>
                                                @endif
                                                @if($item->state == 'O')
                                                    <a class="dim" style="position:absolute;width:100%;height:100%;top:0;left:0;background-color: #ffffff80" href="/product/detail/{{$item->idx}}"></a>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>

                                    <div class="pagenation pagination--center mt0">
                                        {{ $data['list']->withQueryString()->links() }}
                                    </div>

                                    <!-- 신상품순 팝업 -->
                                    <div id="default-modal" class="default-modal default-modal--radio">
                                        <div class="default-modal__container">
                                            <div class="default-modal__header">
                                                <h2>정렬 선택</h2>
                                                <button type="button" class="ico__close28" onclick="closeModal('#default-modal')">
                                                    <span class="a11y">닫기</span>
                                                </button>
                                            </div>
                                            <div class="default-modal__content" style="height: 144px;">
                                                <ul class="content__list">
                                                    <li>
                                                        <label>
                                                            <input type="radio" name="order" class="checkbox__checked" data-sort="new" @if(!isset($_GET['so'])) checked @elseif($_GET['so'] == 'new') checked @endif>
                                                            <span>신상품순</span>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label>
                                                            <input type="radio" name="order" class="checkbox__checked" data-sort="search" @if(isset($_GET['so']) && $_GET['so'] == 'search') checked @endif>
                                                            <span>검색 많은 순</span>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label>
                                                            <input type="radio" name="order" class="checkbox__checked" data-sort="order" @if(isset($_GET['so']) && $_GET['so'] == 'order') checked @endif>
                                                            <span>주문 많은 순</span>
                                                        </label>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="default-modal__footer">
                                                <button type="button" class="button button--solid" onclick="sort()">선택 완료</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        var isProc = false;

        $(document).ready(function(){
            if (getUrlVars().includes('page')) {
                $('#tabs-2').click();
            }
            

            const searchParams = new URLSearchParams(location.search);
            
            if (getUrlVars().includes('tab')) {
                
                for (const param of searchParams) {
                    if ( param[0] === 'tab' ) {
                        if ( param[1] === '2' ) {
                            $('#tabs-2').click();
                        }
                    }
                }
     
            }
            
            
        });

        // 공유
        function copyUrl() {
            var dummy   = document.createElement("input");
            var text    = location.href;

            document.body.appendChild(dummy);
            dummy.value = text;
            dummy.select();
            document.execCommand("copy");
            document.body.removeChild(dummy);

            openModal('#alert-modal')
        }

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
                            $('.company__like.active').removeClass('active');
                        } else {
                            $('.company__like').addClass('active');
                        }
                    } else {
                        alert(reslult.message);
                    }

                    isProc = false;
                }
            });
        }

        // 정렬
        function sort() {
            var query = "?tab=2&so="+$('input[name="order"]:checked').data('sort');
            closeModal('#default-modal');
            location.replace('/wholesaler/detail/{{$data['info']->idx}}'+query);
        }
        

        function getUrlVars()
        {
            var vars = [], hash;
            var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
            for(var i = 0; i < hashes.length; i++)
            {
                hash = hashes[i].split('=');
                vars.push(hash[0]);
                vars[hash[0]] = hash[1];
            }
            return vars;
        }
    </script>
@endsection
