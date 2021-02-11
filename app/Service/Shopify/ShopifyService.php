<?php


namespace App\Service\Shopify;


use GuzzleHttp\Client as Client;

class ShopifyService
{

    private $shop;
    private $client;
    public function __construct(string $shop)
    {
        $this->shop = $shop;

        $this->client = new Client([
            'base_uri' => $this->baseUrl($shop),
            'headers' => [
                'Content-Type' => 'application/json',
                'X-Shopify-Access-Token' => env('SHOPIFY_PASSWORD')
            ],
        ]);
    }

    public function baseUrl(string $shop)
    {
        return "https://$shop.myshopify.com/admin/api/2021-01";
    }

    public function product()
    {
        return new Product($this->client);
    }
}
