<?php

namespace App\Http\Controllers\Admin\Zatca;

use App\CPU\Helpers;
use App\CPU\OrderManager;
use App\Http\Controllers\Admin\BusinessSettingsController;
use App\Http\Controllers\Controller;
use App\Model\City;
use App\Model\Order;
use App\Model\ResponseZatca;
use App\Model\Shop;
use App\Model\State;
use App\Services\Zatca\GenerateCsr;
use App\Services\Zatca\GenerateXmlFile;
use App\Services\Zatca\Zatca;
use Illuminate\Http\Request;
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
        $order = $this->handleOrder();
        $data = $xmlFile->loadXmlFile($order);
        return $this->zatca->reporting_invoice($data);
    }

    public function compliance_invoice()
    {
        $xml = new GenerateXmlFile('csr');
        $order = $this->handleStaticOrder();
        $invoice = $xml->loadXmlFile($order);
        $res = $this->zatca->compliance_check($invoice);
        $message = '';
        if ($res->successful()) {
            $message = 'successfully';
        } else {
            $message = $res->json();
        }
        $data = [];
        $seller = [];
        if (\request()->boolean('invoice')) {
            $data['status_invoice'] = 1;
            $data['response_invoice'] = $message;
        }
        if (\request()->boolean('credit')) {
            $data['status_credit'] = 1;
            $data['response_credit'] = $message;
        }
        if (\request()->boolean('debit')) {
            $data['status_debit'] = 1;
            $data['response_debit'] = $message;
        }
        if (auth('admin')->check()) {
            $seller['seller'] = 'admin';
        }
        if (auth('seller')->check()) {
            $seller['seller'] = 'seller';
            $seller['seller_id'] = auth('seller')->user()->id;
        }
        $array = array_merge($seller, $data);

        ResponseZatca::updateOrCreate($seller,$array);
        return back();
    }

    public function handleOrder()
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
        $order->type_invoice = '388';
        $order->shipping_address_data = (object)json_decode($order->shipping_address_data);
        return $order;
    }

    public function handleStaticOrder()
    {
        $order = \Opis\Closure\unserialize(file_get_contents(public_path('order.text')));
        $order->type_invoice = '388';
        $order->id = 100000 + Order::count() + 1;

        if (\request()->boolean('credit')) {
            $order->type_invoice = '381';
            $order->father_inv = $order->id;
            $order->id = $order->id + 1;
        }
        if (\request()->boolean('debit')) {
            $order->type_invoice = '383';
            $order->father_inv = $order->id;
            $order->id = $order->id + 2;
        }
        if (auth('admin')->check()) {
            $order->seller = (object)BusinessSettingsController::business_setting();
            $order->seller->state_name = State::find($order->seller->state_id)->name_en;
            $order->seller->city_name = City::find($order->seller->city_id)->name_en;
            $order->seller->address = $order->seller->shop_address;
        }
        if (auth('seller')->check()) {
            $order->seller = Shop::where('seller_id', auth('seller')->user()->id)->first();
            $order->seller->state_name = State::find($order->seller->state_id)->name_en;
            $order->seller->city_name = City::find($order->seller->city_id)->name_en;
            $order->seller->company_name = $order->seller->name;
        }
        $order->summary = (object)OrderManager::order_summary($order);
        $order->shipping_address_data = (object)json_decode($order->shipping_address_data);
        return $order;
    }


    public function get_csr(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric',
            'uid' => 'required',
            'address' => 'required',
            'email' => 'required',
            'organization_name' => 'required',
        ]);

        $csr = (new GenerateCsr())->csr($request);
        $data = ['csr' => $csr];
        $response = $this->zatca->request_for_csr(request('otp'), $data);
        $status_code = $response->status();
        $body = $response->json();
        if ($status_code == 200) {
            $data_encode = json_encode($body);
            Storage::disk('zatca')->put(Helpers::path_zatca() . "/csr.json", $data_encode);
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

    public function requestCert()
    {
        $path = Helpers::path_zatca() . "/csr.json";
        if (Storage::disk('zatca')->exists($path)) {
            $data = json_decode(Storage::disk('zatca')->get($path), true);
            $auth = base64_encode($data['binarySecurityToken'] . ':' . $data['secret']);
            $res = $this->zatca->get_certificate($data['requestID'], $auth);
            if ($res->status() == 200) {
                Storage::disk('zatca')->put(Helpers::path_zatca() . "/cert.json", json_encode($res->json()));
                return 'ok';
            }
        }
    }


}
