<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $order = Order::create([
            'user_id' => Auth::user()->id,
            'total_price' => $request->total_price,
            'status' => 'pending'
        ]);

        return response()->json($order);
    }
}