<?php

namespace Tests\Unit\Shopify;

use App\Service\Shopify\Product;
use App\Service\Shopify\ShopifyService;
use PHPUnit\Framework\TestCase;

class ShopifyServiceTest extends TestCase
{

    /**
     * @test
     */
    public function should_return_instance_product()
    {
        $this->shopify = new ShopifyService();

        $product = $this->shopify->product();

        $this->assertInstanceOf(Product::class, $product);
    }
}
