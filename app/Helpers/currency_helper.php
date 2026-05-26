<?php

if (! function_exists('currency')) {
    /**
     * Format amount to PHP Peso
     */
    function currency(float $amount, int $decimals = 2): string
    {
        return '₱' . number_format($amount, $decimals);
    }
}

if (! function_exists('currency_symbol')) {
    /**
     * Get currency symbol
     */
    function currency_symbol(): string
    {
        return '₱';
    }
}
