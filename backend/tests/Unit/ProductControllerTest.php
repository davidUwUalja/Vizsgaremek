<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Http\Resources\ProductResource;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_returns_all_products()
    {
        $products = Product::factory()->count(3)->create();

        $response = $this->getJson('/products');

        $response->assertStatus(200);
        $response->assertJsonCount(3, 'data');
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'price',
                    'created_at',
                    'updated_at',
                ]
            ]
        ]);
    }

    public function test_show_returns_single_product()
    {
        $product = Product::factory()->create();

        $response = $this->getJson('/products' . $product->id);

        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
            ]
        ]);
    }

    public function test_show_returns_404_when_product_not_found()
    {
        $response = $this->getJson('/products/999');

        $response->assertStatus(404);
        $response->assertJson([
            'message' => 'Termék nem található'
        ]);
    }

    public function test_store_creates_new_product()
    {
        $productData = [
            'name' => 'Test Product',
            'description' => 'This is a test product',
            'price' => 19.99,
            'stock' => 10
        ];

        $response = $this->postJson('/products', $productData);

        $response->assertStatus(201);
        $response->assertJson([
            'data' => [
                'name' => 'Test Product',
                'price' => 19.99,
            ]
        ]);
        $this->assertDatabaseHas('products', [
            'name' => 'Test Product',
            'price' => 19.99
        ]);
    }

    public function test_store_validates_request()
    {

        $response = $this->postJson('/products', $invalidProductData);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['name', 'price']);
    }

    public function test_update_modifies_existing_product()
    {
        $product = Product::factory()->create();
        $updatedData = [
            'name' => 'Updated Product Name',
            'price' => 29.99
        ];

        $response = $this->putJson('/products' . $product->id, $updatedData);

        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'id' => $product->id,
                'name' => 'Updated Product Name',
                'price' => 29.99
            ]
        ]);
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'Updated Product Name',
            'price' => 29.99
        ]);
    }

    public function test_update_validates_request()
    {
        $product = Product::factory()->create();
        $invalidData = [
            'price' => 'not-a-number'
        ];

        $response = $this->putJson('/products' . $product->id, $invalidData);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['price']);
    }

    public function test_destroy_deletes_product()
    {
        $product = Product::factory()->create();

        $response = $this->deleteJson('/products' . $product->id);

        $response->assertStatus(204);
        $this->assertDatabaseMissing('products', [
            'id' => $product->id
        ]);
    }
    
    public function test_destroy_returns_404_when_product_not_found()
    {
        $response = $this->deleteJson('/products/999');
        
        $response->assertStatus(404);
    }
}