<section class="sub_section nopadding">
    <div class="line_common_banner">
        <ul class="swiper-wrapper">
            @if(isset($banners) && count($banners) > 0)
                @foreach ($banners as $banner)
                    <li class="swiper-slide" style="background-image:url({{ preImgUrl() }}{{$banner->attachment->folder}}/{{$banner->attachment->filename}})">
                        <a href="{{ strpos($banner->web_link, 'help/notice') !== false ? '/help/notice/' : $banner->web_link }}">
                            <div class="txt_box">
                                <p>{{$banner->subtext1}}</p>
                                <span>{{$banner->subtext2}}</span>
                            </div>
                        </a>
                    </li>
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