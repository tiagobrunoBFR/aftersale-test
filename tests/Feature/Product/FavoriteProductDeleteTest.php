<?php

namespace Tests\Feature\Product;

use App\Models\FavoriteProduct;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FavoriteProductDeleteTest extends TestCase
{
    use RefreshDatabase;

    private $user;
    public function setUp(): void
    {
        parent::setUp();
        $this->user = $this->signIn();
        $this->withoutJobs();
    }

    /**
     * @test
     */
    public function should_return_status_code_204_and_remove_favorite_product_from_database()
    {
        $favoriteProduct = FavoriteProduct::factory()->create(['user_id' => $this->user->id]);
        $response = $this->json('DELETE','api/favorite-products/'.$favoriteProduct->id);
        $response->assertStatus(204);
    }

    /**
     * @test
     */
    public function should_return_status_404_when_favorite_product_not_exists_in_database()
    {
        $response = $this->json('DELETE','api/favorite-products/100000000000');
        $response->assertStatus(404);
        $this->assertEquals(['error' => 'Favorite product not found'], $response->json());
    }

    public function should_return_status_code_403_when_user_is_not_owner_to_product_favorite()
    {
        $favoriteProduct = FavoriteProduct::factory()->create();

        $response = $this->json('DELETE','api/favorite-products/'.$favoriteProduct->id);
        $response->assertStatus(403);
    }
}
