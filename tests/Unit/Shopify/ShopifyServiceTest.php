<?php

namespace Tests\Unit\Shopify;

use App\Service\Shopify\Product;
use App\Service\Shopify\ShopifyService;
use PHPUnit\Framework\TestCase;

class ShopifyServiceTest extends TestCase
{
    private $shopify;
    public function setUp(): void
    {
        parent::setUp();
        $this->shopify = new ShopifyService('test');
    }

    /**
     * @test
     */
    public function shuold_return_base_url_correct()
    {

        $baseUrl = $this->shopify->baseUrl('test');

        $expect = 'https://test.myshopify.com/admin/api/2021-01';

        $this->assertEquals($expect, $baseUrl);
    }

    /**
     * @test
     */
    public function should_return_instance_product()
    {
        $product = $this->shopify->product();

        $this->assertInstanceOf(Product::class, $product);
    }


}
