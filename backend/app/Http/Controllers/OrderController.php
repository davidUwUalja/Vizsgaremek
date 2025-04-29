<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')->get();
        return response()->json($orders);
        return OrderResource::collection(Order::all());
    }

    public function store(StoreOrderRequest $request)
    {
        $validated = $request->validated();
        $order = Order::create($validated);
        return response()->json($order, 201);
    }

    public function show(Order $order)
    {
        $order->load('user');
        return response()->json($order);
    }

    public function update(UpdateOrderRequest $request, Order $order)
    {
        $validated = $request->validated();
        $order->update($validated);
        return response()->json($order);
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return response()->json(null, 204);
    }
}
