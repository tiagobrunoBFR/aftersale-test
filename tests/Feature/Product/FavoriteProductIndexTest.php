<?php

namespace Tests\Feature\Product;

use App\Models\FavoriteProduct;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FavoriteProductIndexTest extends TestCase
{
    use RefreshDatabase;

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

        $response = $this->json('GET', 'api/favorite-products');
        $response->assertStatus(200);
        $result = json_decode($response->content());
        $this->assertEquals(2, count($result->products));
    }
}
