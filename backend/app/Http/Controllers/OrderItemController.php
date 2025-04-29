<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderItemRequest;
use App\Http\Requests\UpdateOrderItemRequest;
use App\Http\Resources\OrderItemResource;
use App\Models\OrderItem;

class OrderItemController extends Controller
{
    public function index()
    {
        $orderItems = OrderItem::with('order')->get();
        return response()->json($orderItems);
        return OrderItemResource::collection(OrderItem::all());
    }

    public function store(StoreOrderItemRequest $request)
    {
        $validated = $request->validated();
        $orderItem = OrderItem::create($validated);
        return response()->json($orderItem, 201);
    }

    public function show(OrderItem $orderItem)
    {
        $orderItem->load('order');
        return response()->json($orderItem);
    }

    public function update(UpdateOrderItemRequest $request, OrderItem $orderItem)
    {
        $validated = $request->validated();
        $orderItem->update($validated);
        return response()->json($orderItem);
    }

    public function destroy(OrderItem $orderItem)
    {
        $orderItem->delete();
        return response()->json(null, 204);
    }
}
