<?php

use Illuminate\Support\Facades\Cache;

function get_exchange_rates() {
    $client = new GuzzleHttp\Client();
    $response = $client->request('GET', 'http://hnbex.eu/api/v1/rates/daily/');
    return $response;
}

function get_EUR_exchange_rate()
{
    if (Cache::has('EUR_exchange_rate')) {
        $eur = Cache::get('EUR_exchange_rate');
    } else {
        $response = get_exchange_rates();
        $eur = 7.46;
        if($response->getStatusCode() == 200) {
            $json = json_decode($response->getBody(), true);
            foreach ($json as $item) {
                if($item["currency_code"] === "EUR") {
                    $eur = $item["median_rate"];
                    Cache::put('EUR_exchange_rate', $eur, 24 * 60);
                }
            }
        }
    }
    return $eur;
}

function get_USD_exchange_rate()
{
    if (Cache::has('USD_exchange_rate')) {
        $usd = Cache::get('USD_exchange_rate');
    } else {
        $response = get_exchange_rates();
        $usd = 7.01;
        if($response->getStatusCode() == 200) {
            $json = json_decode($response->getBody(), true);
            foreach ($json as $item) {
                if($item["currency_code"] === "USD") {
                    $usd = $item["median_rate"];
                    Cache::put('USD_exchange_rate', $usd, 24 * 60);
                }
            }
        }
    }
    return $usd;
}