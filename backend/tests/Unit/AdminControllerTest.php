<?php

namespace Tests\Unit\Http\Controllers;

use App\Http\Controllers\AdminController;
use App\Http\Requests\CreateUserRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AdminControllerTest extends TestCase
{
    use RefreshDatabase; 

    protected function setUp(): void
    {
        parent::setUp();
        
        $admin = User::factory()->create([
            'role' => 'admin'
        ]);
        
        Sanctum::actingAs($admin, ['admin']);
    }

    /**
     * Test listing all users
     *
     * @return void
     */
    public function test_list_users()
    {
        $users = User::factory()->count(3)->create();
        
        $response = $this->getJson('/admin/users');
        
        $response->assertStatus(200);
        $response->assertJsonCount(4); 
        
        $responseData = $response->json();

        $foundUser = collect($responseData)->firstWhere('id', $users[0]->id);
        $this->assertEquals($users[0]->name, $foundUser['name']);
        $this->assertEquals($users[0]->email, $foundUser['email']);
    }

    /**
     * Test creating a user with valid data
     *
     * @return void
     */
    public function test_create_user_with_valid_data()
    {
        $userData = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'role' => 'customer',
        ];
        
        $response = $this->postJson('/admin/users', $userData);
        
        $response->assertStatus(201);
        $response->assertJsonFragment([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'role' => 'customer',
        ]);
        
        $this->assertDatabaseHas('users', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'role' => 'customer',
        ]);
        
        $user = User::where('email', 'test@example.com')->first();
        $this->assertTrue(Hash::check('password123', $user->password));
    }

    /**
     * Test creating a user with invalid data
     *
     * @return void
     */
    public function test_create_user_with_invalid_data()
    {

        $userData = [
            'name' => 'Invalid User',
            'email' => 'not-an-email',
            'password' => 'short',
            'role' => 'invalid-role',
        ];
        
        $response = $this->postJson('/admin/users', $userData);
        
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['email', 'password', 'role']);
        
        $this->assertDatabaseMissing('users', [
            'name' => 'Invalid User',
        ]);
    }

    /**
     * Test updating a user with valid data
     *
     * @return void
     */
    public function test_update_user_with_valid_data()
    {
        $user = User::factory()->create([
            'name' => 'Original Name',
            'email' => 'original@example.com',
            'role' => 'customer',
        ]);
        
        $updateData = [
            'name' => 'Updated Name',
            'role' => 'admin',
        ];
        
        $response = $this->putJson("/admin/users/{$user->id}", $updateData);
        
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'name' => 'Updated Name',
            'email' => 'original@example.com',
            'role' => 'admin',
        ]);
        
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Updated Name',
            'email' => 'original@example.com',
            'role' => 'admin',
        ]);
    }

    /**
     * Test updating a user's password
     *
     * @return void
     */
    public function test_update_user_password()
    {
        $user = User::factory()->create([
            'password' => Hash::make('original-password'),
        ]);
        
        $updateData = [
            'password' => 'new-password123',
        ];
        
        $response = $this->putJson("/admin/users/{$user->id}", $updateData);
        
        $response->assertStatus(200);

        $updatedUser = User::find($user->id);
        $this->assertTrue(Hash::check('new-password123', $updatedUser->password));
        $this->assertFalse(Hash::check('original-password', $updatedUser->password));
    }

    /**
     * Test updating a non-existent user
     *
     * @return void
     */
    public function test_update_nonexistent_user()
    {
        $nonExistentId = 9999;
        
        $updateData = [
            'name' => 'Will Not Update',
        ];
        
        $response = $this->putJson("/admin/users/{$nonExistentId}", $updateData);
        
        $response->assertStatus(404);
    }

    /**
     * Test deleting a user
     *
     * @return void
     */
    public function test_delete_user()
    {
        $user = User::factory()->create();
        

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
        ]);
        
        $response = $this->deleteJson("/admin/users/{$user->id}");
        
        $response->assertStatus(200);
        $response->assertJson(['message' => 'Felhasználó törölve']);
        
        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
        ]);
    }

    /**
     * Test deleting a non-existent user
     *
     * @return void
     */
    public function test_delete_nonexistent_user()
    {
        $nonExistentId = 9999;
        
        $response = $this->deleteJson("/admin/users/{$nonExistentId}");
        
        $response->assertStatus(404);
    }

    /**
     * Test accessing admin routes without admin role
     *
     * @return void
     */
    public function test_access_denied_without_admin_role()
    {
        $user = User::factory()->create([
            'role' => 'customer'
        ]);
        
        Sanctum::actingAs($user, ['customer']);
        
        $this->getJson('/admin/users')->assertForbidden();
        $this->postJson('/admin/users', [])->assertForbidden();
        $this->putJson('/admin/users/1', [])->assertForbidden();
        $this->deleteJson('/admin/users/1')->assertForbidden();
    }

    /**
     * Test validation rules in CreateUserRequest
     *
     * @return void
     */
    public function test_create_user_request_validation()
    {
        $validData = [
            'name' => 'Valid User',
            'email' => 'valid@example.com',
            'password' => 'password123',
            'role' => 'admin',
        ];
        
        $request = CreateUserRequest::create('/admin/users', 'POST', $validData);
        
        $this->assertTrue($request->authorize());
        $this->assertTrue($request->passes());
        
        $invalidData = [
            'name' => '',  
            'email' => 'invalid', 
            'password' => 'short', 
            'role' => 'invalid-role', 
        ];
        
        $request = CreateUserRequest::create('/admin/users', 'POST', $invalidData);
        
        $this->assertTrue($request->authorize()); 
        $this->assertFalse($request->passes()); 
        
        $errors = $request->validator->errors()->toArray();
        $this->assertArrayHasKey('name', $errors);
        $this->assertArrayHasKey('email', $errors);
        $this->assertArrayHasKey('password', $errors);
        $this->assertArrayHasKey('role', $errors);
    }
}