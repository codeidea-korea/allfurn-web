<?php

namespace App\Support;

/** Price components used by the request, reply and order screens. */
class EstimatePricing
{
    public static function amount($value): int
    {
        $value = str_replace(',', '', trim((string) $value));
        return is_numeric($value) ? (int) $value : 0;
    }

    public static function options($json): array
    {
        $options = is_string($json) ? json_decode($json, true) : $json;
        $result = [];
        foreach (is_array($options) ? $options : [] as $option) {
            $option = (array) $option;
            $values = [];
            foreach (($option['optionValue'] ?? []) as $value) {
                $value = (array) $value;
                if (!array_key_exists('price', $value)) continue;
                $value['price'] = self::amount($value['price']);
                $value['count'] = max(1, (int) ($value['count'] ?? 1));
                $value['each_price'] = $value['price'] * $value['count'];
                $values[] = $value;
            }
            if ($values) {
                $option['optionValue'] = $values;
                $result[] = $option;
            }
        }
        return $result;
    }

    public static function optionTotal($json): int
    {
        $total = 0;
        foreach (self::options($json) as $option) {
            foreach ($option['optionValue'] as $value) $total += $value['each_price'];
        }
        return $total;
    }

    public static function forEstimate($estimate): array
    {
        $row = is_array($estimate) ? $estimate : (method_exists($estimate, 'getAttributes') ? $estimate->getAttributes() : (array) $estimate);
        $options = self::options($row['product_option_json'] ?? '[]');
        $optionTotal = self::optionTotal($options);
        $count = max(1, (int) ($row['product_count'] ?? 1));
        $responded = !empty($row['response_time']) && strpos($row['response_time'], '0000-00-00') !== 0;
        $storedTotal = self::amount($row['product_total_price'] ?? 0);

        // Requests store base price x quantity. Replies store base + options;
        // product_each_price then holds the separately entered quote adjustment.
        if ($responded) {
            $subtotal = $storedTotal;
            $baseTotal = $subtotal - $optionTotal;
            $adjustment = self::amount($row['product_each_price'] ?? 0);
        } else {
            $baseTotal = $storedTotal;
            if (isset($row['is_price_open']) && (string) $row['is_price_open'] !== '1') $baseTotal = 0;
            $subtotal = $baseTotal + $optionTotal;
            $adjustment = 0;
        }

        return [
            'count' => $count,
            'options' => $options,
            'base_total' => $baseTotal,
            'option_total' => $optionTotal,
            'subtotal' => $subtotal,
            'adjustment' => $adjustment,
            'total' => $subtotal + $adjustment,
            'responded' => $responded,
            'hidden' => (bool) ($row['price_hidden'] ?? (isset($row['is_price_open']) && (string) $row['is_price_open'] !== '1')),
            'inquiry' => $baseTotal <= 0 && $adjustment === 0,
        ];
    }
}
