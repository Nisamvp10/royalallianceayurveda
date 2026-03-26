<?php

if (!function_exists('money_format_custom')) {
    /**
     * Format a number into currency style.
     *
     * @param float|int $amount       The numeric value
     * @param string    $currency     Currency code (INR, USD, EUR, etc.)
     * @param int       $decimals     Decimal places
     * @param string    $locale       Locale (for formatting style)
     *
     * @return string
     */
    function money_format_custom($amount, $currency = 'INR', $decimals = 2, $locale = 'en_IN')
    {
        if (!is_numeric($amount)) {
            $amount = 0;
        }

        // Use PHP Intl (if installed)
        if (class_exists('NumberFormatter')) {
            $fmt = new \NumberFormatter($locale, \NumberFormatter::CURRENCY);
            $fmt->setAttribute(\NumberFormatter::FRACTION_DIGITS, $decimals);
            return $fmt->formatCurrency($amount, $currency);
        }

        // Fallback if Intl not available
        $symbols = [
            'INR' => '₹',
            'USD' => '$',
            'EUR' => '€',
            'GBP' => '£',
            'JPY' => '¥',
        ];

        $symbol = $symbols[$currency] ?? '';
        return $symbol . number_format($amount, $decimals);
    }
}

if(!function_exists('dicountPrice')) {
    function dicountPrice($price,$type,$compare_price) {
        if($type == 2) {
            $price = $price - ($price * $compare_price / 100);
        }else{
            $price = $price - $compare_price;
        }
        return $price;
    }
}

if(!function_exists('totalDiscount')) {
    function totalDiscount($compare_price,$type,$price) {
        if($type == 2) {
            $amt = $price - ($price * $compare_price / 100);
        }else{
            $amt = $price;
        }
        return $amt;
    }
}


if(!function_exists('calculatePrice')) {
    function calculatePrice($price, $offerValue = 0, $offerType = 0)
    {
        $offerPrice = $price;
        $discount   = 0;

        if ($offerType == 1) {
            // Flat discount
            $discount   = $offerValue;
            $offerPrice = $price - $offerValue;
        } 
        elseif ($offerType == 2) {
            // Percentage discount
            $discount   = ($price * $offerValue) / 100;
            $offerPrice = $price - $discount;
        }

        if ($offerPrice < 0) {
            $offerPrice = 0;
        }

        return [
            'actual_price' => $price,
            'offer_price'  => round($offerPrice, 2),
            'discount'     => round($discount, 2)
        ];
    }
}

