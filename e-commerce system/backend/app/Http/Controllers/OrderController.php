<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Services\CampaignMonitorService;
use Illuminate\Support\Facades\Http;
use App\Mail\OrderConfirmationMail; // ✅ Add this import
use App\Models\Order;

class OrderController extends Controller
{
    protected $cm;

    public function __construct(CampaignMonitorService $cm)
    {
        $this->cm = $cm;
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_email' => 'required|email',
            'items' => 'required|array',
            'total' => 'required|numeric',
        ]);

        $order = Order::create([
            'customer_email' => $validated['customer_email'],
            'items' => $validated['items'],
            'total' => $validated['total'],
        ]);

        Mail::to($order->customer_email)->send(new OrderConfirmationMail($order));

        return response()->json([
            'message' => 'Order placed successfully!',
            'order' => $order
        ]);
    }
}
