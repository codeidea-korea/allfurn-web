<!-- 오른쪽 컨텐츠 -->
<div class="w-full">
    <div class="flex justify-between">
        <h3 class="text-xl font-bold">좋아요 상품</h3>
        <button class="flex gap-1" onclick="modalOpen('#folder_mng_modal')">
            <svg class="w-6 h-6"><use xlink:href="/img/icon-defs.svg#setting"></use></svg>
            <span class="font-medium">폴더 관리</span>
        </button>
    </div>
    
    <div class="flex items-center mt-5 my_like_tab_wrap gap-4 border-b border-slate-200">
        <button class="{{ request()->input('folder') === null ? 'active' : '' }} my_like_tab py-2 text-gray-400" onclick="location.href='/mypage/interest'">
            <span>전체</span>
        </button>
        @if(count($folders) > 0)
            @foreach ($folders as $folder)
                <button class="{{ $folder->idx == request()->input('folder') ? 'active' : '' }} my_like_tab py-2 flex items-center text-gray-400" onclick="location.href='/mypage/interest?folder={{ $folder->idx }}'">
                    <span>{{ $folder->name }}</span>
                </button>
            @endforeach
        @endif
    </div>

    <div class="mt-4">
        <div class="sub_filter">
            <div class="filter_box">
                <button class="{{ request()->input('categories') != null ? 'on' : '' }}" onclick="modalOpen('#filter_category-modal')">카테고리 <b class="txt-primary">{{ request()->query('categories') != null ? count(explode(',', request()->query('categories'))) : '' }}</b></button>
            </div>
        </div>
        <div class="sub_filter_result" hidden>
            <div class="filter_on_box">
                <div class="category"></div>
            </div>
            <button class="refresh_btn" onclick="location.href='/mypage/interest'">초기화 <svg><use xlink:href="/img/icon-defs.svg#refresh"></use></svg></button>
        </div>
    </div>

    <div class="my_like_tab_section pt-5" style="display: block;">
        <div class="flex items-center pb-3 justify-between">
            <span>전체 {{ $count }}개</span>
            <button class="main_color" onclick="showEditTool()">편집</button>
        </div>
        <div class="relative custom_input">
            <div class="mb-3 flex justify-between folder_setting" style="display: none;">
                <div>
                    <input type="checkbox" id="checkAll">
                    <label class="flex items-center gap-2" for="checkAll">전체 선택</label>
                </div>
                <div class="flex items-center gap-3 text-gray-600">
                    <button onclick="modalOpen('#folder_move_modal')">폴더 이동</button> |
                    <button onclick="removeInterestProduct(this)" data-btn-type="modal">삭제</button> |
                    <button onclick="hideEditTool()">완료</button>
                </div>
            </div>
            <ul class="prod_list">
                @foreach ($list as $product)
                    <li class="prod_item">
                        <div class="img_box">
                            <a href="/product/detail/{{ $product->idx }}"><img src="{{ $product->product_image }}" alt=""></a>
                            <div class="list_check_img" hidden>
                                <input type="checkbox" class="itemCheckbox" id="list-card{{ $product->idx }}" value="{{ $product->idx }}">
                                <label class="check_label" for="list-card{{ $product->idx }}"></label>
                            </div>
                            <button class="zzim_btn active prd_{{ $product->idx }}" pidx="{{ $product->idx }}"><svg><use xlink:href="/img/icon-defs.svg#zzim"></use></svg></button>
                        </div>
                        <div class="txt_box">
                            <a href="/product/detail/{{ $product->idx }}">
                                <span>{{ $product->company_name }}</span>
                                <p>{{ $product->product_name }}</p>
                                <b>{{$product->is_price_open ? number_format($product->price, 0).'원': $product->price_text}}</b>
                            </a>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="pagenation flex items-center justify-center py-12">
            @if($pagination['prev'] > 0)
                <a href="javascript:void(0)" onclick="moveToList({{$pagination['prev']}}"><</a>
            @endif
            @foreach($pagination['pages'] as $paginate)
                <a href="javascript:void(0)" onclick="moveToList({{$paginate}})" class="{{ $paginate == $offset ? 'active' : '' }}">{{$paginate}}</a>
            @endforeach
            @if($pagination['next'] > 0)
                <a href="javascript:void(0)" onclick="moveToList({{$pagination['next']}}">></a>
            @endif
        </div>
    </div>

    <!-- 폴더관리 모달 -->
    <div class="modal" id="folder_mng_modal">
        <div class="modal_bg" onclick="modalClose('#folder_mng_modal')"></div>
        <div class="modal_inner modal-md" style="width:560px;">
            <div class="modal_body filter_body">
                <div class="py-2">
                    <div class="flex gap-4">
                        <p class="text-lg font-bold">폴더관리</p>
                        <button class="plus_em_btn text-gray-400">+ 추가</button>
                    </div>
                    <div class="plus_em_wrap mt-5">
                        @foreach($folders as $folder)
                            <div class="plus_em">
                                <div class="flex items-center justify-between py-3 border-b">
                                    <div class="flex items-center gap-3">
                                        <input type="text" class="border border-gray-200 rounded-sm p-2 w-[240px]" placeholder="폴더명을 입력해 주세요." value="{{ $folder->name }}" data-folder-id="{{ $folder->idx }}" name="update_folder_name">
                                        <p>[ 상품 <span>{{ $folder->product_count >= 1000 ? '999+' : ($folder->product_count < 1 ? 0 : $folder->product_count)}}</span>개 보유 ]</p>
                                    </div>
                                    <button class="delete_btn text-gray-400 font-medium" onclick="deleteFolder(this)" data-btn-type="modal" data-folder-id="{{ $folder->idx }}">삭제</button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="flex justify-center">
                        <button class="btn btn-primary w-1/2 mt-8" onclick="addFolder()">저장</button>
                    </div> 
                </div>
            </div>
        </div>
    </div>

    {{-- 폴더 삭제 컨펌 모달 --}}
    <div class="modal" id="folder_delete_modal">
        <div class="modal_bg" onclick="modalClose('#folder_delete_modal')"></div>
        <div class="modal_inner modal-md" style="width:360px;">
            <div class="modal_body filter_body">
                <div class="py-2">
                    <p class="text-center mt-3">
                        폴더를 삭제하시겠습니까?<br>폴더에 담긴 상품도 함께 삭제됩니다.
                    </p>
                    <div class="flex justify-center gap-4 mt-8">
                        <button class="btn bg-slate-200 w-full" onclick="modalClose('#folder_delete_modal')">취소</button>
                        <button class="btn btn-primary w-full" onclick="deleteFolder(this)" data-btn-type="confirm">확인</button>
                    </div> 
                </div>
            </div>
        </div>
    </div>

    <!-- 폴더이동 모달 -->
    <div class="modal" id="folder_move_modal">
        <div class="modal_bg" onclick="modalClose('#folder_move_modal')"></div>
        <div class="modal_inner modal-md" style="width:560px;">
            <div class="modal_body filter_body">
                <div class="py-2">
                    <div class="flex gap-4">
                        <p class="text-lg font-bold">폴더 이동</p>
                    </div>
                    <div class="move_wrap mt-5">
                        <div class="flex items-center justify-between py-4 border-b">
                            <div class="flex items-center gap-3 productDiv">
                                <p>전체</p>
                                <p>[ 상품 <span>{{ $countAll }}</span>개 보유 ]</p>
                            </div>
                            <button class="text-gray-400 font-medium"  onclick="moveInterestProduct(this)" data-btn-type="modal">이동</button>
                        </div>
                        @foreach($folders as $folder)
                            <div class="flex items-center justify-between py-4 border-b">
                                <div class="flex items-center gap-3 productDiv">
                                    <p>{{ $folder->name }}</p>
                                    <p>[ 상품 <span>{{ $folder->product_count >= 1000 ? '999+' : ($folder->product_count < 1 ? 0 : $folder->product_count)}}</span>개 보유 ]</p>
                                </div>
                                <button class="text-gray-400 font-medium" onclick="moveInterestProduct(this)" data-btn-type="modal" data-folder-id="{{$folder->idx}}">이동</button>
                            </div>
                        @endforeach
                    </div>
                    <div class="flex justify-center">
                        <button class="btn bg-slate-200 w-1/2 mt-8" onclick="modalClose('#folder_move_modal')">닫기</button>
                    </div> 
                </div>
            </div>
        </div>
    </div>

    {{-- 폴더이동 컨펌 모달 --}}
    <div class="modal" id="folder_move_conf_modal">
        <div class="modal_bg" onclick="modalClose('#folder_move_conf_modal')"></div>
        <div class="modal_inner modal-md" style="width:360px;">
            <div class="modal_body filter_body">
                <div class="py-2">
                    <p class="text-center mt-3">
                        폴더를 이동하시겠습니까?
                    </p>
                    <div class="flex justify-center gap-4 mt-8">
                        <button class="btn bg-slate-200 w-full" onclick="modalClose('#folder_move_conf_modal')">취소</button>
                        <button class="btn btn-primary w-full" onclick="moveInterestProduct(this)" data-btn-type="confirm" data-folder-id=''>확인</button>
                    </div> 
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="product_remove_conf_modal">
        <div class="modal_bg" onclick="modalClose('#product_remove_conf_modal')"></div>
        <div class="modal_inner modal-md" style="width:360px;">
            <div class="modal_body filter_body">
                <div class="py-2">
                    <p class="text-center mt-3">
                        선택한 상품을 삭제하시겠습니까?<br>좋아요 상품 내 모든 폴더에서 사라집니다.
                    </p>
                    <div class="flex justify-center gap-4 mt-8">
                        <button class="btn bg-slate-200 w-full" onclick="modalClose('#product_remove_conf_modal')">취소</button>
                        <button class="btn btn-primary w-full" onclick="removeInterestProduct(this)" data-btn-type="confirm">확인</button>
                    </div> 
                </div>
            </div>
        </div>
    </div>

