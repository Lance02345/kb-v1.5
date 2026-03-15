<?php

if (!function_exists('format_currency')) {
    /**
     * Format a number as Kenyan shillings with grouped thousands.
     */
    function format_currency($value, int $decimals = 0): string
    {
        $amount = max(0, (float) $value);
        $formatted = number_format($amount, $decimals, '.', ',');
        return 'Ksh ' . $formatted;
    }
}
