<?php 
namespace App\Helpers;
use NumberFormatter;

class Currency
{
    public function __invoke(...$params)
    {
        return static::format(...$params);
    }
    
    public static function formate($amount, $currency = null)
    {
        $formatter = new NumberFormatter(config('app.local'), NumberFormatter::CURRENCY);

        if ($currency === null) {
            $currency = config('app.currency', 'USD');
        }

        return $formatter->formatCurrency($amount, $currency);
    }

}