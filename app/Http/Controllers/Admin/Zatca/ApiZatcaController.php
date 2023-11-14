<?php

namespace App\Http\Controllers\Admin\Zatca;

use App\CPU\OrderManager;
use App\Http\Controllers\Admin\BusinessSettingsController;
use App\Http\Controllers\Controller;
use App\Model\City;
use App\Model\Order;
use App\Model\Shop;
use App\Model\State;
use App\Services\Zatca\GenerateCsr;
use App\Services\Zatca\GenerateXmlFile;
use App\Services\Zatca\Zatca;
use Illuminate\Support\Facades\Storage;

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
         $data = $xmlFile->loadXmlFile($order);
        return $response = $this->zatca->reporting_invoice($data);

    }


    public function get_csr(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric',
            'uid' => 'required',
            'address' => 'required',
            'business_category' => 'required',
            'email' => 'required',
            'organization_name' => 'required',
            'unit_name' => 'required',
        ]);
        $csr = (new GenerateCsr())->csr($request);
        $data = ['csr' => $csr];
        $response = $this->zatca->request_for_csr($request->otp, $data);
        $status_code = $response->status();
        $body = $response->json();
        if ($status_code == 200) {
            $data_encode = json_encode($body);
            Storage::disk('zatca')->put('csr.json', $data_encode);
            return response()->json([
                'code' => $status_code,
                'message' => 'the csr was created Successfully',
                'data' => $body
            ]);
        }
        return response()->json([
            'code' => $status_code,
            'message' => 'worrying',
            'data' => $body
        ], 500);

    }


}
