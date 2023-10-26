<?php

namespace App\Services;

use DateTime;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CurrencyRateService
{
    public function setCurrencyRate($date = null): void
    {
        try {
            $url = 'https://www.cbr-xml-daily.ru/daily_json.js';

            if (!is_null($date)) {
                $url = 'https://www.cbr-xml-daily.ru/archive/'.str_replace('-', '/', $date).'/daily_json.js';
            }

            $response = Http::get($url);

            if ($response->successful()) {
                $exchangeRates = $response->json()['Valute']['USD'];

                DB::table('currency_rates')->insert([
                    'currency' => 'USD',
                    'rate' => $exchangeRates['Value'],
                    'date' => $date ?? new DateTime('today'),
                    'created_at' => now()
                ]);
            } else {
                Log::error("Failed to update currency rates for date: ".($date ?? date('Y-m-d')));
            }
        } catch (Exception $e) {
            Log::error(__METHOD__." Updating currency rates on: ".($date ?? date('Y-m-d')), [$e->getMessage()]);
        }
    }

    public function getCurrencyRate($date = null)
    {
        $query = DB::table('currency_rates')->select('rate');

        if (!is_null($date)) {
            $query->whereDate('date', $date);
        } else {
            $query->latest();
        }

        $result = $query->first();

        if (is_null($result)) {
            $this->setCurrencyRate($date);
            return $this->getCurrencyRate($date);
        }

        return $result;
    }

}