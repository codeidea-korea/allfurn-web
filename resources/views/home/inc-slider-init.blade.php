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
</script>
