<?php

namespace App\APIs;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Arr;


use App\Enums\CoinEnum;

class CoinGeckoApi {
    public function __construct() {
        // Hab kein Auth Key für die Seite, Fake den Response
        // https://docs.coingecko.com/reference/simple-price
        Http::fake([
            'https://pro-api.coingecko.com/api/v3/simple/price?ids=' . CoinEnum::Bitcoin->value . '&*' =>
            Http::response(
                [
                    "bitcoin" => [
                          "eur" => Arr::random([67187.335893657, 63213.7, 68221.942324]),
                          "eur_market_cap" => 0, 
                          "eur_24h_vol" => 0, 
                          "eur_24h_change" => 0, 
                          "last_updated_at" => 0 
                       ] 
                 ],
                200
            ),
            'https://pro-api.coingecko.com/api/v3/simple/price?ids=' . CoinEnum::Euro->value . '&*' =>
            Http::response(
                [
                    "eur" => [
                          "bitcoin" => 0.00001488, 
                          "bitcoin_market_cap" => 0, 
                          "bitcoin_24h_vol" => 0, 
                          "bitcoin_24h_change" => 0, 
                          "last_updated_at" => 0 
                       ] 
                 ],
                200
            ),
        ]);
    }

    public function getExchangeRateFor(CoinEnum $from = CoinEnum::Bitcoin, CoinEnum $to = CoinEnum::Euro): float
    {
        $cacheKey = 'exchange:' . $from->value . ':' . $to->value;

        // Prüfen ob die Information schon bereit steht
        $cacheValue = Cache::get($cacheKey);
        if ($cacheValue) return $cacheValue;

        // API nach aktuellen Daten anfragen
        $response = Http::get('https://pro-api.coingecko.com/api/v3/simple/price?ids=' . $from->value . '&vs_currencies=' . $to->value);

        if (!$response->ok()) {
            // Inform Sentry
            throw new \Exception('Error on data request');
        }

        $result = $response->json()[$from->value][$to->value];

        // Daten für 30 Sekunden wegspeichern, Last und somit Kosten senken
        Cache::put($cacheKey, $result, 30);

        return $result;
    }
}