<link href="https://cdn.jsdelivr.net/npm/froala-editor@3.1.0/css/froala_editor.pkgd.min.css" rel="stylesheet" type="text/css">
<div class="my__section">
    <div class="content">
        <div class="section">
            <div class="section__head">
                <div class="section__head__group">
                    <h3 class="section__title">업체 관리</h3>
                    <button type="button" onclick="location.href='/mypage/edit/company'">
                        <i class="ico__set"></i>
                        <span>설정</span>
                    </button>
                </div>
            </div>
            <div class="section__content">
                <div class="content__card">
                    <div class="card__info">
                        <div class="card__img">
                            <img src="{{ $info->profile_image ?: '/images/sub/thumbnail@2x.png'}}" alt="dummy_thumbnail3">
                        </div>
                        <div>
                            <p class="card__text01">{{ $info->company_name }}</p>
                            <p class="card__text02">{{ $info->regions }}</p>
                            <ul class="card__list">
                                @foreach(explode(',', $info->category_names) as $category)
                                <li>{{ $category }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @if($info->product_count < 5)
                    <div class="card__notice">
                        <i class="ico__info"><span class="a11y">공지</span></i>
                        <p>업체 상세 정보를 등록하고 상품을 5개 이상 등록해야 도매 업체 리스트에 노출됩니다.</p>
                    </div>
                    @endif
                </div>
                
                <ul class="content__list">
                    <li class="list--underbar">
                        <h4>업체 소개</h4>
                        @if($info->introduce)
                            <div class="editor-wrap">
                                {!! $info->introduce !!}
                            </div>
                        @else
                            <button type="button" class="list__add-btn mt32" onclick="location.href='/mypage/edit/company'">
                                <i class="ico__add--circle"><span class="a11y">추가</span></i>
                                <span>업체 소개를 등록해주세요</span>
                            </button>
                        @endif
                    </li>
                    
                    <li class="list__company-info">
                        <h4>업체 정보</h4>
                        <dl>
                            <dt>대표자</dt>
                            <dd>{{ $info->owner_name }}</dd>
                        </dl>
                        @if(!$info->phone_number)
                        <button type="button" class="list__add-btn mt8" onclick="location.href='/mypage/edit/company'">
                            <i class="ico__add--circle"><span class="a11y">추가</span></i>
                            <span>업체 소개를 등록해주세요</span>
                        </button>
                        @else
                            @if($info->address)
                            <dl>
                                <dt>주소</dt>
                                <dd>{{ $info->address }}</dd>
                            </dl>
                            @endif
                            @if($info->work_day)
                            <dl>
                                <dt>근무일</dt>
                                <dd>{{ $info->work_day }}</dd>
                            </dl>
                            @endif
                            @if($info->business_email)
                            <dl>
                                <dt>이메일</dt>
                                <dd>
                                    <a href="mailto:{{ $info->business_email }}">{{ $info->business_email }}</a>
                                </dd>
                            </dl>
                            @endif
                            @if($info->phone_number)
                            <dl>
                                <dt>업체 연락처</dt>
                                <dd>{{ $info->phone_number }}</dd>
                            </dl>
                            @endif
                            @if($info->manager)
                            <dl>
                                <dt>담당자</dt>
                                <dd>{{ $info->manager }}</dd>
                            </dl>
                            @endif
                            @if($info->manager_number)
                            <dl>
                                <dt>담당자 연락처</dt>
                                <dd>{{ $info->manager_number }}</dd>
                            </dl>
                            @endif
                            @if ($info->fax)
                            <dl>
                                <dt>팩스</dt>
                                <dd>{{ $info->fax }}</dd>
                            </dl>
                            @endif
                            @if ($info->website)
                            <dl>
                                <dt>웹사이트</dt>
                                <dd>
                                    <a href="{{ $info->website }}" target="_blank">{{ $info->website }}</a>
                                </dd>
                            </dl>
                            @endif
                            
                            @if ($info->etc)
                            <dl>
                                <dt>기타</dt>
                                <dd>{{ $info->etc }}</dd>
                            </dl>
                            @endif
                            
                        @endif
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
