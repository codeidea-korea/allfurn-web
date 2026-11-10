<style>
    .opt_result_area .product-choice { width: 100%; box-sizing: border-box; margin: 12px 0; padding: 16px; border: 1px solid #dadde0; border-radius: 5px; background: #f7f7f7; }
    .product-choice-heading, .product-choice-footer { display: flex; align-items: center; justify-content: space-between; gap: 12px; }
    .product-choice-heading { margin-bottom: 12px; }
    .product-choice-heading .ico_opt_remove { flex: 0 0 32px; height: 32px; padding: 0; border: 0; background: transparent; font-size: 24px; line-height: 1; color: #666; cursor: pointer; }
    .product-choice-details { display: flex; flex-direction: column; gap: 10px; }
    .product-choice-line { display: flex; align-items: flex-start; justify-content: space-between; gap: 16px; }
    .product-choice-line > :first-child { min-width: 0; overflow-wrap: anywhere; }
    .product-choice-price { flex-shrink: 0; white-space: nowrap; text-align: right; }
    .product-choice-footer { margin-top: 16px; padding-top: 12px; border-top: 1px solid #ddd; }
    .product-choice-quantity { display: flex; flex-shrink: 0; border: 1px solid #dadde0; border-radius: 4px; background: white; }
    .product-choice-quantity button { width: 36px; height: 38px; padding: 0; border: 0; background: transparent; font-size: 20px; text-align: center; cursor: pointer; }
    .product-choice-quantity input { width: 42px; height: 38px; padding: 0; text-align: center; border: 0; border-left: 1px solid #dadde0; border-right: 1px solid #dadde0; }
    .product-choice .selection__price { font-weight: 600; text-align: right; overflow-wrap: anywhere; }
    #requestEstimateProductCount[readonly] { background: #f7f7f7; }
</style>
<script src="/js/product-options.js?v={{ filemtime(public_path('js/product-options.js')) }}"></script>
<script>
    var productOptions = createProductOptions({
        basePrice: {{ productIsInquiryPrice($data['detail']) ? 0 : (float) $data['detail']->price }},
        inquiry: {{ productIsInquiryPrice($data['detail']) ? 'true' : 'false' }}
    });
    function reCal() { return productOptions.recalculate(); }
</script>
