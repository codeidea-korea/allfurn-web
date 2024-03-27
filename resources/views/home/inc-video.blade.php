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
                            <a href="javascript:;" onclick="videoModalOpen_{{ $key }}('#video-modal_{{ $key }}')"><img src="{{ $video->image_url }}" alt=""></a>
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

<script>
var tag = document.createElement('script');
tag.src = "https://www.youtube.com/iframe_api";
var firstScriptTag = document.getElementsByTagName('script')[0];
firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
</script>

@foreach($data['video_ad'] as $key => $video)
    <div class="modal" id="video-modal_{{ $key }}">
        <div class="modal_bg" onclick="videoModalClose_{{ $key }}('#video-modal_{{ $key }}')"></div>
        <div class="modal_inner modal-auto video_wrap">
            <button class="close_btn" onclick="videoModalClose_{{ $key }}('#video-modal_{{ $key }}')"><svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#Close"></use></svg></button>
            <div class="modal_body" id="player_{{ $key }}">
                @if ($video->video_upload_type == 0)
                    <script>
                        var player_{{ $key }};
                        const videoModalOpen_{{ $key }} = (modal)=>{
                            $(`${modal}`).addClass('show');
                            $('body').addClass('overflow-hidden');
                            player_{{ $key }}.playVideo();
                            player_{{ $key }}.setVolume(70);
                            player_{{ $key }}.unMute();
                        }

                        const videoModalClose_{{ $key }} = (modal)=>{
                            $(`${modal}`).removeClass('show');
                            $('body').removeClass('overflow-hidden');
                            player_{{ $key }}.stopVideo();
                        }
                    </script>
                @else 
                    <video width="1244" height="700" controls id="vplayer_{{ $key }}">
                        <source src="{{ $video->video_url }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                    <script>
                        const videoModalOpen_{{ $key }} = (modal)=>{
                            $(`${modal}`).addClass('show');
                            $('body').addClass('overflow-hidden');
                            $('#vplayer_{{ $key }}').get(0).play();
                            $('#vplayer_{{ $key }}').get(0).volume = 0.7;
                        }
                        const videoModalClose_{{ $key }} = (modal)=>{
                            $(`${modal}`).removeClass('show');
                            $('body').removeClass('overflow-hidden');
                            $('#vplayer_{{ $key }}').get(0).pause();
                        }
                    </script>
                @endif 
            </div>
        </div>
    </div>
@endforeach

<script>
function onYouTubeIframeAPIReady() {
    @foreach($data['video_ad'] as $key => $video)
        @if ($video->video_upload_type == 0)
            player_{{ $key }} = new YT.Player('player_{{ $key }}', {
                height: '700',  //변경가능-영상 높이
                width: '1244',  //변경가능-영상 너비
                videoId: '{{ $video->youtube_link }}',  //변경-영상ID
                playerVars: {
                    'rel': 0,    //연관동영상 표시여부(0:표시안함)
                    'controls': 1,    //플레이어 컨트롤러 표시여부(0:표시안함)
                    'autoplay' : 0,   //자동재생 여부(1:자동재생 함, mute와 함께 설정)
                    'mute' : 0,   //음소거여부(1:음소거 함)
                    'loop' : 0,    //반복재생여부(1:반복재생 함)
                    'playsinline' : 1,    //iOS환경에서 전체화면으로 재생하지 않게
                    'playlist' : '{{ $video->youtube_link }}'   //재생할 영상 리스트
                }
            });
        @endif 
    @endforeach
}
</script>