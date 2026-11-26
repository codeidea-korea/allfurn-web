<section class="main_section home_monthly_deals thismonth_con01 overflow-hidden">
    <div class="inner">
        <div class="main_tit mb-5 flex justify-between items-center">
            <div class="flex items-center gap-4">
                <h3>할인 상품이 필요하신가요?</h3>
            </div>
        </div>
        @include('home.inc-monthly-deal-slider', ['dealbrand' => $data['plandiscount_ad'], 'mobile' => true])
        <a href="/product/thisMonth" class="btn btn-line4 mt-7">더보기</a>
    </div>
</section>
