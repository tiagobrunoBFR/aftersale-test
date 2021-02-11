<?php


namespace App\Service\Shopify;


use GuzzleHttp\Client;

class ShopifyService
{
    private $client;
    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => env('SHOPIFY_BASE_URL'),
            'headers' => [
                'Content-Type' => 'application/json',
                'X-Shopify-Access-Token' => env('SHOPIFY_PASSWORD')
            ],
        ]);
    }

    public function product()
    {
        return new Product($this->client);
    }
}
