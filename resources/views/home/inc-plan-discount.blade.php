<section class="main_section home_monthly_deals thismonth_con01">
    <div class="inner">
        <div class="main_tit mb-8 flex justify-between items-center">
            <div class="flex items-center gap-4">
                <h3>할인 상품이 필요하신가요?</h3>
            </div>
            <div class="flex items-center gap-7">
                <a class="more_btn flex items-center" href="/product/thisMonth">더보기<svg><use xlink:href="./img/icon-defs.svg#more_icon"></use></svg></a>
            </div>
        </div>
        @include('home.inc-monthly-deal-slider', ['dealbrand' => $data['plandiscount_ad'], 'mobile' => false])
    </div>
</section>
