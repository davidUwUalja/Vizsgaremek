<?php

namespace Tests\Unit;

use App\Http\Controllers\UserController;
use App\Http\Requests\changePasswordRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Mockery;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $controller;

    protected function setUp(): void
    {
        parent::setUp();
        $this->controller = new UserController();
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function testIndex()
    {
        Gate::shouldReceive('authorize')
            ->once()
            ->with('list-users')
            ->andReturn(true);

        $users = User::factory()->count(3)->create();
        
        $response = $this->controller->index();
        
        $this->assertEquals($users->count(), count($response->collection));
        $this->assertEquals($users->first()->id, $response->collection[0]->id);
    }

    public function testProfile()
    {
        $user = User::factory()->create();
        
        $request = Mockery::mock(Request::class);
        $request->shouldReceive('user')
            ->once()
            ->andReturn($user);
        
        $response = $this->controller->profile($request);
        
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals($user->toArray(), json_decode($response->getContent(), true));
    }

    public function testUpdate()
    {
        $user = User::factory()->create([
            'name' => 'Old Name',
            'email' => 'old@example.com'
        ]);
        
        $userData = [
            'name' => 'New Name',
            'email' => 'new@example.com'
        ];
        
        $request = Mockery::mock(UpdateUserRequest::class);
        $request->shouldReceive('user')
            ->once()
            ->andReturn($user);
        $request->shouldReceive('validated')
            ->once()
            ->andReturn($userData);
        
        $response = $this->controller->update($request);
        
        $this->assertInstanceOf(JsonResponse::class, $response);
        $responseData = json_decode($response->getContent(), true);
        $this->assertEquals('Profil sikeresen frissítve', $responseData['message']);
        $this->assertEquals('New Name', $responseData['user']['name']);
        $this->assertEquals('new@example.com', $responseData['user']['email']);
    }

    public function testChangePasswordSuccess()
    {
        $plainPassword = 'old-password';
        $user = User::factory()->create([
            'password' => Hash::make($plainPassword)
        ]);
        
        $request = Mockery::mock(changePasswordRequest::class);
        $request->shouldReceive('user')
            ->once()
            ->andReturn($user);
        
        $request->old_password = $plainPassword;
        $request->new_password = 'new-password';
        
        $response = $this->controller->changePassword($request);
        
        $this->assertInstanceOf(JsonResponse::class, $response);
        $responseData = json_decode($response->getContent(), true);
        $this->assertEquals('Jelszó sikeresen módosítva', $responseData['message']);
        
        $user->refresh();
        $this->assertTrue(Hash::check('new-password', $user->password));
    }

    public function testChangePasswordFailure()
    {
        $user = User::factory()->create([
            'password' => Hash::make('correct-password')
        ]);
        
        $request = Mockery::mock(changePasswordRequest::class);
        $request->shouldReceive('user')
            ->once()
            ->andReturn($user);
        
        $request->old_password = 'wrong-password';
        $request->new_password = 'new-password';
        
        $response = $this->controller->changePassword($request);
        
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(400, $response->getStatusCode());
        $responseData = json_decode($response->getContent(), true);
        $this->assertEquals('A régi jelszó nem megfelelő!', $responseData['message']);
        
        $user->refresh();
        $this->assertFalse(Hash::check('new-password', $user->password));
    }
}