<div class="w-full">
    <div class="flex justify-between">
        <h3 class="text-xl font-bold">홈페이지 관리</h3>
        <a href="/mypage/edit/company" class="flex gap-1">
            <svg class="w-6 h-6"><use xlink:href="/img/icon-defs.svg#setting"></use></svg>
            <span class="font-medium">설정</span>
        </a>
    </div>
    
    <div class="pt-5">
        <ul class="obtain_list hompage">
            <li>
                <div class="txt_box">
                    <div class="flex items-center gap-4">
                        <div class="profile_img">
                            <img src="{{ $info -> profile_image ?: '/img/profile_img.svg'}}" class="w-[80px] h-[80px] object-cover rounded-full" alt="" />
                        </div>
                        <div>
                            <a href="/mypage/edit/company">
                                <img src="/img/icon/crown.png" alt="" />
                                {{ $info -> company_name }}
                                <svg><use xlink:href="/img/icon-defs.svg#more_icon"></use></svg>
                            </a>
                            <i>{{ $info -> regions }}</i>
                            <div class="tag">
                                @foreach(explode(',', $info -> category_names) as $category)
                                <span>{{ $category }}</span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    </div>

    <div class="pt-6">
        <p class="font-bold pb-3 border-b-2 border-stone-800">업체 소개</p>
        <div class="py-5 border-b">
            <div class="h-[300px] overflow-y-scroll">
                @if($info -> introduce)
                <div class="editor-wrap">
                    {!! $info -> introduce !!}
                </div>
                @else
                <button type="button" class="list__add-btn mt32" onClick="location.href='/mypage/edit/company'">
                    <i class="ico__add--circle"><span class="a11y">추가</span></i>
                    <span>업체 소개를 등록해주세요.</span>
                </button>
                @endif
            </div>
        </div>

        <p class="font-bold pb-3 border-b-2 border-stone-800 pt-5">업체 정보</p>

        <table class="mt-4 text-left text-sm">
            <tr>
                <th class="text-stone-500 font-normal p-2">대표자</th>
                <td class="p-2">{{ $info->owner_name }}</td>
            </tr>
            <tr>
                <th class="text-stone-500 font-normal p-2">주소</th>
                <td class="p-2">{{ $info -> address }}</td>
            </tr>
            <tr>
                <th class="text-stone-500 font-normal p-2">근무일</th>
                <td class="p-2">{{ $info -> work_day }}</td>
            </tr>
            <tr>
                <th class="text-stone-500 font-normal p-2">업체 연락처</th>
                <td class="p-2">{{ $info -> phone_number }}</td>
            </tr>
            <tr>
                <th class="text-stone-500 font-normal p-2">담당자</th>
                <td class="p-2">{{ $info -> manager }}</td>
            </tr>
            <tr>
                <th class="text-stone-500 font-normal p-2">담당자 연락처</th>
                <td class="p-2">{{ $info -> manager_number }}</td>
            </tr>
            <tr>
                <th class="text-stone-500 font-normal p-2">웹사이트</th>
                <td class="p-2">
                    <a href="{{ $info -> website }}">{{ $info -> website }}</a>
                </td>
            </tr>
        </table>
    </div>
</div>