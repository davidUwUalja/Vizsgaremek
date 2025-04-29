<?php
namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticate_successful_login()
    {
        $user = User::factory()->create([
            'email' => 'user@example.com',
            'password' => Hash::make('secret123'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'user@example.com',
            'password' => 'secret123',
        ]);

        $response->assertStatus(200)
                 ->assertJsonStructure(['data' => ['token']]);
    }

    public function test_authenticate_fails_with_wrong_credentials()
    {
        User::factory()->create([
            'email' => 'user2@example.com',
            'password' => Hash::make('rightpass'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'user2@example.com',
            'password' => 'wrongpass',
        ]);

        $response->assertStatus(401)
                 ->assertJsonPath('data.message', 'Sikertelen belépés');
    }

    public function test_store_registers_new_user()
    {
        $payload = [
            'name' => 'Új Felhasználó',
            'email' => 'new@example.com',
            'password' => 'pass1234',
        ];

        $response = $this->postJson('/api/register', $payload);

        $response->assertStatus(201)
                 ->assertJsonPath('data.message', "A(z) new@example.com sikeresen regisztrált.");

        $this->assertDatabaseHas('users', [
            'email' => 'new@example.com',
        ]);
    }
}
