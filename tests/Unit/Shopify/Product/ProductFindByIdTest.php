<?php

namespace Tests\Unit\Shopify\Product;

use App\Exceptions\ShopifyException;
use App\Service\Shopify\Product;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Tests\TestCase;
use Tests\Helpers\ResponseApi;

class ProductFindByIdTest extends TestCase
{
    use ResponseApi;

    /**
     * @test
     */
    public function should_return_products_by_id()
    {
        $datas = [
            [
                "id" => 4543367512203,
                "title" => "Boné preto",
                "body_html" => "Boné preto",
                "vendor" => "Send4 Avaliação",
                "product_type" => "",
                "created_at" => "2020-02-12T15:38:20-05:00",
                "handle" => "bone-preto",
                "updated_at" => "2020-12-19T17:21:45-05:00",
                "published_at" => "2020-02-12T15:36:12-05:00",
                "template_suffix" => "",
                "published_scope" => "web",
                "tags" => ""
            ],
            [
                "id" => 4538642956427,
                "title" => "Camiseta Send4Lovers",
                "body_html" => "",
                "vendor" => "Send4 Avaliação",
                "product_type" => "Camisas",
                "created_at" => "2020-02-11T15:51:18-05:00",
                "handle" => "camiseta-send4lovers",
                "updated_at" => "2020-12-19T16:53:04-05:00",
                "published_at" => "2020-02-11T15:38:34-05:00",
                "template_suffix" => "",
                "published_scope" => "web",
                "tags" => "Algodão",
            ],


        ];

        $ids = [
            '4543367512203',
            '4538642956427'
        ];

        $resultApi = $this->apiResponse('Shopify/Product/ProductIndexFindId.json');
        $response = $this->getMockBuilder(Response::class)->disableOriginalConstructor()->getMock();
        $response->method('getBody')->willReturn($resultApi);

        $client = $this->getMockBuilder(Client::Class)
            ->disableOriginalConstructor()
            ->getMock();

        $client->method('request')
            ->willReturn($response);

        $product = new Product($client);

        $result = $product->index($ids);

        $this->assertEquals(2, count($result->products));

        foreach ($datas as $i => $data) {
            $this->assertEquals($data['id'], $result->products[$i]->id);
            $this->assertEquals($data['title'], $result->products[$i]->title);
            $this->assertEquals($data['body_html'], $result->products[$i]->body_html);
            $this->assertEquals($data['vendor'], $result->products[$i]->vendor);
            $this->assertEquals($data['product_type'], $result->products[$i]->product_type);
            $this->assertEquals($data['created_at'], $result->products[$i]->created_at);
            $this->assertEquals($data['handle'], $result->products[$i]->handle);
            $this->assertEquals($data['updated_at'], $result->products[$i]->updated_at);
            $this->assertEquals($data['published_at'], $result->products[$i]->published_at);
            $this->assertEquals($data['template_suffix'], $result->products[$i]->template_suffix);
            $this->assertEquals($data['published_scope'], $result->products[$i]->published_scope);
            $this->assertEquals($data['tags'], $result->products[$i]->tags);
        }
    }

    /**
     * @test
     */
    public function should_return_throw_exception_shopify()
    {

        $client = $this->getMockBuilder(Client::Class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->expectException(ShopifyException::class);

        $client->method('request')
            ->will($this->throwException(new ShopifyException));

        $product = new Product($client);

        $ids = [
            '4543367512203',
            '4538642956427'
        ];

        $product->index($ids);
    }
}
