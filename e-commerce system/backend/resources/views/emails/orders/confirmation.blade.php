<x-mail::message>
@php
    // Ensure items are always decoded properly
    $items = is_string($order->items) ? json_decode($order->items, true) : $order->items;
@endphp

# Thank You For Your Order!

Hi {{ $order->name ?? 'Customer' }},

We’re excited to let you know that we’ve received your order.
Here’s a summary of what you purchased:

---

@if (!empty($items))
@foreach ($items as $item)
**{{ $item['name'] ?? 'Unknown Item' }}**
Price: ${{ $item['price'] ?? '0.00' }}
Quantity: {{ $item['quantity'] ?? 1 }}

@endforeach
@else
_No items found for this order._
@endif

---

**Total: ${{ $order->total ?? '0.00' }}**

We’ll send you another email once your order is shipped.
If you have any questions, feel free to reply to this email.

Thanks again for shopping with us! 💙
{{ config('app.name') }}
</x-mail::message>
