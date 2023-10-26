<?php

namespace App\Services;

class CurrencyConversionService
{
    private CurrencyRateService $rateService;

    public function __construct(CurrencyRateService $currencyRateService)
    {
        $this->rateService = $currencyRateService;
    }

    public function convert($amount, $fromCurrency, $toCurrency)
    {
        // Conversion rate from USD to RUB
        // date format is Y-m-d
        $exchangeRate = $this->rateService->getCurrencyRate()->rate;

        if ($fromCurrency === 'USD' && $toCurrency === 'RUB') {
            return $amount * $exchangeRate;
        } elseif ($fromCurrency === 'RUB' && $toCurrency === 'USD') {
            return $amount / $exchangeRate;
        } else {
            return $amount;
        }
    }
}