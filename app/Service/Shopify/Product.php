<?php


namespace App\Service\Shopify;


use GuzzleHttp\Client as Client;

class Product
{
   const INDEX_URL = '/products.json';


    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function index()
    {
        $response = $this->client->request('GET', self::INDEX_URL);

        return json_decode($response->getBody()->getContents());
    }
}
