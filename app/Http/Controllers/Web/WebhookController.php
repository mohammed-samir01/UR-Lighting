<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Model\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    public function handle(Request $request)
    {
        Log::info('done candel sondos');
        $data = $request->all();
        $order_id = $data['orderId'];
        $order = Order::find($order_id);
        if ($order)
            $order->update(['status_oto' => $data['status']]);

    }
}
