<div id="content">
    <div class="detail_mo_top write_type">
        <div class="inner">
            <a class="back_img pr-10" href="javascript:history.back()"><svg><use xlink:href="/img/icon-defs.svg#left_arrow"></use></svg></a>
            <h3>좋아요 상품</h3>
            <button class="flex gap-1 border border-stone-200 rounded-2xl py-1 px-3" onclick="modalOpen('#folder_mng_modal')">
                <span class="font-medium">폴더 관리</span>
            </button>
        </div>
    </div>
 

    <div class="flex items-center mt-3 my_like_tab_wrap gap-4 border-b border-slate-200 px-4">
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


    <div class="inner ">
        <div class="mt-4">
            <div class="sub_filter">
                <div class="filter_box">
                    <button class="{{ request()->input('categories') != null ? 'on' : '' }}" onclick="modalOpen('#filter_category-modal')">카테고리 <b class="txt-primary">{{ request()->query('categories') != null ? count(explode(',', request()->query('categories'))) : '' }}</b></button>
                </div>
            </div>
        </div>

        <div class="my_like_tab_section pt-1" style="display: block;">
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
    </div>


    <!-- 폴더관리 모달 -->
    <div class="modal" id="folder_mng_modal">
        <div class="modal_bg" onclick="modalClose('#folder_mng_modal')"></div>
        <div class="modal_inner inner_full">
            <div class="modal_body">
                <div class="detail_mo_top write_type">
                    <div class="inner">
                        <a class="back_img pr-10" href="javascript:;" onclick="modalClose('#folder_mng_modal')"><svg><use xlink:href="/img/icon-defs.svg#left_arrow"></use></svg></a>
                        <h3>폴더 관리</h3>
                        <button class="flex gap-1 border border-stone-200 rounded-2xl py-1 px-3" onclick="addFolder(this)" data-btn-type='modal'>
                            <span class="font-medium">폴더 추가</span>
                        </button>
                    </div>
                </div>
                <div class="p-4">
                    <ul>
                        @foreach($folders as $folder)
                            <li class="flex items-center justify-between py-2 border-b border-slate-100">
                                <p class="font-semibold text-base folder_name">{{ $folder->name }}</p>
                                <div class="flex items-center flex-shrink txt-gray">
                                    <button class="px-2 py-1" onclick="updateFolder(this)" data-folder-id="{{ $folder->idx }}" data-btn-type="modal">이름 변경</button>
                                    <span class="block h-4 border-r border-slate-200"></span>
                                    <button class="px-2 py-1" onclick="deleteFolder(this)" data-folder-id="{{ $folder->idx }}" data-btn-type='modal'>삭제</button>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- 폴더관리 > 추가 모달 -->
    <div class="modal" id="folder_add_modal">
        <div class="modal_bg" onclick="modalClose('#folder_add_modal')"></div>
        <div class="modal_inner modal-md">
            <button class="close_btn" onclick="modalClose('#folder_add_modal')"><svg class="w-11 h-11"><use xlink:href="/img/icon-defs.svg#Close"></use></svg></button>
            <div class="modal_body p-4">
                <h4 class="modal_tit shrink-0">폴더 추가</h4>
                <div class="my-4">
                    <input type="" class="input-form w-full" placeholder="폴더명을 입력해주세요." name="add_folder_name">
                </div>
                <button class="btn btn-primary w-full" onclick="addFolder(this)" data-btn-type='confirm'>완료</button>
            </div>
        </div>
    </div>

    <!-- 폴더관리 > 수정 모달 -->
    <div class="modal" id="folder_modify_modal">
        <div class="modal_bg" onclick="modalClose('#folder_modify_modal')"></div>
        <div class="modal_inner modal-md">
            <button class="close_btn" onclick="modalClose('#folder_modify_modal')"><svg class="w-11 h-11"><use xlink:href="/img/icon-defs.svg#Close"></use></svg></button>
            <div class="modal_body p-4">
                <h4 class="modal_tit shrink-0">폴더 이름 변경</h4>
                <div class="my-4">
                    <input type="" class="input-form w-full" placeholder="폴더명을 입력해주세요." name="update_folder_name">
                </div>
                <button class="btn btn-primary w-full" onclick="updateFolder(this)" data-folder-id='' data-btn-type="confirm">완료</button>
            </div>
        </div>
    </div>

    <!-- 폴더관리 > 삭제 모달 -->
    <div class="modal" id="folder_delete_modal">
        <div class="modal_bg" onclick="modalClose('#folder_delete_modal')"></div>
        <div class="modal_inner modal-md">
            <button class="close_btn" onclick="modalClose('#folder_delete_modal')"><svg class="w-11 h-11"><use xlink:href="/img/icon-defs.svg#Close"></use></svg></button>
            <div class="modal_body p-4">
                <p class="text-center py-4">폴더를 삭제하시겠습니까?<br/>폴더에 담긴 상품도 함께 삭제됩니다.</p>
                <div class="flex gap-2 justify-center">
                    <button class="btn w-full btn-primary-line mt-5" onclick="modalClose('#folder_delete_modal')">취소</button>
                    <button class="btn w-full btn-primary mt-5" onclick="deleteFolder(this)" data-btn-type="confirm" data-folder-id=''>확인</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 폴더이동 모달 -->
