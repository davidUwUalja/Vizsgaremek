<?php

namespace Tests\Unit;

use App\Http\Controllers\OrderController;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Mockery;
use Tests\TestCase;

class OrderControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_returns_orders()
    {
        $controller = new OrderController();

        $orders = Order::factory()->count(2)->create();

        $response = $controller->index();

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->status());
        $this->assertCount(2, $response->getData());
    }

    public function test_store_creates_order()
    {
        $controller = new OrderController();

        $request = Mockery::mock(StoreOrderRequest::class);
        $validatedData = Order::factory()->make()->toArray();

        $request->shouldReceive('validated')->andReturn($validatedData);

        $response = $controller->store($request);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(201, $response->status());
        $this->assertDatabaseHas('orders', ['email' => $validatedData['email']]);
    }

    public function test_show_returns_order()
    {
        $controller = new OrderController();

        $order = Order::factory()->create();

        $response = $controller->show($order);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->status());
        $this->assertEquals($order->id, $response->getData()->id);
    }

    public function test_update_modifies_order()
    {
        $controller = new OrderController();

        $order = Order::factory()->create();

        $request = Mockery::mock(UpdateOrderRequest::class);
        $updatedData = Order::factory()->make()->toArray();

        $request->shouldReceive('validated')->andReturn($updatedData);

        $response = $controller->update($request, $order);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->status());
        $this->assertEquals($updatedData['email'], $response->getData()->email);
    }

    public function test_destroy_deletes_order()
    {
        $controller = new OrderController();

        $order = Order::factory()->create();

        $response = $controller->destroy($order);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(204, $response->status());
        $this->assertDatabaseMissing('orders', ['id' => $order->id]);
    }
}
