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
                            <a href="/wholesaler/detail/{{$item->company_idx}}">
                                <b>{{$item->company_name}}</b>
                                <div class="tag">
                                    @php $categoryList = explode(',', $item->categoryList); @endphp
                                    @foreach($categoryList as $category)
                                        @if($category == '화장대/거울/콘솔')
                                            <span>화장대/거울</span>
                                        @elseif($category == '수납/서랍장/옷장')
                                            <span>서랍장/옷장</span>
                                        @else
                                            <span>{{$category}}</span>
                                        @endif
                                    @endforeach
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</section>