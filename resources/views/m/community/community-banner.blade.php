<section class="sub_section nopadding">
    <div class="line_common_banner">
        <ul class="swiper-wrapper">
            @if(isset($banners) && count($banners) > 0)
                @foreach ($banners as $banner)
                    @if($banner->banner_type === 'img')
                        <li class="swiper-slide" style="background-image:url({{ $banner->appBigImgUrl }})">
                            <a href="{{ strpos($banner->web_link, 'help/notice') !== false ? '/help/notice/' : $banner->web_link }}"></a>
                        </li>
                    @else
                        <li class="swiper-slide" style="background-color:{{$banner->bg_color}};">
                            <a href="{{ strpos($banner->web_link, 'help/notice') !== false ? '/help/notice/' : $banner->web_link }}">
                                <div class="txt_box" style="color:{{ $banner->font_color }};">
                                    <p>{{ $banner->subtext1 }}<br/>{{ $banner->subtext2 }}</p>
                                    <span>{{ $banner->content }}</span>
                                </div>
                            </a>
                        </li>
                    @endif
                @endforeach
            @endif
        </ul>
        <div class="count_pager"><b>1</b> / 12</div>
    </div>
</section>

<script>
    // line_common_banner 
    const line_common_banner = new Swiper(".line_common_banner", {
        slidesPerView: 1,
        spaceBetween: 0,
        pagination: {
            el: ".line_common_banner .count_pager",
            type: "fraction",
        }
    });
</script>