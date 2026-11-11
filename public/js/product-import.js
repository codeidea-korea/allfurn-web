/* Shared by desktop and mobile registration. Loading a template never saves it. */
window.ProductImport = (function () {
    let dirty = false;
    let editorReady = false;
    let propertiesReady = false;

    function detailHtml(html) {
        const template = document.createElement('template');
        template.innerHTML = html || '';
        // Removing an imported editor image must not delete the source attachment.
        template.content.querySelectorAll('img[data-idx]').forEach(img => img.removeAttribute('data-idx'));
        return template.innerHTML;
    }

    function initializeEditor(editor) {
        if (!copiedProduct || editorReady) return;
        editor.html.set(detailHtml(copiedProduct.product_detail));
        editorReady = true;
    }

    function finishFields(product) {
        $('#categoryIdx').data('category_idx', product.category_idx).text(product.category);
        $('[name="is_new_product"], .is_new_product').val(product.is_new_product);
        $('[name="payment"]').val(product.pay_type);
        $('[name="payment_text"]').val(product.pay_type_text);
        $('[name="product_code"]').val(product.product_code);
        ['pay', 'delivery', 'return', 'order'].forEach(function (name, index) {
            const selector = 'order-info0' + (index + 1);
            const value = product['is_' + name + '_notice'];
            $('input[type="hidden"][name="' + selector + '"], .' + selector).val(value);
            $('#' + name + '_notice').val(product[name + '_notice'] || '');
        });
        $('#order_title').val(product.order_title || '');
        $('#order_content').val(product.order_content || '');
    }

    function appendFields(form) {
        if (!copiedProduct) return;
        form.set('copy_source_idx', copySourceIdx);
        // These inputs are hidden in the current registration UI. Preserve their
        // values instead of the defaults used by ordinary new registration.
        ['price_text', 'pay_type', 'pay_type_text', 'product_code', 'is_new_product', 'delivery_info', 'auth_info',
            'is_pay_notice', 'pay_notice', 'is_delivery_notice', 'delivery_notice',
            'is_return_notice', 'return_notice', 'is_order_notice', 'order_title', 'order_content'
        ].forEach(key => form.set(key, copiedProduct[key] == null ? '' : copiedProduct[key]));
    }

    function canSave() {
        if (!copiedProduct || (editorReady && propertiesReady)) return true;
        alert('상품 정보를 불러오는 중입니다. 잠시 후 다시 시도해주세요.');
        return false;
    }

    $(function () {
        const dialog = document.getElementById('product-import-dialog');
        if (!dialog) return;
        const search = dialog.querySelector('input[type="search"]');
        const submit = dialog.querySelector('.import-submit');
        let previousOverflow = '';
        let opener;
        $(document).on('click', '[data-open-product-import]', function () {
            opener = this;
            previousOverflow = document.body.style.overflow;
            document.body.style.overflow = 'hidden';
            dialog.showModal();
            search.focus();
        });
        dialog.querySelector('[data-import-close]').addEventListener('click', () => dialog.close());
        dialog.addEventListener('close', function () {
            document.body.style.overflow = previousOverflow;
            if (opener) opener.focus();
        });
        search.addEventListener('input', function () {
            const query = search.value.trim().toLocaleLowerCase();
            let count = 0;
            dialog.querySelectorAll('.import-choice').forEach(function (row) {
                row.hidden = !row.querySelector('.import-name').textContent.toLocaleLowerCase().includes(query);
                if (row.hidden) row.querySelector('input').checked = false;
                else count++;
            });
            const empty = dialog.querySelector('#product-import-empty');
            empty.hidden = count > 0;
            empty.textContent = query ? '검색 결과가 없습니다.' : '불러올 상품이 없습니다.';
            submit.disabled = !dialog.querySelector('input[type="radio"]:checked');
        });
        dialog.addEventListener('change', function () {
            submit.disabled = !dialog.querySelector('input[type="radio"]:checked');
        });
        submit.addEventListener('click', function () {
            const selected = dialog.querySelector('input[type="radio"]:checked');
            if (!selected) return;
            const hasInput = dirty || copiedProduct || Number(productIdx) > 0 || $('#form-list01').val().trim() || $('.product-img__add, #optsArea .form__list-wrap').length;
            if (hasInput && !confirm('현재 입력한 내용을 선택한 상품 정보로 바꾸시겠습니까?')) return;
            window.location.assign('/product/registration?copy=' + encodeURIComponent(selected.value));
        });
        $('.product_reg').on('input change click', function (event) {
            if (!$(event.target).closest('#product-import-dialog, [data-open-product-import]').length) dirty = true;
        });
    });

    return {
        detailHtml, initializeEditor, finishFields, appendFields, canSave,
        propertiesLoaded: function () { propertiesReady = true; },
        propertiesFailed: function () { alert('상품 속성을 불러오지 못했습니다. 새로고침 후 다시 시도해주세요.'); }
    };
})();
