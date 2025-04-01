<?php

namespace Tests\Unit\Http\Controllers;

use App\Http\Controllers\AdminController;
use App\Http\Requests\CreateUserRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminControllerTest extends TestCase
{
    use RefreshDatabase; // Reset the database after each test

    /**
     * Test listing all users
     *
     * @return void
     */
    public function test_list_users()
    {
        // Create test users
        $users = User::factory()->count(3)->create();
        
        // Call the API endpoint
        $response = $this->getJson('/api/admin/users');
        
        // Assert response
        $response->assertStatus(200);
        $response->assertJsonCount(3);
        
        // Verify user data is returned correctly
        $responseData = $response->json();
        $this->assertEquals($users[0]->id, $responseData[0]['id']);
        $this->assertEquals($users[0]->name, $responseData[0]['name']);
        $this->assertEquals($users[0]->email, $responseData[0]['email']);
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
        
        // Call the API endpoint
        $response = $this->postJson('/api/admin/users', $userData);
        
        // Assert response
        $response->assertStatus(201);
        $response->assertJsonFragment([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'role' => 'customer',
        ]);
        
        // Verify user was actually created in the database
        $this->assertDatabaseHas('users', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'role' => 'customer',
        ]);
        
        // Verify password was hashed
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
        // Invalid email and short password
        $userData = [
            'name' => 'Invalid User',
            'email' => 'not-an-email',
            'password' => 'short',
            'role' => 'invalid-role',
        ];
        
        // Call the API endpoint
        $response = $this->postJson('/api/admin/users', $userData);
        
        // Assert validation fails
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['email', 'password', 'role']);
        
        // Verify no user was created
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
        // Create a test user
        $user = User::factory()->create([
            'name' => 'Original Name',
            'email' => 'original@example.com',
            'role' => 'customer',
        ]);
        
        $updateData = [
            'name' => 'Updated Name',
            'role' => 'admin',
        ];
        
        // Call the API endpoint
        $response = $this->putJson("/api/admin/users/{$user->id}", $updateData);
        
        // Assert response
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'name' => 'Updated Name',
            'email' => 'original@example.com', // Email unchanged
            'role' => 'admin',
        ]);
        
        // Verify database was updated
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
        // Create a test user
        $user = User::factory()->create([
            'password' => Hash::make('original-password'),
        ]);
        
        $updateData = [
            'password' => 'new-password123',
        ];
        
        // Call the API endpoint
        $response = $this->putJson("/api/admin/users/{$user->id}", $updateData);
        
        // Assert response
        $response->assertStatus(200);
        
        // Verify password was updated and hashed
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
        
        // Call the API endpoint
        $response = $this->putJson("/api/admin/users/{$nonExistentId}", $updateData);
        
        // Assert 404 Not Found
        $response->assertStatus(404);
    }

    /**
     * Test deleting a user
     *
     * @return void
     */
    public function test_delete_user()
    {
        // Create a test user
        $user = User::factory()->create();
        
        // Verify user exists before deletion
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
        ]);
        
        // Call the API endpoint
        $response = $this->deleteJson("/api/admin/users/{$user->id}");
        
        // Assert response
        $response->assertStatus(200);
        $response->assertJson(['message' => 'Felhasználó törölve']);
        
        // Verify user no longer exists in database
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
        
        // Call the API endpoint
        $response = $this->deleteJson("/api/admin/users/{$nonExistentId}");
        
        // Assert 404 Not Found
        $response->assertStatus(404);
    }

    /**
     * Test validation rules in CreateUserRequest
     *
     * @return void
     */
    public function test_create_user_request_validation()
    {
        // Create a mock request with valid data
        $validData = [
            'name' => 'Valid User',
            'email' => 'valid@example.com',
            'password' => 'password123',
            'role' => 'admin',
        ];
        
        $request = CreateUserRequest::create('/api/admin/users', 'POST', $validData);
        
        // The request should pass validation
        $this->assertTrue($request->authorize());
        $this->assertTrue($request->passes());
        
        // Create a mock request with invalid data
        $invalidData = [
            'name' => '',  // Empty name
            'email' => 'invalid', // Invalid email
            'password' => 'short', // Too short password
            'role' => 'invalid-role', // Invalid role
        ];
        
        $request = CreateUserRequest::create('/api/admin/users', 'POST', $invalidData);
        
        // The request should fail validation
        $this->assertTrue($request->authorize()); // Authorization should still pass
        $this->assertFalse($request->passes()); // But validation should fail
        
        // Check specific validation errors
        $errors = $request->validator->errors()->toArray();
        $this->assertArrayHasKey('name', $errors);
        $this->assertArrayHasKey('email', $errors);
        $this->assertArrayHasKey('password', $errors);
        $this->assertArrayHasKey('role', $errors);
    }
}