</div>
<script>
    $(document).ready(function() {
        //카테고리 선택시
        @if(request()->input('categories') != null)
            let selectedCategories = [{{ request()->input('categories') }}];
            
            $("#filter_category-modal .check-form").each(function() {
                if(selectedCategories.indexOf(parseInt($(this).attr("id"))) != -1) {
                    $(this).prop('checked', true);
                    $(".category").append('<span>' + $(this).siblings('label').text() +'<button data-id = "'+ $(this).attr('id') +'" onclick="filterRemove(this)"><svg><use xlink:href="/img/icon-defs.svg#x"></use></svg></button></span>')
                    $(".sub_filter_result").css('display', 'flex');
                }
            });

        @endif
    });

    $(document).on('click', '#filter_category-modal .btn-primary', function() {
        reloadWithFilter();
    })

    // 카테고리 - 삭제
    function filterRemove(item) {
        $("#" + $(item).data('id')).prop('checked', false);
        reloadWithFilter();
    }

    function reloadWithFilter() {
        let categories = [];
        $("#filter_category-modal .check-form:checked").each(function(){
            categories.push($(this).attr('id'));
        });

        if (categories) {
            let bodies = {categories:categories};
            const urlSearch = new URLSearchParams(location.search);
            if (urlSearch.get('folder')) bodies.folder = urlSearch.get('folder');
            location.href='/mypage/interest?' + new URLSearchParams(bodies);
        }
    }

    // 전체 선택/해제
    $('#checkAll').click(function() {
        $('.itemCheckbox').prop('checked', this.checked);
    });

    // 개별 체크박스 변경 시
    $('.itemCheckbox').change(function() {
        if ($('.itemCheckbox:checked').length == $('.itemCheckbox').length) {
            $('#checkAll').prop('checked', true);
        } else {
            $('#checkAll').prop('checked', false);
        }
    });

    $('.plus_em_btn').click(function() {
        $('.plus_em_wrap').append(`
            <div class="plus_em">
                <div class="flex items-center justify-between py-3 border-b">
                    <div class="flex items-center gap-3">
                        <input type="text" class="border border-gray-200 rounded-sm p-2 w-[240px]" placeholder="폴더명을 입력해 주세요." name="add_folder_name">
                        <p></p>
                    </div>
                    <button class="delete_btn text-gray-400 font-medium fresh">삭제</button>
                </div>
            </div>
        `);
    });

    $(document).on('click', '.delete_btn.fresh', function() {
        $(this).closest('.plus_em').remove();
    });


    $(document).on('click', '.zzim_btn', function() {
        location.reload();
    });

    const moveToList = page => {
        let bodies = {offset:page};
        const urlSearch = new URLSearchParams(location.search);
        if (urlSearch.get('categories')) bodies.categories = urlSearch.get('categories');
        if (urlSearch.get('folder')) bodies.folder = urlSearch.get('folder');
        location.replace("/mypage/interest?" + new URLSearchParams(bodies));
    }
    
    function addFolder() {
        const updateElements = document.querySelectorAll('[name*=update_folder_name]');
        let doUpdates = [];
        updateElements.forEach(elem => {
            elem.value ? doUpdates.push({idx: elem.dataset.folderId, folder_name:elem.value}) : '';
        })

        const registerElements = document.querySelectorAll('[name*=add_folder_name]');
        let doAdds = [];
        registerElements.forEach((elem, index)=> {
            elem.value ? doAdds.push(elem.value) : '';
        })
        
        fetch('/mypage/my-folders', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{csrf_token()}}'
            },
            body: JSON.stringify({
                updates: doUpdates,
                adds: doAdds,
            })
        }).then(response => {
            return response.json()
        }).then(json => {
            location.reload();
        })
    }

    function deleteFolder(elem) {
        if($(elem).data('btn-type') == 'confirm') {
            fetch('/mypage/my-folders/' + $(elem).data('folder-id'), {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                }
            }).then(response => {
                return response.json()
            }).then(json => {
                location.href = '/mypage/interest';
            });
        } else {
            $("#folder_delete_modal .btn-primary").data('folder-id', $(elem).data('folder-id'));
            modalOpen("#folder_delete_modal");
        }
    }


    function showEditTool() {
        $(".custom_input .folder_setting").show();
        $(".list_check_img").show();
    }

    function hideEditTool() {
        $(".custom_input .folder_setting").hide();
        $(".list_check_img").hide();
    }

    $(document).on('click', '.productDiv', function() {
        moveInterestProduct(this.nextElementSibling);
    });

    function moveInterestProduct(elem) {
        if($(elem).data('btn-type')=='confirm') {

            let idxes = [];
            $(".itemCheckbox:checked").each(function(){
                idxes.push($(this).val());
            }); 

            fetch('/mypage/move/interest-products', {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                },
                body: JSON.stringify({
                    idxes: idxes,
                    folderId: ($("#folder_move_conf_modal .btn-primary").data('folder-id') ?? ''),
                })
            }).then(response => {
                return response.json();
            }).then(json => {
                location.reload();
            })

        }else {
            if($(".itemCheckbox:checked").length > 0){
                $("#folder_move_conf_modal .btn-primary").data('folder-id', $(elem).data('folder-id'));
                modalOpen('#folder_move_conf_modal');
            }
        }
    }

    function removeInterestProduct(elem) {
        if($(elem).data('btn-type')=='confirm') {

            let idxes = [];
            $(".itemCheckbox:checked").each(function(){
                idxes.push($(this).val());
            }); 

            fetch('/mypage/interest-products', {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                },
                body: JSON.stringify({
                    idxes: idxes
                })
            }).then(response => {
                return response.json()
            }).then(json => {
                location.reload();
            })
        } else {
            if($(".itemCheckbox:checked").length > 0){
                modalOpen('#product_remove_conf_modal');
            }
        }
    }
</script>