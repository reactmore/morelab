<?php

namespace App\Helpers;

class Request_helper
{
    public function sendRequest($url, $method, $headers = [], $body = [], $connectTimeout = 10, $timeout = 30)
    {
        $curl = service('curlrequest');

        $response = $curl->request($method, $url,  [
            "verify" => false,
            "headers" => $headers,
            'json' => $body,
            'connect_timeout' => $connectTimeout,
            'timeout' => $timeout
        ]);

        $response = [
            'reason' => $response->getReason(),
            'status' => $response->getStatusCode(),
            'content' => json_decode($response->getBody(), true)

        ];

        return $response;
    }
}
