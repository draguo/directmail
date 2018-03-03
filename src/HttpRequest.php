<?php

namespace Draguo\DirectMail;

use GuzzleHttp\Client;

trait HttpRequest
{
    protected function post($uri, $params = [])
    {
        $client = new Client();

        $result = $client->post($uri, [
            'json' => $params,
        ])->getBody()->getContents();

        return json_decode($result);
    }

    protected function get($uri, $params = [])
    {
        $client = new Client();
        return $client->get($uri, [
            'query' => $params,
        ])->getBody()->getContents();
    }
}
