<section class="main_section video_prod">
    <div class="inner">
        <div class="main_tit mb-8 flex justify-between items-center">
            <div class="flex items-center gap-4">
                <h3>동영상으로 도매 업체/상품 알아보기</h3>
            </div>
        </div>
    </div>
    <div class="video_box overflow-hidden">
        <div class="slide_box">
            <ul class="swiper-wrapper">
                @foreach($data['video_ad'] as $key => $video)
                    <li class="swiper-slide">
                        <div class="txt_box">
                            <h4>{{ $video->subtext1 }}<br/><span>{{ $video->subtext2 }}</span></h4>
                        </div>
                        <a href="javascript:;" onclick="videoModalOpen_{{ $key }}('#video-modal_{{ $key }}')"><img src="data:image/gif;base64,R0lGODlhAQABAAAAACw=" data-src="{{ $video->image_url }}" loading="lazy" decoding="async" fetchpriority="low" class="object-cover w-full h-[217px]" alt=""></a>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="count_pager"><b>1</b> / 12</div>
    </div>
</section>


<script>
var allfurnYouTubeApiPromise = null;
function loadYouTubeIframeApi()
{
    if(window.YT && window.YT.Player) {
        return Promise.resolve();
    }

    if(allfurnYouTubeApiPromise) {
        return allfurnYouTubeApiPromise;
    }

    allfurnYouTubeApiPromise = new Promise(function(resolve) {
        window.onYouTubeIframeAPIReady = function() {
            resolve();
        };

        var tag = document.createElement('script');
        tag.src = "https://www.youtube.com/iframe_api";
        tag.async = true;
        document.head.appendChild(tag);
    });

    return allfurnYouTubeApiPromise;
}
</script>


@foreach($data['video_ad'] as $key => $video)
    <div class="modal" id="video-modal_{{ $key }}">
        <div class="modal_bg" onclick="videoModalClose_{{ $key }}('#video-modal_{{ $key }}')"></div>
        <div class="modal_inner video_wrap">
            <button class="close_btn" onclick="videoModalClose_{{ $key }}('#video-modal_{{ $key }}')"><svg class="w-11 h-11"><use xlink:href="./img/icon-defs.svg#Close"></use></svg></button>
            <div class="modal_body" >
                @if ($video->video_upload_type == 0)
                <div class="video_box"><div class="" id="player_{{ $key }}"></div></div>
                    <script>
                        var player_{{ $key }};
                        var playerPromise_{{ $key }} = null;

                        const initYoutubePlayer_{{ $key }} = ()=>{
                            if(player_{{ $key }}) {
                                return Promise.resolve(player_{{ $key }});
                            }

                            if(playerPromise_{{ $key }}) {
                                return playerPromise_{{ $key }};
                            }

                            playerPromise_{{ $key }} = loadYouTubeIframeApi().then(function() {
                                return new Promise(function(resolve) {
                                    player_{{ $key }} = new YT.Player('player_{{ $key }}', {
                                        width: '100%',
                                        videoId: '{{ $video->youtube_link }}',
                                        playerVars: {
                                            'rel': 0,
                                            'controls': 1,
                                            'autoplay' : 0,
                                            'mute' : 0,
                                            'loop' : 0,
                                            'playsinline' : 1,
                                            'playlist' : '{{ $video->youtube_link }}'
                                        },
                                        events: {
                                            onReady: function() {
                                                resolve(player_{{ $key }});
                                            }
                                        }
                                    });
                                });
                            });

                            return playerPromise_{{ $key }};
                        }

                        const videoModalOpen_{{ $key }} = (modal)=>{
                            $(`${modal}`).addClass('show');
                            $('body').addClass('overflow-hidden');
                            initYoutubePlayer_{{ $key }}().then(function(player) {
                                player.playVideo();
                                player.setVolume(70);
                                player.unMute();
                            });
                        }

                        const videoModalClose_{{ $key }} = (modal)=>{
                            $(`${modal}`).removeClass('show');
                            $('body').removeClass('overflow-hidden');
                            if(player_{{ $key }}) {
                                player_{{ $key }}.stopVideo();
                            }
                        }
                    </script>
                @else 
                    <video width="1244" height="700" controls preload="none" id="vplayer_{{ $key }}">
                        <source data-src="{{ $video->video_url }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                    <script>
                        const initVideoSource_{{ $key }} = ()=>{
                            const video = $('#vplayer_{{ $key }}').get(0);
                            const source = video ? video.querySelector('source[data-src]') : null;

                            if(source) {
                                source.src = source.dataset.src;
                                source.removeAttribute('data-src');
                                video.load();
                            }

                            return video;
                        }

                        const videoModalOpen_{{ $key }} = (modal)=>{
                            $(`${modal}`).addClass('show');
                            $('body').addClass('overflow-hidden');
                            const video = initVideoSource_{{ $key }}();
                            video.play();
                            video.volume = 0.7;
                        }
                        const videoModalClose_{{ $key }} = (modal)=>{
                            $(`${modal}`).removeClass('show');
                            $('body').removeClass('overflow-hidden');
                            const video = $('#vplayer_{{ $key }}').get(0);

                            if(video) {
                                video.pause();
                            }
                        }
                    </script>
                @endif 
            </div>
        </div>
    </div>
@endforeach 

<script>
function legacyOnYouTubeIframeAPIReadyDisabled() {
    @foreach($data['video_ad'] as $key => $video)
        @if ($video->video_upload_type == 0)
            player_{{ $key }} = new YT.Player('player_{{ $key }}', {
                //height: '400',  //변경가능-영상 높이
                width: '100%',  //변경가능-영상 너비
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
