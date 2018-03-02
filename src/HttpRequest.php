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
}
