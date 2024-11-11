<section class="main_section main_family">
    <div class="inner">
        <div class="main_tit mb-2 flex justify-between items-center">
            <div class="flex items-center gap-4">
                <h3>가구 관련 협력업체</h3>
            </div>
        </div>
        <ul class="grid grid-cols-4">
            @foreach($data['family_ad'] as $key => $family)
                <li>
                    <a href='/family/{{$family->idx}}'>
                        <div class="img_box">
                            <p style="display: inline-flex;flex-direction: row;flex-wrap: nowrap;justify-content: space-around;align-items: center;">
                                <span style="padding: 10px;">{{ $family->family_name }}</span>
                                <img style="width:131px" src="{{ $family->imgUrl }}" alt="">
                            </p></div>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</section>  
