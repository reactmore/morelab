<?php

namespace App\Libraries;

/**
 * Currency PHP library
 *
 **/
class Currency
{

    protected $db;

    /**
     * Constructor
     *
     * @access public
     * @param array
     */
    public function __construct()
    {
        helper('custom_helper');
        $this->db =  \Config\Database::connect();
    }

    /**
     * Update Exchange Rates
     *
     * @access public
     */
    public function updateExchangeRates($base = "USD", $service = "fixer", $serviceKey = "")
    {
        $arrayExchangeRates = array();
        if ($service == "fixer" && !empty($serviceKey)) {
            $arrayExchangeRates = $this->fixerIoExchangeRates($base, $serviceKey);
        } elseif ($service == "currencyapi" && !empty($serviceKey)) {
            $arrayExchangeRates = $this->currencyApiNetExchangeRates($base, $serviceKey);
        } elseif ($service == "openexchangerates" && !empty($serviceKey)) {
            $arrayExchangeRates = $this->openExchangeRatesExchangeRates($base, $serviceKey);
        }

        if (!empty($arrayExchangeRates)) {
            foreach ($arrayExchangeRates as $arrayExchangeRate) {
                if (isset($arrayExchangeRate['currency']) && isset($arrayExchangeRate['rate'])) {
                    $this->db->table('currencies')->where('code', clean_str($arrayExchangeRate['currency']))->update(['exchange_rate' => $arrayExchangeRate['rate']]);
                }
            }
        }
    }

    /**
     * fixer.io Currency Converter
     *
     * @access private
     */
    private function fixerIoExchangeRates($base, $serviceKey)
    {
        $ch = curl_init('http://data.fixer.io/api/latest?access_key=' . $serviceKey . '');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        return $this->createRatesArray($response, $base);
    }

    /**
     * currencyapi.net Currency Converter
     *
     * @access private
     */
    private function currencyApiNetExchangeRates($base, $serviceKey)
    {
        $ch = curl_init('https://currencyapi.net/api/v1/rates?key=' . $serviceKey . '&base=USD');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        return $this->createRatesArray($response, $base);
    }

    /**
     * openexchangerates.org Currency Converter
     *
     * @access private
     */
    private function openExchangeRatesExchangeRates($base, $serviceKey)
    {
        $ch = curl_init('https://openexchangerates.org/api/latest.json?app_id=' . $serviceKey . '&base=USD');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        return $this->createRatesArray($response, $base);
    }

    /**
     * openexchangerates.org Currency Converter
     *
     * @access private
     */
    private function createRatesArray($response, $base)
    {
        $arrayRates = array();
        if (!empty($response)) {
            $responseObject = json_decode($response);
            if (!empty($responseObject) && isset($responseObject->rates)) {
                $rates = $responseObject->rates;
                if (isset($rates->$base)) {
                    $baseRate = $rates->$base;
                    foreach ($rates as $key => $value) {
                        $calculatedRate = 1;
                        if (!empty($baseRate)) {
                            $rate = $value / $baseRate;
                            if (empty($rate)) {
                                $rate = 1;
                            }
                            $calculatedRate = number_format($rate, 8, '.', '');
                        }
                        $item = array(
                            'currency' => $key,
                            'rate' => $calculatedRate
                        );
                        array_push($arrayRates, $item);
                    }
                }
            }
        }
        return $arrayRates;
    }
}
