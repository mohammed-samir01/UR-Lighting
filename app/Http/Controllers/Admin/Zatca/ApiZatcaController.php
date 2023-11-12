<?php
namespace App\Http\Controllers\Admin\Zatca;

use App\Http\Controllers\Admin\BusinessSettingsController;
use App\Http\Controllers\Controller;
use App\Model\Order;
use App\Model\Shop;
use App\Services\Zatca\Zatca;

class ApiZatcaController extends Controller
{
    private $zatca;

    public function __construct()
    {
        $this->zatca = new Zatca();
    }

    public function reporting_invoice()
    {
        $order =  Order::with('details','customer')->find(100002);
        if ($order->seller_is == 'admin')
            $order->seller = (object)BusinessSettingsController::business_setting();
        if ($order->seller_is == 'seller')
            $order->seller = Shop::where('seller_id',$order->seller_id)->first();

        return $order->seller;

        $response = $this->zatca->reporting_invoice(['am' => 'so']);
    }



}
