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
    public function update(Request $request, Order $order)
    {
        if ($request->has('status') && count($request->except(['_method'])) === 1) {
            $validated = $request->validate([
                'status' => ['required', 'string', 'in:pending,completed,cancelled'],
            ]);
            $order->update($validated);
            return response()->json($order);
        }
    
        $validated = app(UpdateOrderRequest::class)->validated();
        $order->update($validated);
        return response()->json($order);
    }

    // public function update(UpdateOrderRequest $request, Order $order)
    // {
    //     $validated = $request->validated();
    //     $order->update($validated);
    //     return response()->json($order);
    // }

    public function destroy(Order $order)
    {
        $order->delete();
        return response()->json(null, 204);
    }
}
