<section class="main_section video_prod">
    <div class="inner">
        <div class="main_tit mb-8 flex justify-between items-center">
            <div class="flex items-center gap-4">
                <h3>동영상으로 도매 업체/상품 알아보기</h3>
            </div>
        </div>
        <div class="video_box">
            <div class="slide_box overflow-hidden">
                <ul class="swiper-wrapper">
                    @foreach($data['video_ad'] as $key => $video)
                        <li class="swiper-slide">
                            <div class="txt_box">
                                <h4>{{ $video->subtext1 }}<br/><span>{{ $video->subtext2 }}</span></h4>
                            </div>
                            <a href="javascript:;" onclick="modalOpen('#video-modal{{ $key }}')"><img src="{{ $video->image_url }}" alt=""></a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="count_pager"><b>1</b> / 12</div>
            <button class="slide_arrow type02 prev"><svg><use xlink:href="./img/icon-defs.svg#slide_arrow_white"></use></svg></button>
            <button class="slide_arrow type02 next"><svg><use xlink:href="./img/icon-defs.svg#slide_arrow_white"></use></svg></button>
        </div>
    </div>
</section>

@foreach($data['video_ad'] as $key => $video)
    <div class="modal" id="video-modal{{ $key }}">
        <div class="modal_bg" onclick="modalClose('#video-modal{{ $key }}')"></div>
        <div class="modal_inner modal-auto video_wrap">
            <button class="close_btn" onclick="modalClose('#video-modal{{ $key }}')"><svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#Close"></use></svg></button>
            <div class="modal_body">
                @if ($video->video_upload_type == 0)
                    <iframe width="1244" height="700" src="{{ $video->youtube_link }}&autoplay=1" title="2 시간 지브리 음악 🌍 치유, 공부, 일, 수면을위한 편안한 배경 음악 지브리 스튜디오" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                @else 
                    <video width="1244" height="700" controls>
                        <source src="{{ $video->video_url }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                @endif 
            </div>
        </div>
    </div>
@endforeach