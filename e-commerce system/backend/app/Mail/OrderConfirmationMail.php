<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Order;

class OrderConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function build()
    {
        // Convert JSON items to array if needed
        $items = is_array($this->order->items)
            ? $this->order->items
            : json_decode($this->order->items, true);

        $html = "
            <h2>🛍️ Thank you for your order!</h2>
            <p>We’ve received your order and will process it soon.</p>

            <h3>Order Summary:</h3>
            <table border='1' cellpadding='8' cellspacing='0' width='100%' style='border-collapse: collapse;'>
                <thead>
                    <tr style='background-color: #f8fafc;'>
                        <th align='left'>Image</th>
                        <th align='left'>Product</th>
                        <th align='left'>Price</th>
                        <th align='left'>Qty</th>
                        <th align='left'>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
        ";

        if (!empty($items)) {
            foreach ($items as $item) {
                $name = htmlspecialchars($item['name'] ?? 'Unknown');
                $price = number_format($item['price'] ?? 0, 2);
                $qty = $item['quantity'] ?? 1;
                $subtotal = number_format(($item['price'] ?? 0) * $qty, 2);
                $image = htmlspecialchars($item['image'] ?? '');

                $html .= "
                    <tr>
                        <td><img src='{$image}' alt='{$name}' width='60' style='border-radius:6px;'/></td>
                        <td>{$name}</td>
                        <td>\${$price}</td>
                        <td>{$qty}</td>
                        <td>\${$subtotal}</td>
                    </tr>
                ";
            }
        }

        $html .= "
                </tbody>
            </table>

            <p style='margin-top: 15px;'><strong>Total:</strong> $" . number_format($this->order->total, 2) . "</p>

            <p>Thanks for shopping with us 💙 Mini E-Commerce</p>
        ";

        return $this->subject('Order Confirmation')
                    ->html($html);
    }
}