<div class="modal" id="folder_move_modal">
    <div class="modal_bg" onclick="modalClose('#folder_move_modal')"></div>
    <div class="modal_inner modal-md" style="width:560px;">
        <div class="modal_body p-4">
            <div class="py-2">
                <div class="flex gap-4">
                    <p class="text-lg font-bold">폴더 이동</p>
                </div>
                <div class="move_wrap mt-5">
                    <div class="flex items-center justify-between py-3 border-b">
                        <div class="flex items-center gap-3">
                            <p>전체</p>
                            <p>[ 상품 <span>{{ $countAll }}</span>개 보유 ]</p>
                        </div>
                        <button class="text-gray-400 font-medium"  onclick="modalOpen('#folder_move_conf_modal')">이동</button>
                    </div>
                    @foreach($folders as $folder)
                        <div class="flex items-center justify-between py-3 border-b">
                            <div class="flex items-center gap-3">
                                <p>{{ $folder->name }}</p>
                                <p>[ 상품 <span>{{ $folder->product_count >= 1000 ? '999+' : ($folder->product_count < 1 ? 0 : $folder->product_count)}}</span>개 보유 ]</p>
                            </div>
                            <button class="text-gray-400 font-medium" onclick="moveInterestProduct(this)" data-btn-type="modal" data-folder-id="{{$folder->idx}}">이동</button>
                        </div>
                    @endforeach
                </div>
                <div class="flex justify-center">
                    <button class="btn btn-primary w-1/2 mt-8" onclick="modalClose('#folder_move_modal')">저장</button>
                </div> 
            </div>
        </div>
    </div>
</div>

<!-- 폴더이동 모달 -->
<div class="modal" id="folder_move_conf_modal">
    <div class="modal_bg" onclick="modalClose('#folder_move_conf_modal')"></div>
    <div class="modal_inner modal-md" style="width:360px;">
        <div class="modal_body p-4">
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

<script>
    $(document).ready(function() {
        //카테고리 선택시
        @if(request()->input('categories') != null)
            let selectedCategories = [{{ request()->input('categories') }}];
            
            $("#filter_category-modal .check-form").each(function() {
                if(selectedCategories.indexOf(parseInt($(this).attr("id"))) != -1) {
                    $(this).prop('checked', true);
                }
            });

        @endif
    });

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

    $(document).on('click', '.zzim_btn', function() {
        location.reload();
    });

    $(document).on('click', '#filter_category-modal .btn-primary', function() {
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
    })

    const moveToList = page => {
        let bodies = {offset:page};
        const urlSearch = new URLSearchParams(location.search);
        if (urlSearch.get('categories')) bodies.categories = urlSearch.get('categories');
        if (urlSearch.get('folder')) bodies.folder = urlSearch.get('folder');
        location.replace("/mypage/interest?" + new URLSearchParams(bodies));
    }

    function addFolder(elem) {
        if($(elem).data('btn-type')=='confirm') {
            fetch('/mypage/my-folders', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                },
                body: JSON.stringify({
                    adds: [$("[name='add_folder_name']").val()]
                })
            }).then(response => {
                return response.json()
            }).then(json => {
                location.reload();
            })
        } else {
            modalOpen('#folder_add_modal');
        }
    }

    function updateFolder(elem) {
        if($(elem).data('btn-type') == 'confirm') {
            fetch('/mypage/my-folders', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                },
                body: JSON.stringify({
                    updates: [{
                        idx : $("#folder_modify_modal .btn-primary").data('folder-id'),
                        folder_name : $("[name='update_folder_name']").val()
                    }]
                })
            }).then(response => {
                return response.json()
            }).then(json => {
                location.reload();
            })
        } else {
            $("#folder_modify_modal .btn-primary").data('folder-id', $(elem).data('folder-id'));
            $("#folder_modify_modal input").val($(elem).closest('li').find('.folder_name').text());
            modalOpen('#folder_modify_modal');
        }
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