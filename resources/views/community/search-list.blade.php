@forelse($searches as $search)
<div class="search-list__item">
    <a href="javascript:void(0)" onclick="doSearch('{{$search->keyword}}')" class="search-list__target">{{$search->keyword}}</a>
    <a href="javascript:void(0)" onclick="deleteSearchList({{$search->idx}})" class="search-list__icon ico__delete12"></a>
</div>
@empty
    <p class="search-list--nodata">최근 검색한 내역이 없습니다.</p>
@endforelse

    <script>
        
        $(document).on('keyup', '#community_search_keyword', function(evt) {
            
            if (evt.key === 'Enter') { // enter key
                doSearch(evt.currentTarget.value);
            }
            
        });
        
        // 키워드 삭제
        const deleteSearchList = searchIdx => {
            fetch("/community/search-keyword/" + searchIdx, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                }
            }).then(response => {
                return response.json();
            }).then(json => {
                if (json.result === 'success') {
                    refreshSearchKeyword();
                }
            })
        }
        // 키워드 검색
        const doSearch = keyword => {
            location.replace("/community?" + new URLSearchParams({keyword: keyword}));
        }
        // 검색어 키워드 새로고침
        const refreshSearchKeyword = () => {
            fetch("/community/recent/search-keyword", {
                headers: {
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                }
            }).then(response => {
                return response.text();
            }).then(html => {
                document.querySelector('.search-list__wrap').innerHTML = html;
                document.querySelector('.search-list').classList.add('active');
            });
        }


    </script>

