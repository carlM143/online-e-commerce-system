<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderSummaryMail;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'cart' => 'required|array',
            'total' => 'required|numeric',
        ]);

        // Create new order record
        $order = Order::create([
            'customer_email' => $validated['email'],
            'items' => json_encode($validated['cart']),
            'total' => $validated['total'],
        ]);

        // Send email (Microservice 3)
        Mail::to($validated['email'])->send(new OrderSummaryMail($order));

        return response()->json([
            'message' => '✅ Order placed successfully! Email sent.',
            'order' => $order
        ], 201);
    }
}
