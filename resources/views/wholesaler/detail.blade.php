@extends('layouts.app')

@section('content')
    @include('layouts.header')
    <div id="content">
        <div class="company_detail_top">
            <div class="inner">
                <div class="banner" style="background-image:url('/img/company_banner.png')">
                    {{-- <div class="profile_img">
                        <img src="@if($data['info']->imgUrl != null) {{$data['info']->imgUrl}} @else /img/profile_img.svg @endif" alt="썸네일">
                        <!-- img src="/img/profile_img.svg" alt="" //-->
                    </div> --}}
                    <div class="profile_img" style="border:inherit!important; background:inherit!important;">
                        <img src="@if($data['info']->imgUrl != null) {{$data['info']->imgUrl}} @else /img/profile_img.svg @endif" alt="">
                    </div>
                    <div class="link_box">
                        <button class="addLike {{ ($data['info']->isLike == 1) ? 'active' : '' }}" onClick="addLike({{$data['info']->idx}});"><svg><use xlink:href="/img/icon-defs.svg#zzim"></use></svg></button>
                        <button onClick="copyUrl();"><svg><use xlink:href="/img/icon-defs.svg#share"></use></svg></button>
                    </div>
                </div>
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
                            <button class="btn btn-primary-line phone" onclick="modalOpen('#company_phone-modal')"><svg class="w-5 h-5"><use xlink:href="/img/icon-defs.svg#phone"></use></svg>전화번호 확인하기</button>
                            <button class="btn btn-primary" onClick="location.href='/message';"><svg class="w-5 h-5"><use xlink:href="/img/icon-defs.svg#inquiry_white"></use></svg>문의하기</button>
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
                            공휴일/ 토요일/ 일요일 휴무입니다.<br>
                            통화 부재 시 문자 남겨 주시면 전화드리겠습니다.
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="company_detail">
            <div class="inner">
                <div class="community_tab">
                    <ul>
                        <li class="active"><a href="javascript:;">판매 상품</a></li>
                        <li><a href="javascript:;">업체 정보</a></li>
                    </ul>
                </div>
            </div>
            <div class="tab_content">
                <!-- 판매상품 -->
                <div class="active">
                    <div class="box">
                        <div class="inner">
                            <div class="main_tit mb-10">
                                <h3>{{$data['info']->company_name}} 이벤트 상품</h3>
                            </div>
                            <div class="relative">
                                <!-- ul class="prod_list grid1 mb-14">
                                    <li class="prod_item type02">
                                        <div class="img_box">
                                            <a href="./prod_detail.php">
                                                <img src="/img/sale_thumb.png" alt="">
                                                <span><b>호텔같은 내 침실로!</b><br>#20조 한정 할인 특가 #호텔형 침대</span>
                                            </a>
                                            <button class="zzim_btn"><svg><use xlink:href="/img/icon-defs.svg#zzim"></use></svg></button>
                                        </div>
                                        <div class="txt_box">
                                            <a href="./prod_detail.php">
                                                <strong>내 침실을 휴향지 호텔 처럼!  20조 한정 할인 특가를 진행합니다.</strong>
                                                <span>{{$data['info']->company_name}}</span>
                                            </a>
                                        </div>
                                    </li>
                                </ul //-->
                                <ul class="prod_list">
                                    @foreach( $data['event'] AS $e => $event )
                                    <li class="prod_item">
                                        <div class="img_box">
                                            <a href="/product/detail/{{$event->idx}}"><img src="{{$event->imgUrl}}" alt=""></a>
                                            <button class="zzim_btn"><svg><use xlink:href="/img/icon-defs.svg#zzim"></use></svg></button>
                                        </div>
                                        <div class="txt_box">
                                            <a href="/product/detail/{{$event->idx}}">
                                                <span>{{$data['info']->company_name}}</span>
                                                <p>[자체제작]오크 원목 프리미엄 원형 테이블 우드 모던 미니테이블</p>
                                                <b>112,500원</b>
                                            </a>
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    @if($data['recommend']->count() > 0)
                    <div class="box">
                        <div class="inner">
                            <div class="main_tit mb-10">
                                <h3>{{$data['info']->company_name}} 추천 상품</h3>
                            </div>
                            <div class="relative">
                                <ul class="prod_list grid5">
                                    @foreach($data['recommend'] as $item)
                                    <li class="prod_item">
                                        <div class="img_box">
                                            <a href="/product/detail/{{$item->idx}}">
                                                <img class="card__img" src="{{$item->imgUrl}}" alt="{{$item->name}}">
                                            </a>
                                            <button class="zzim_btn"><svg><use xlink:href="/img/icon-defs.svg#zzim"></use></svg></button>
                                        </div>
                                        <div class="txt_box">
                                            <a href="/product/detail/{{$item->idx}}">
                                                <span>{{$data['info']->company_name}}</span>
                                                <p>{{$item->name}}</p>
                                                <b>
                                                    @if($item->is_price_open != 0)
                                                            <?php echo number_format($item->price, 0); ?>원
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
                    </div>
                    @endif;
                    <div class="box">
                        <div class="inner">
                            <div class="sub_filter">
                                <div class="filter_box">
                                    <button onclick="modalOpen('#filter_category-modal')">카테고리</button>
                                    <button onclick="modalOpen('#filter_align-modal')">최신 상품 등록순</button>
                                </div>
                                <div class="total">전체 {{$data['list']->total()}}개</div>
                            </div>
                            <div class="relative">
                                <ul class="prod_list">
                                    @foreach($data['list'] as $item)
                                    <li class="prod_item">
                                        <div class="img_box">
                                            <a href="/product/detail/{{$item->idx}}"><img src="{{$item->imgUrl}}" alt="{{$item->name}}"></a>
                                            <button class="zzim_btn"><svg><use xlink:href="/img/icon-defs.svg#zzim"></use></svg></button>
                                        </div>
                                        <div class="txt_box">
                                            <a href="/product/detail/{{$item->idx}}">
                                                <span>{{$data['info']->companyName}}</span>
                                                <p>{{$item->name}}</p>
                                                <b>
                                                    @if($item->is_price_open != 0)
                                                            <?php echo number_format($item->price, 0); ?>원
                                                    @else
                                                        {{$item->price_text}}
                                                    @endif
                                                </b>
                                            </a>
                                        </div>
                                    </li>
                                    @endforeach
                                        {{-- $data['list']->withQueryString()->links() --}}
                                </ul>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- 업체정보 -->
                <div class="detail">
                    <div class="inner">
                        <div class="info">
                            <table>
                                <colgroup>
                                    <col width="120px">
                                    <col width="*">
                                    <col width="120px">
                                    <col width="*">
                                </colgroup>
                                <tbody><tr>
                                    <th>대표자</th>
                                    <td>{{$data['info']->owner_name}}</td>
                                    <th>대표전화</th>
                                    <td>{{$data['info']->phone_number}}</td>
                                </tr>
                                <tr>
                                    <th>근무일</th>
                                    <td>{{$data['info']->work_day}}</td>
                                    <th>발주방법</th>
                                    <td>{{$data['info']->how_order}}</td>
                                </tr>
                                <tr>
                                    <th>담당자</th>
                                    <td>{{$data['info']->manager}}</td>
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
                                </tbody></table>
                        </div>
                        <?php echo str_replace('\"', '', html_entity_decode($data['info']->introduce)); ?>
                    </div>
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
                            <td>{{$data['info']->company_name}}</td>
                        </tr>
                        <tr>
                            <th>전화번호</th>
                            <td><b>{{$data['info']->phone_number}}</b></td>
                        </tr>
                        </tbody></table>
                    <button class="btn btn-primary w-full" onclick="modalClose('#company_phone-modal')">확인</button>
                </div>
            </div>
        </div>

    </div>
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

        // 공유하기 ( 클립보드 복사 )
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

        // 카테고리 및 소팅
        $(document).on('click', '[id^="filter"] .btn-primary', function() {
            let $this = $(this);

            var data = {
                'categories' : getIndexesOfSelectedCategory().join(','),
                'orderedElement' : $('input[name="filter_cate_3"]:checked').attr('id'),
                'company_idx'   : '{{$data['info']->idx}}'
            };

            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: '/wholesaler/wholesalerAddProduct',
                data : data,
                type : 'GET',
                beforeSend : function() {
                    $this.prop("disabled", true);
                },
                success: function (result) {
                    displayNewProducts(result['data'], $(".box .relative .prod_list"), true);

                    $(".total").text('전체 ' + result['total'] + '개');
                },
                complete : function () {
                    $this.prop("disabled", false);
                    displaySelectedCategories();
                    displaySelectedOrders();
                    modalClose('#' + $this.parents('[id^="filter"]').attr('id'));
                    currentPage = 1;
                }
            });
        });

        function getIndexesOfSelectedCategory() {
            let categories = [];
            $("#filter_category-modal .check-form:checked").each(function(){
                categories.push($(this).attr('id'));
            });

            return categories;
        }

        function displaySelectedCategories() {
            let html = "";
            $("#filter_category-modal .check-form:checked").each(function(){
                html += "<span>" + $('label[for="' + $(this).attr('id') + '"]').text() +
                    "   <button onclick=\"filterRemove(this)\"><svg><use xlink:href=\"/img/icon-defs.svg#x\"></use></svg></button>" +
                    "</span>";
            });
            $(".filter_on_box .category").empty().append(html);

            let totalOfSelectedCategories = $("#filter_category-modal .check-form:checked").length;
            if(totalOfSelectedCategories == 0) {
                $(".sub_filter .filter_box button").eq(0).html("카테고리");
                $(".sub_filter .filter_box button").eq(0).removeClass('on');
            } else {
                $(".sub_filter .filter_box button").eq(0).html("카테고리 <b class='txt-primary'>" + totalOfSelectedCategories + "</b>");
                $(".sub_filter .filter_box button").eq(0).addClass('on');
            }
        }

        function displaySelectedOrders() {
            $(".sub_filter .filter_box button").eq(2)
                .text($("label[for='" + $("#filter_align-modal .radio-form:checked").attr('id') + "']").text());
        }

        function displayNewProducts(productArr, target, needsEmptying) {
            if(needsEmptying) {
                target.empty();
            }

            productArr.forEach(function(product, index) {
                target.append(  '<li class="prod_item">'+
                    '   <div class="img_box">'+
                    '       <a href="/product/detail/'+ product['idx'] + '"><img src="' + product['imgUrl'] + '" alt=""></a>'+
                    '       <button class="zzim_btn prd_' + product['idx'] + (product['isInterest'] ==1 ? ' active': '') + '" pidx="' + product['idx'] + '"><svg><use xlink:href="/img/icon-defs.svg#zzim"></use></svg></button>'+
                    '   </div>'+
                    '   <div class="txt_box">'+
                    '       <a href="/product/detail/' + product['idx'] + '">'+
                    '           <span>' + product['companyName'] +'</span>'+
                    '           <p>' + product['name']+'</p>'+
                    '           <b>' + product['price'] + '원</b>'+
                    '       </a>'+
                    '   </div>'+
                    '</li>'
                );
            });
        };
    </script>
@endsection
