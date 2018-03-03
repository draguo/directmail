<?php

namespace Draguo\DirectMail;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

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
        try{
            $result = $client->get($uri, [
                'query' => $params,
            ])->getBody()->getContents();
            return $result;
        }catch (RequestException $exception) {
            echo $exception->getResponse()->getBody()->getContents();
        }

    }
}
