<?php

namespace Tests\Feature\Product;

use App\Models\FavoriteProduct;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Helpers\ResponseApi;
use Tests\TestCase;
use Illuminate\Support\Facades\Http;

class FavoriteProductIndexTest extends TestCase
{
    use RefreshDatabase, ResponseApi;

    private $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = $this->signIn();
    }

    /**
     * @test
     */
    public function should_return_status_code_200_and_favorite_products_linked_to_the_logged_in_user()
    {
        FavoriteProduct::factory()->create([
            'user_id' => $this->user->id,
            'product_id' => 4543367512203
        ]);

        FavoriteProduct::factory()->create([
            'user_id' => $this->user->id,
            'product_id' => 4538642956427
        ]);

        $resultApi = $this->apiResponse('Shopify/Product/ProductIndexFindId.json');

        $headers = [
            'Content-Type' => 'application/json',
            'X-Shopify-Access-Token' => 'xxxxxxxx'
        ];

        Http::fake([
            'https://send4-avaliacao.myshopify.com/*' => Http::response($resultApi, 200, $headers),
        ]);

        $response = $this->json('GET', 'api/favorite-products');
        $response->assertStatus(200);
        $result = json_decode($response->content());
        $this->assertEquals(2, count($result->products));
    }
}
