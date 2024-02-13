@extends('layouts.master')

@section('header')
    @include('layouts.header.main-header')
@endsection

@section('content')
<div id="container" class="container">
    <div class="service">
        <div class="inner">
            <div class="content">
                <div class="section">
                    <div class="section__head">
                        <ul class="breadcrumbs-wrap">
                            <li>고객센터</li>
                            <li>1:1 문의</li>
                        </ul>
                        <h3 class="section__title">
                            <p>1:1 문의</p>
                            <div class="section__title-wrap">
                                <a href="/help/inquiry/form" class="button button--etc head-button">1:1 문의하기</a>
                            </div>
                        </h3>
                    </div>
                </div>
                @if($count < 1)
                    <div class="service-content service-content--nodata">
                        <span><i class="ico__exclamation"></i></span>
                        <p>등록하신 1:1 문의가 없습니다.</p>
                    </div>
                @else
                    <div class="list">
                        <table>
                            <thead>
                            <tr>
                                <th style="width: 167px">문의 유형</th>
                                <th style="width: 678px">내용</th>
                                <th style="width: 167px">문의 일자</th>
                                <th style="width: 167px">진행 상태</th>
                            </tr>
                            </thead>
                            <tbody class="accordion">
                                @foreach($list as $row)
                                    <tr class="accordion__head">
                                        <td>{{ $row->category->name }}</td>
                                        <td><p class="title">{{ $row->title }}<p></td>
                                        <td>{{ date('Y.m.d', strtotime($row->register_time)) }}</td>
                                        <td>
                                            @if ($row->state === 0)
                                                <div class="badge-wrap">
                                                    <div class="badge badge--taken">문의 접수</div>
                                                </div>
                                            @else
                                                <div class="badge-wrap">
                                                    <div class="badge badge--answered">답변 완료</div>
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="accordion__panel">
                                            <div class="accordion__content">
                                                <div class="title">Q</div>
                                                <div class="contents">
                                                    {!! nl2br($row->content) !!}
                                                    @if ($row->state === 0)
                                                        <div class="button-wrap">
                                                            <button type="button" onclick="cancelInquiry({{ $row->idx }})" class="button button--blank">문의 취소</button>
                                                            <a href="/help/inquiry/form/{{ $row->idx }}" class="button button--solid">수정</a>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            @if($row->reply)
                                            <div class="accordion__content">
                                                <div class="title">A</div>
                                                <div class="contents">
                                                    {!! nl2br($row->reply) !!}
                                                    <div class="contents__meta">{{ date('Y.m.d', strtotime($row->reply_date)) }}</div>
                                                </div>
                                            </div>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="pagenation">
                            @if($pagination['prev'] > 0)
                                <button type="button" class="prev" onclick="moveToList({{$pagination['prev']}})">
                                    <svg width="7" height="12" viewBox="0 0 7 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M6 1L1 6L6 11" stroke="#DBDBDB" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </button>
                            @endif
                            <div class="numbering">
                                @foreach($pagination['pages'] as $paginate)
                                    @if ($paginate == $offset)
                                        <a href="javascript:void(0)" onclick="moveToList({{$paginate}})" class="numbering--active">{{$paginate}}</a>
                                    @else
                                        <a href="javascript:void(0)" onclick="moveToList({{$paginate}})">{{$paginate}}</a>
                                    @endif
                                @endforeach
                            </div>
                            @if($pagination['next'] > 0)
                                <button type="button" class="next" onclick="moveToList({{$pagination['next']}})">
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5 12L10 7L5 2" stroke="#828282" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </button>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <div id="modal-cs--abort" class="modal">
            <div class="modal__container" style="width: 350px;">
                <div class="modal__content">
                    <div class="modal-box__container">
                        <div class="modal-box__content">
                            <div class="modal__desc">
                                <p class="modal__text">
                                    문의를 취소하시겠습니까?
                                </p>
                            </div>
                            <div class="modal__util">
                                <button type="button" onclick="closeModal('#modal-cs--abort');" class="modal__button modal__button--gray"><span>취소</span></button>
                                <button type="button" onclick="doCancelInquiry(this)" id="doCancelInquiry" class="modal__button"><span>확인</span></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="modal-cs--abort_complete" class="modal">
            <div class="modal__container" style="width: 350px;">
                <div class="modal__content">
                    <div class="modal-box__container">
                        <div class="modal-box__content">
                            <div class="modal__desc">
                                <p class="modal__text">
                                    문의가 취소되었습니다.
                                </p>
                            </div>
                            <div class="modal__util">
                                <button type="button" onclick="closeModal('#modal-cs--abort_complete');" class="modal__button"><span>확인</span></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
@push('scripts')
    <script>
        $( function() {
            var icons = {
                header: "ico__arrow--down24",
                activeHeader: "ico__arrow--up24"
            };
            $( ".accordion" ).accordion({
                header: ".accordion__head",
                icons: icons,
                collapsible: true,
                animate: 0,
                active: false,
            });
            $( ".list .accordion" ).accordion({
                icons: false,
            });
        });

        const cancelInquiry = idx => {
            document.getElementById('doCancelInquiry').dataset.cancelIdx = idx
            openModal('#modal-cs--abort');
        }

        const doCancelInquiry = elem => {
            const cancelIdx = elem.dataset.cancelIdx
            fetch('/help/inquiry/'+cancelIdx, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                }
            }).then(response => {
                if (response.ok) {
                    return response.json();
                }
                throw new Error('Sever Error');
            }).then(json => {
                if (json.result === 'success') {
                    alert('취소 되었습니다');
                    location.reload();
                } else {
                    alert(json.message);
                }
            }).catch(error => {
            })
        }

        const moveToList = page => {
            location.replace(location.pathname + "?" + new URLSearchParams({offset:page}));
        }
    </script>
@endpush
