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
        Log::info('done candel');
        Log::info($request->all());

        $data = $request->all();
        if (isset($data['orderId'])){
            $order = Order::find($data['orderId']);
            if ($order)
                $order->update(['status_oto' => $data['status']]);
        }

    }
}
