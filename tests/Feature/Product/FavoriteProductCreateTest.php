<?php

namespace Tests\Feature\Product;

use App\Models\FavoriteProduct;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FavoriteProductCreateTest extends TestCase
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
    public function should_return_status_code_201_and_favorite_product_created()
    {
        $data = [
            'product_id' => '23423423'
        ];

        $response = $this->json('POST','api/favorite-products', $data);
        $response->assertStatus(201);
        $result = json_decode($response->content());
        $this->assertEquals($data['product_id'], $result->favorite_product->product_id);
        $this->assertEquals($this->user->id, $result->favorite_product->user_id);
    }

    /**
     * @test
     */
    public function should_return_status_code_422_when_proudct_id_is_blank()
    {
        $data = [
            'product_id' => ''
        ];

        $response = $this->json('POST','api/favorite-products', $data);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('product_id');
    }

    /**
     * @test
     */
    public function should_return_status_code_422_when_proudct_favorite_exists_in_database()
    {
        $data = [
            'product_id' => '1234'
        ];

        FavoriteProduct::factory()->create(['product_id' => 1234, 'user_id' => $this->user->id]);

        $response = $this->json('POST','api/favorite-products', $data);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('product_id');
    }
}
