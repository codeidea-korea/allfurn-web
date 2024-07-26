@extends('layouts.master')

@section('header')
    @include('layouts.header.main-header')
@endsection

@section('content')
<div id="container" class="container">
    <div class="inner">
        <div class="content">
            <div class="magazine__wrap">
                <div class="magazine__title">
                    <div>
                        <h2>{{ stripslashes($detail->title) }}</h2>
                        @if ($detail->start_date !== '0000-00-00' && $detail->end_date !== '0000-00-00' && $detail->start_date && $detail->end_date)
                        <p>{{ $detail->start_date }} - {{ $detail->end_date }}</p>
                        @endif
                    </div>
                    <button class="ico__share28" onclick="copied_link()"><span class="a11y">공유</span></button>

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

                <div class="magazine__detail">
                    <p class="magazine__text">
                        {!! stripslashes($detail->content) !!}
                    </p>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
    <script>
        // 링크 복사
        const copied_link = () => {
            var dummy   = document.createElement("input");
            var text    = location.href;

            document.body.appendChild(dummy);
            dummy.value = text;
            dummy.select();
            document.execCommand("copy");
            document.body.removeChild(dummy);

            openModal('#alert-modal')
        }
    </script>
@endpush
