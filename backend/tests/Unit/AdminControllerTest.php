<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AdminControllerTest extends TestCase
{
    use RefreshDatabase;

    private function authenticateAdmin()
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        Sanctum::actingAs($admin, ['*']);
    }

    public function test_list_users_returns_all_users()
    {
        $this->authenticateAdmin();

        User::factory()->count(3)->create();

        $response = $this->getJson('/api/admin/users');

        $response->assertStatus(200)
                 ->assertJsonCount(4);
    }

    public function test_create_user_successfully()
    {
        $this->authenticateAdmin();

        $data = [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'password' => 'secret123',
            'role' => 'admin',
        ];

        $response = $this->postJson('/api/admin/users', $data);

        $response->assertStatus(201)
                 ->assertJsonFragment([
                     'name' => 'Jane Doe',
                     'email' => 'jane@example.com',
                     'role' => 'admin',
                 ]);

        $this->assertDatabaseHas('users', [
            'email' => 'jane@example.com',
        ]);
    }

    public function test_update_user_successfully()
    {
        $this->authenticateAdmin();

        $user = User::factory()->create([
            'role' => 'customer',
        ]);

        $data = [
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
            'password' => 'newpassword',
            'role' => 'admin',
        ];

        $response = $this->putJson("/api/admin/users/{$user->id}", $data);

        $response->assertStatus(200)
                 ->assertJsonFragment([
                     'name' => 'Updated Name',
                     'email' => 'updated@example.com',
                     'role' => 'admin',
                 ]);

        $this->assertDatabaseHas('users', [
            'email' => 'updated@example.com',
        ]);
    }

    public function test_delete_user_successfully()
    {
        $this->authenticateAdmin();

        $user = User::factory()->create();

        $response = $this->deleteJson("/api/admin/users/{$user->id}");

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Felhasználó törölve']);

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }
}
