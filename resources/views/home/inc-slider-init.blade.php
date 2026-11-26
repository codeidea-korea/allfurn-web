<script>
// 빈 영역은 초기화하지 않아 다른 홈 슬라이더와의 연결을 방해하지 않습니다.
function createHomeSwiper(selector, options = {}) {
    const target = document.querySelector(selector);
    const wrapper = target && Array.from(target.children).find((child) => child.classList.contains('swiper-wrapper'));
    const slides = wrapper ? Array.from(wrapper.children).filter((child) => child.classList.contains('swiper-slide')) : [];

    if (slides.length === 0) {
        return null;
    }

    // 한 장뿐인 배너는 복제 슬라이드와 자동 전환이 필요하지 않습니다.
    if (options.loop && slides.length === 1) {
        options = { ...options, loop: false, autoplay: false };
    }

    return new Swiper(target, options);
}

function initHomeMonthlyDeals() {
    const section = document.querySelector('.home_monthly_deals');
    const target = section && section.querySelector('.slide_box');
    if (!target || target.swiper) {
        return;
    }

    const pager = createHomeSwiper('.home_monthly_deals .pager_box', {
        slidesPerView: 'auto',
        spaceBetween: 10,
        watchSlidesProgress: true,
        navigation: {
            nextEl: section.querySelector('.bottom_box .arrow.next'),
            prevEl: section.querySelector('.bottom_box .arrow.prev'),
        },
    });
    createHomeSwiper('.home_monthly_deals .slide_box', {
        slidesPerView: 1,
        spaceBetween: 0,
        // 배너가 한 개여도 하단의 1 / 1 표시를 유지합니다.
        watchOverflow: false,
        navigation: {
            nextEl: section.querySelector('.slide_arrow.next'),
            prevEl: section.querySelector('.slide_arrow.prev'),
        },
        pagination: {
            el: section.querySelector('.count_pager'),
            type: 'fraction',
        },
        thumbs: { swiper: pager },
    });
}
</script>
