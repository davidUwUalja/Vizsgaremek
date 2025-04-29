<?php
namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_returns_all_products()
    {
        Product::factory()->count(5)->create();

        $response = $this->getJson('/api/products');

        $response->assertStatus(200)
                 ->assertJsonCount(5, 'data');
    }

    public function test_show_returns_product_when_exists()
    {
        $product = Product::factory()->create([
            'name' => 'Teszt Termék',
        ]);

        $response = $this->getJson("/api/products/{$product->id}");

        $response->assertStatus(200)
                 ->assertJsonPath('data.name', 'Teszt Termék');
    }

    public function test_show_returns_404_when_not_found()
    {
        $response = $this->getJson('/api/products/999');

        $response->assertStatus(404)
                 ->assertJson(['message' => 'Termék nem található']);
    }

    public function test_store_creates_product()
    {
        $payload = [
            'name' => 'Új Termék',
            'description' => 'Leírás',
            'price' => 123.45,
            'category' => 'Kategória',
            'material' => 'Anyag',
            'image_url' => 'base64string',
        ];

        $response = $this->postJson('/api/products', $payload);

        $response->assertStatus(201)
                 ->assertJsonPath('data.name', 'Új Termék');

        $this->assertDatabaseHas('products', [
            'name' => 'Új Termék',
            'price' => 123.45,
        ]);
    }

    public function test_update_modifies_product()
    {
        $product = Product::factory()->create([
            'name' => 'Régi',
            'price' => 50.0,
        ]);

        $payload = [
            'name' => 'Frissített',
            'description' => 'Új leírás',
            'price' => 99.99,
            'category' => 'Új kategória',
            'material' => 'Új anyag',
        ];

        $response = $this->putJson("/api/products/{$product->id}", $payload);

        $response->assertStatus(200)
                 ->assertJsonPath('data.name', 'Frissített')
                 ->assertJsonPath('data.price', 99.99);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'Frissített',
        ]);
    }

    public function test_destroy_deletes_product()
    {
        $product = Product::factory()->create();

        $response = $this->deleteJson("/api/products/{$product->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('products', [
            'id' => $product->id,
        ]);
    }
}
