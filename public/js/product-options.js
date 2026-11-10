(function (window, $) {
    'use strict';

    window.createProductOptions = function (config) {
        var selections = [];
        var pending = {};
        var nextId = 0;
        var dropdowns = $('[data-product-option]');
        var areas = $('.opt_result_area.ori');
        var requiredGroups = [];
        var quantity = $('#requestEstimateProductCount');
        var quantityBox = quantity.closest('.prod_option');

        dropdowns.filter('.required').each(function () {
            var group = String($(this).attr('data-product-option'));
            if (requiredGroups.indexOf(group) === -1) requiredGroups.push(group);
        });

        function money(value) {
            return Number(value).toLocaleString('ko-KR') + '원';
        }

        function normalizeQuantity(value) {
            return Math.min(999, Math.max(1, parseInt(value, 10) || 1));
        }

        function optionTotal(selection) {
            return selection.options.reduce(function (total, option) {
                return total + option.price;
            }, 0);
        }

        function subtotal(selection) {
            return ((selection.required ? config.basePrice : 0) + optionTotal(selection)) * selection.quantity;
        }

        function resetTitles() {
            dropdowns.each(function () {
                var title = $(this).find('.dropdown__title');
                title.text(title.attr('data-placeholder') + ' 선택');
            });
        }

        function card(selection) {
            var result = $('<div class="option_item option_result product-choice mt-3 mb-3">').attr('data-choice-id', selection.id);
            var heading = $('<div class="product-choice-heading">').appendTo(result);
            $('<strong>').text(selection.required ? '선택 상품' : '추가 옵션').appendTo(heading);
            $('<button type="button" class="ico_opt_remove" aria-label="선택 항목 삭제">').text('×').attr('data-opt_idx', selection.id).appendTo(heading);
            var details = $('<div class="selection__result product-choice-details">').addClass(selection.required ? 'required' : 'add').appendTo(result);
            if (selection.required) {
                $('<div class="product-choice-line">')
                    .append($('<span>').text('상품 기본가'))
                    .append($('<span class="product-choice-price">').text(config.inquiry ? '업체 문의' : money(config.basePrice)))
                    .appendTo(details);
            }
            selection.options.forEach(function (option) {
                var label = $('<span class="selection__text">')
                    .attr('data-name', option.name).attr('data-option_name', option.value)
                    .attr('data-price', option.price).text(option.name + ': ' + option.value);
                var priceText = config.inquiry ? '업체 문의' : (option.price > 0 ? '+' : '') + money(option.price);
                $('<div class="product-choice-line">').append(label)
                    .append($('<span class="product-choice-price">').text(priceText)).appendTo(details);
            });
            var footer = $('<div class="product-choice-footer">').appendTo(result);
            var counter = $('<div class="count_box2 product-choice-quantity">').appendTo(footer);
            $('<button type="button" class="btn_minus" aria-label="수량 감소">').text('−').appendTo(counter);
            $('<input type="text" name="qty_input" inputmode="numeric" maxlength="3" aria-label="선택 항목 수량">')
                .attr('data-opt_idx', selection.id).val(selection.quantity).appendTo(counter);
            $('<button type="button" class="btn_plus" aria-label="수량 증가">').text('+').appendTo(counter);
            $('<p class="selection__price">').text(config.inquiry ? '업체 문의' : money(subtotal(selection))).appendTo(footer);
            return result;
        }

        function render() {
            areas.empty().each(function () {
                var area = $(this);
                selections.forEach(function (selection) { area.append(card(selection)); });
            });
            recalculate();
        }

        function recalculate() {
            var hasRequired = requiredGroups.length > 0;
            var productCount = hasRequired ? selections.reduce(function (sum, selection) {
                return sum + (selection.required ? selection.quantity : 0);
            }, 0) : normalizeQuantity(quantity.val());
            var total = hasRequired ? 0 : config.basePrice * productCount;
            selections.forEach(function (selection) {
                total += subtotal(selection);
                var copies = areas.find('.product-choice[data-choice-id="' + selection.id + '"]');
                copies.find('input[name="qty_input"]').val(selection.quantity);
                copies.find('.selection__price').text(config.inquiry ? '업체 문의' : money(subtotal(selection)));
            });
            // Before choosing a required combination, keep showing the product's starting price.
            if (hasRequired && selections.length === 0) total = config.basePrice;
            quantity.val(productCount).prop('readOnly', hasRequired);
            quantityBox.find('.minus, .plus').prop('disabled', hasRequired);
            quantityBox.find('.name').text(hasRequired ? '총 수량' : '수량');
            var text = config.inquiry ? '업체 문의' : money(total);
            $('.product_price').text(text).data('total_price', config.inquiry ? 0 : total);
            $('._requestEstimateCount').text(productCount + '개');
            $('._requestEstimateTotalPrice, ._requestEstimateTotalPrice2').text(text);
            return { quantity: productCount, total: config.inquiry ? 0 : total };
        }

        function choose(element) {
            var item = $(element);
            var dropdown = item.closest('[data-product-option]');
            var group = String(dropdown.attr('data-product-option'));
            var required = dropdown.hasClass('required');
            var option = {
                group: group,
                valueId: String(item.attr('data-option-value')),
                name: dropdown.find('.dropdown__title').attr('data-placeholder'),
                value: String(item.attr('data-option_name')),
                price: Number(item.attr('data-price')) || 0
            };
            dropdowns.filter('[data-product-option="' + group + '"]').find('.dropdown__title').text(option.value);
            var options;
            if (required) {
                pending[group] = option;
                if (!requiredGroups.every(function (key) { return Object.prototype.hasOwnProperty.call(pending, key); })) return;
                options = requiredGroups.map(function (key) { return pending[key]; });
            } else {
                if (requiredGroups.length && !selections.some(function (selection) { return selection.required; })) {
                    alert('필수 옵션 선택 후 선택해주세요.');
                    dropdowns.filter('[data-product-option="' + group + '"]').find('.dropdown__title').text(option.name + ' 선택');
                    return;
                }
                options = [option];
            }
            var key = JSON.stringify(options.map(function (value) { return [value.group, value.valueId]; }));
            if (required) pending = {};
            resetTitles();
            if (selections.some(function (selection) { return selection.key === key; })) {
                alert('이미 선택한 옵션입니다. 수량을 변경해주세요.');
                return;
            }
            selections.push({ id: ++nextId, key: key, required: required, options: options, quantity: 1 });
            render();
        }

        function updateQuantity(element, change) {
            var input = $(element).is('input') ? $(element) : $(element).siblings('input[name="qty_input"]');
            var id = Number(input.attr('data-opt_idx'));
            var selection = selections.find(function (row) { return row.id === id; });
            if (!selection) return;
            selection.quantity = normalizeQuantity(change === 0 ? input.val() : selection.quantity + change);
            recalculate();
        }

        $('body').off('.productOptions')
            .on('click.productOptions', '[data-product-option] .dropdown__item', function () { choose(this); })
            .on('click.productOptions', '.product-choice .btn_minus, .product-choice .btn_plus', function (event) {
                event.preventDefault();
                event.stopPropagation();
                updateQuantity(this, $(this).hasClass('btn_plus') ? 1 : -1);
            })
            .on('input.productOptions change.productOptions', '.product-choice input[name="qty_input"]', function () { updateQuantity(this, 0); })
            .on('click.productOptions', '.product-choice .ico_opt_remove', function (event) {
                event.preventDefault();
                event.stopPropagation();
                var id = Number($(this).attr('data-opt_idx'));
                selections = selections.filter(function (selection) { return selection.id !== id; });
                if (requiredGroups.length && !selections.some(function (selection) { return selection.required; })) {
                    selections = [];
                    pending = {};
                    resetTitles();
                }
                render();
            });
        quantityBox.on('click.productOptions', '.minus, .plus', function (event) {
            event.preventDefault();
            event.stopPropagation();
            if (requiredGroups.length) return;
            quantity.val(normalizeQuantity(normalizeQuantity(quantity.val()) + ($(this).hasClass('plus') ? 1 : -1)));
            recalculate();
        });
        quantity.on('input.productOptions change.productOptions', recalculate);
        recalculate();

        return {
            recalculate: recalculate,
            isReady: function () {
                return requiredGroups.length === 0 || selections.some(function (selection) { return selection.required; });
            },
            serialize: function () {
                var result = [];
                selections.forEach(function (selection) {
                    selection.options.forEach(function (option) {
                        result.push({
                            optionName: option.name,
                            optionValue: [{ propertyName: option.value, idx: selection.id, count: selection.quantity, price: option.price }],
                            required: '0'
                        });
                    });
                });
                return result;
            }
        };
    };
})(window, jQuery);
