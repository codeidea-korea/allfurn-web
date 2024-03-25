<section class="sub_section new_arrival_con03 overflow-hidden">
    <div class="inner">
        <div class="main_tit mb-5 flex justify-between items-center">
            <div class="flex items-center gap-4">
                <h3>신규 상품 등록 업체</h3>
            </div>
        </div>
        <div class="relative">
            <div class="slide_box">
                <ul class="company_list swiper-wrapper">
                    @foreach($company as $item)
                        <li class="swiper-slide">
                            <a href="javascript:;">
                                <b>{{$item->company_name}}</b>
                                <div class="tag">
                                    @php $categoryList = explode(',', $item->categoryList); @endphp
                                    <span>{{$categoryList[0]}}</span>
                                    @isset($categoryList[1])
                                        <span>{{ $categoryList[1]}}</span>
                                    @endisset  
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</section>