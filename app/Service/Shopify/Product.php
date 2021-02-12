<?php


namespace App\Service\Shopify;


use App\Exceptions\ShopifyException;
use App\Service\FavoriteProductService;
use Illuminate\Support\Facades\Http;

class Product
{
    const PRODUCT_ENDPOINT = '/products.json';

    private $baseUrl;
    private $password;

    public function __construct()
    {
        $this->baseUrl = env('SHOPIFY_BASE_URL');
        $this->password = env('SHOPIFY_PASSWORD');
    }

    public function index($ids)
    {

        try {

            if(count($ids)>0){
                $params = [
                    'ids' => $this->convertFromArrayToString($ids)
                ];

                $response = Http::withHeaders([
                    'Content-Type' => 'application/json',
                    'X-Shopify-Access-Token' => $this->password
                ])->get($this->baseUrl.self::PRODUCT_ENDPOINT, $params);

                return json_decode($response->getBody());
            }

            return [];

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

        if (count($productIds)>0){
            $results = $this->index($productIds);

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

         return null;

    }
}
