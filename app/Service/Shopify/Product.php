<?php


namespace App\Service\Shopify;


use App\Exceptions\CreditCardException;
use App\Exceptions\ShopifyException;
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

    public function index(array $ids)
    {
        try {

            $params = [
                'ids' => $this->convertFromArrayToString($ids)
            ];

            $response = $this->client->request('GET', self::PRODUCT_ENDPOINT, [
                'query' => $params,
            ]);

            return json_decode($response->getBody());
        } catch (\Exception $exception) {
            throw new ShopifyException($exception->getMessage());
        }


    }

    public function convertFromArrayToString($array)
    {
        return implode(",", $array);
    }
}
