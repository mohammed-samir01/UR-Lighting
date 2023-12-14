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
        Log::info('done candel amer');
        $data = $request->all();
        Log::info($data['orderId']);
        Log::info(Order::find($data['orderId']));

        if (isset($data['orderId'])){
            $order = Order::find($data['orderId']);
            if ($order)
                $order->update(['status_oto' => $data['status']]);
        }

    }
}
