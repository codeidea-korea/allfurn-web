<?php

namespace App\Support;

/** Presentation copies only: never use these rows to persist or calculate orders. */
class EstimatePriceVisibility
{
    public static function hasHidden($rows): bool
    {
        foreach ($rows as $row) {
            if (EstimatePricing::forEstimate($row)['hidden']) return true;
        }
        return false;
    }

    public static function hidden($row, $viewer): bool
    {
        $row = self::attributes($row);
        $viewer = self::attributes($viewer);
        $supplier = !empty($viewer['company_idx'])
            && (string) $viewer['company_idx'] === (string) ($row['response_company_idx'] ?? '')
            && (string) ($viewer['type'] ?? '') === (string) ($row['response_company_type'] ?? '');

        return isset($row['is_price_open']) && (string) $row['is_price_open'] !== '1' && !$supplier;
    }

    public static function forViewer($rows, $viewer): array
    {
        $result = [];
        $hasHidden = false;
        foreach ($rows as $row) {
            $copy = clone $row;
            $copy->price_hidden = self::hidden($row, $viewer);
            if ($copy->price_hidden) {
                $hasHidden = true;
                foreach (self::attributes($copy) as $key => $value) {
                    // Freight is a separate charge, not the undisclosed product price.
                    if (in_array($key, ['is_price_open', 'price_hidden', 'product_delivery_price'], true)) continue;
                    if (in_array($key, ['product_option_json', 'product_option', 'option_json'], true)) {
                        $options = is_string($value) ? json_decode($value, true) : $value;
                        $copy->$key = json_encode(self::withoutPrices(is_array($options) ? $options : []), JSON_UNESCAPED_UNICODE);
                    } elseif (strpos($key, 'price') !== false) {
                        $copy->$key = strpos($key, 'text') !== false ? '업체 협의' : null;
                    }
                }
                $copy->price_text = '업체 협의';
            }
            $result[] = $copy;
        }
        // Group totals are repeated on public rows too; they can reveal hidden prices.
        if ($hasHidden) {
            foreach ($result as $row) $row->estimate_total_price = null;
        }
        return $result;
    }

    private static function withoutPrices(array $values): array
    {
        foreach ($values as $key => $value) {
            if (strpos((string) $key, 'price') !== false) $values[$key] = null;
            elseif (is_array($value)) $values[$key] = self::withoutPrices($value);
        }
        return $values;
    }

    private static function attributes($value): array
    {
        return is_object($value) && method_exists($value, 'getAttributes') ? $value->getAttributes() : (array) $value;
    }
}
