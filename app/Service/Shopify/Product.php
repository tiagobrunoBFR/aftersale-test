<?php


namespace App\Service\Shopify;


use App\Exceptions\ShopifyException;
use App\Service\FavoriteProductService;

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
        $params = [
            'ids' => $this->convertFromArrayToString($ids)
        ];

        try {

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

    public function convertCollection($user_id)
    {
        $favoriteProduct = new FavoriteProductService();

        $productIds = $favoriteProduct->mapArrayProductIds($user_id);
        $results =$this->index($productIds);
        $products = collect();

        foreach ($results->products as $product) {
            $productObj = new \stdClass();
            $productObj->id = $product->id;
            $productObj->title = $product->title;
            $productObj->body_html = $product->body_html;
            $productObj->vendor = $product->vendor;
            $productObj->product_type = $product->product_type;
            $products->push($productObj);
        }

        return $products;
    }
}
