<?php


namespace App\Service\Shopify;


use GuzzleHttp\Client;

class Product
{
    const PRODUCT_ENDPOINT = 'products.json';

    private $client;
    private $baseUrl;
    private $password;

    public function __construct($client)
    {
        $this->client = $client;
        $this->baseUrl = env('SHOPIFY_BASE_URL');
        $this->password = env('SHOPIFY_PASSWORD');
    }

    public function index($ids = null)
    {
        $params = [
            'ids' => $this->convertFromArrayToString($ids)
        ];

        $response = $this->client->request('GET', self::PRODUCT_ENDPOINT, [
            'query' => $params,
        ]);

        return json_decode($response->getBody());
    }

    public function convertFromArrayToString($array)
    {
        if (!$array) {
            return null;
        }

        return implode(",", $array);
    }
}
