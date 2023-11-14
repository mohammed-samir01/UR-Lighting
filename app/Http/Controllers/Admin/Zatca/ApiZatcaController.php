<?php

namespace App\Http\Controllers\Admin\Zatca;

use App\CPU\OrderManager;
use App\Http\Controllers\Admin\BusinessSettingsController;
use App\Http\Controllers\Controller;
use App\Model\City;
use App\Model\Order;
use App\Model\Shop;
use App\Model\State;
use App\Services\Zatca\GenerateXmlFile;
use App\Services\Zatca\Zatca;

class ApiZatcaController extends Controller
{
    private $zatca;

    public function __construct()
    {
        $this->zatca = new Zatca();
    }

    public function reporting_invoice(GenerateXmlFile $xmlFile)
    {
        $order = Order::with('details', 'customer')->find(request('order_id'));
        if ($order->seller_is == 'admin') {
            $order->seller = (object)BusinessSettingsController::business_setting();
            $order->seller->state_name = State::find($order->seller->state_id)->name_en;
            $order->seller->city_name = City::find($order->seller->city_id)->name_en;
            $order->seller->address = $order->seller->shop_address;
        }
        if ($order->seller_is == 'seller') {
            $order->seller = Shop::where('seller_id', $order->seller_id)->first();
            $order->seller->state_name = State::find($order->seller->state_id)->name_en;
            $order->seller->city_name = City::find($order->seller->city_id)->name_en;
            $order->seller->company_name = $order->seller->name;
        }
        $order->summary = (object)OrderManager::order_summary($order);
        $order->shipping_address_data = (object)json_decode($order->shipping_address_data);
       return  $data = $xmlFile->loadXmlFile($order);
        return $response = $this->zatca->reporting_invoice($data);

    }


}
