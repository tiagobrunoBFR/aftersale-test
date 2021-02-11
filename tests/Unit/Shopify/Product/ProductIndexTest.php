<?php

namespace Tests\Unit\Shopify\Product;

use App\Service\Shopify\Product;
use GuzzleHttp\Client;
use Tests\TestCase;
use Tests\Helpers\ResponseApi;
use GuzzleHttp\Psr7\Response;

class ProductIndexTest extends TestCase
{
    use ResponseApi;

    /**
     * @test
     */
    public function should_return_products()
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
                "tags" => "",
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
                "tags" => "Algodão"
            ],
            [
                "id" => 4543371706507,
                "title" => "Carteira de couro",
                "body_html" => "Carteira de couro",
                "vendor" => "Send4 Avaliação",
                "product_type" => "",
                "created_at" => "2020-02-12T15:39:43-05:00",
                "handle" => "carteira-de-couro",
                "updated_at" => "2020-12-19T17:21:47-05:00",
                "published_at" => "2020-02-12T15:36:12-05:00",
                "template_suffix" => "",
                "published_scope" => "web",
                "tags" => ""
            ],
            [
                "id" => 4543373377675,
                "title" => "Cinto preto",
                "body_html" => "Cinto preto",
                "vendor" => "Send4 Avaliação",
                "product_type" => "",
                "created_at" => "2020-02-12T15:40:35-05:00",
                "handle" => "cinto-preto",
                "updated_at" => "2020-12-19T17:21:47-05:00",
                "published_at" => "2020-02-12T15:36:12-05:00",
                "template_suffix" => "",
                "published_scope" => "web",
                "tags" => ""
            ],
            [
                "id" => 4543375638667,
                "title" => "Meia social",
                "body_html" => "Meia social",
                "vendor" => "Send4 Avaliação",
                "product_type" => "",
                "created_at" => "2020-02-12T15:41:20-05:00",
                "handle" => "meia-social",
                "updated_at" => "2020-12-19T17:21:48-05:00",
                "published_at" => "2020-02-12T15:36:12-05:00",
                "template_suffix" => "",
                "published_scope" => "web",
                "tags" => ""
            ],
            [
                "id" => 4543380816011,
                "title" => "Rasteira",
                "body_html" => "Rasteira",
                "vendor" => "Send4 Avaliação",
                "product_type" => "",
                "created_at" => "2020-02-12T15:42:54-05:00",
                "handle" => "rasteira",
                "updated_at" => "2020-12-19T17:21:51-05:00",
                "published_at" => "2020-02-12T15:36:12-05:00",
                "template_suffix" => "",
                "published_scope" => "web",
                "tags" => ""
            ],
            [
                "id" => 4543365021835,
                "title" => "Sapato",
                "body_html" => "Sapato simples",
                "vendor" => "Send4 Avaliação",
                "product_type" => "",
                "created_at" => "2020-02-12T15:37:22-05:00",
                "handle" => "sapato",
                "updated_at" => "2020-12-19T17:21:44-05:00",
                "published_at" => "2020-02-12T15:36:12-05:00",
                "template_suffix" => "",
                "published_scope" => "web",
                "tags" => ""
            ]
        ];

        $resultApi = $this->apiResponse('Shopify/Product/ProductIndex.json');
        $response = $this->getMockBuilder(Response::class)->disableOriginalConstructor()->getMock();
        $response->method('getBody')->willReturn($resultApi);

        $client = $this->getMockBuilder(Client::Class)
            ->disableOriginalConstructor()
            ->getMock();

        $client->method('request')
            ->willReturn($response);

        $product = new Product($client);
        $result = $product->index();

        $this->assertEquals(7, count($result->products));

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
}
