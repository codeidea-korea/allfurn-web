@if(Route::current()->getName() == 'product.create')
<style>
    #product-import-dialog { width: 640px; max-width: calc(100vw - 32px); max-height: 85vh; margin: auto; padding: 24px; border: 0; border-radius: 8px; color: #333; background: white; }
    #product-import-dialog::backdrop { background: rgba(0, 0, 0, .5); }
    #product-import-dialog .import-heading { display: flex; align-items: center; justify-content: space-between; gap: 12px; margin-bottom: 12px; }
    #product-import-dialog h3 { font-size: 20px; font-weight: 700; }
    #product-import-dialog p { margin-bottom: 16px; color: #666; }
    #product-import-search { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 4px; margin-bottom: 12px; }
    #product-import-dialog .import-list { max-height: 40vh; overflow-y: auto; }
    #product-import-dialog .import-choice { display: flex; gap: 12px; align-items: center; padding: 14px 8px; border-bottom: 1px solid #eee; cursor: pointer; overflow-wrap: anywhere; }
    #product-import-dialog .import-choice[hidden] { display: none; }
    #product-import-dialog .import-choice input { appearance: auto; position: static; opacity: 1; width: 18px; height: 18px; flex-shrink: 0; }
    #product-import-dialog small { display: block; margin-top: 4px; color: #777; }
    #product-import-dialog .import-submit { width: 100%; margin-top: 20px; padding: 14px; background: #ff4063; color: white; border-radius: 4px; }
    #product-import-dialog .import-submit:disabled { background: #aaa; cursor: default; }
    #product-import-empty { padding: 24px 8px; text-align: center; }
</style>
<dialog id="product-import-dialog" aria-labelledby="product-import-title">
    <div class="import-heading">
        <h3 id="product-import-title">기존 상품 불러오기</h3>
        <button type="button" data-import-close aria-label="닫기" style="padding: 8px; font-size: 24px;">×</button>
    </div>
    <p>내가 등록한 상품을 선택하면 입력정보를 불러옵니다. 수정 후 새 상품으로 등록할 수 있습니다.</p>
    <input type="search" id="product-import-search" aria-label="상품명 검색" placeholder="상품명을 검색해주세요.">
    <div class="import-list">
        @foreach($productList as $importProduct)
            <label class="import-choice">
                <input type="radio" name="import_product" value="{{ $importProduct->idx }}">
                <span><span class="import-name">{{ $importProduct->name }}</span><small>{{ $importProduct->category }}</small></span>
            </label>
        @endforeach
        <p id="product-import-empty" @if(count($productList)) hidden @endif>불러올 상품이 없습니다.</p>
    </div>
    <button type="button" class="import-submit" disabled>선택한 상품 불러오기</button>
</dialog>
@endif
