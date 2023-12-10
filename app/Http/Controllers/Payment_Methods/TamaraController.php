<?php

namespace App\Http\Controllers\Payment_Methods;

use App\CPU\CartManager;
use App\CPU\Helpers;
use App\Model\PaymentRequest;
use App\Model\ShippingAddress;
use App\Models\User;
use App\Traits\Processor;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class Tamara
{
    use Processor;

    private $config_values;
    private $base_url;

    public function __construct()
    {
        $config = $this->payment_config('tamara', 'payment_config');
        if (!is_null($config) && $config->mode == 'live') {
            $this->config_values = json_decode($config->live_values);
            $this->base_url = 'https://api.tamara.co/';

        } elseif (!is_null($config) && $config->mode == 'test') {
            $this->config_values = json_decode($config->test_values);
            $this->base_url = 'https://api-sandbox.tamara.co/';
        }
    }

    function send_api_request($request_url, $data)
    {
        $url = $this->base_url . $request_url;
        $response = Http::withHeaders([
            'Accept'        => 'application/json',
            'Content-Type'  => 'application/json',
            'Authorization' => 'Bearer ' . $this->config_values->api_token
        ])->post($url, $data);
        return json_decode($response->getBody()->getContents(), true);
    }
    public function checkPaymentOptionsAvailability($order)
    {
        $url = "checkout/payment-options-pre-check";

        $data = [
            'country' => 'SA',
            'phone_number' => $order['phone'],
            'order_value' => [
                'amount' => $order['total'],
                'currency' => 'SAR'
            ]
        ];
        return $this->send_api_request($url,$data);
    }

    public function getOrderDetails($orderId)
    {
        $url = $this->base_url . "merchants/orders/reference-id/" . $orderId;
        $response = Http::withHeaders([
            'Accept'        => 'application/json',
            'Content-Type'  => 'application/json',
            'Authorization' => 'Bearer ' . $this->config_values->api_token
        ])->get($url);
        return json_decode($response->getBody()->getContents(), true);
    }

    public function cancelOrder($order)
    {
        $orderId = $order['id'];
        $url = "orders/$orderId/cancel";
        $data      = [
            'orderId'      => $order['id'],
            'total_amount' => [
                'amount'   => $order['amount'],
                'currency' => 'SAR',
            ]
        ];
        return $this->send_api_request($url,$data);

    }


}

class TamaraController extends Controller
{
    use Processor;

    private PaymentRequest $payment;
    private $user;

    public function __construct(PaymentRequest $payment, User $user)
    {
        $this->payment = $payment;
        $this->user = $user;
    }

    public function payment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'payment_id' => 'required|uuid'
        ]);
        if ($validator->fails()) {
            return response()->json($this->response_formatter(GATEWAYS_DEFAULT_400, null, $this->error_processor($validator)), 400);
        }
        $payment_data = $this->payment::where(['id' => $request['payment_id']])->where(['is_paid' => 0])->first();
        if (!isset($payment_data)) {
            return response()->json($this->response_formatter(GATEWAYS_DEFAULT_204), 200);
        }
        $discount = session()->has('coupon_discount') ? session('coupon_discount') : 0;
        $order_wise_shipping_discount = CartManager::order_wise_shipping_discount();
        $shipping_cost_saved = CartManager::get_shipping_cost_saved_for_free_delivery();
        $payment_amount = CartManager::cart_grand_total() - $discount - $order_wise_shipping_discount - $shipping_cost_saved;
        $cart = CartManager::get_cart();
        $user = Helpers::get_customer($request);
        $address_id = session('address_id') ? session('address_id') : null;
        $billing_address_id = session('billing_address_id') ? session('billing_address_id') : null;
        $billing_address = ShippingAddress::with('country', 'state', 'city')->find($billing_address_id);
        $shipping_address = ShippingAddress::with('country', 'state', 'city')->find($address_id);
        $items = [];
        $total_tax = 0;
        foreach ($cart as $product) {
            $total_tax += $product['tax'] * $product['quantity'];
            $items[] = [
                'reference_id' => $product['product_id'],
                'type' => $product['product_type'],
                'name' => $product['name'],
                'sku' => $product['product']['code'],
                'image_url' => $product['thumbnail'],
                'quantity' => $product['quantity'],
                'unit_price' => [
                    'amount' => $product['price'],
                    'currency' => 'SAR',
                ],
                'discount_amount' => [
                    'amount' => $product['discount'],
                    'currency' => 'SAR',
                ],
                'tax_amount' => [
                    'amount' => $product['tax'] * $product['quantity'],
                    'currency' => 'SAR',
                ],
                'total_amount' => [
                    'amount' => $product['price'] * $product['quantity'],
                    'currency' => 'SAR',
                ],
            ];

        }
        $data = [
            'order_reference_id' => $payment_data->id,
            'order_number' => $payment_data->id,
            'total_amount' =>
                [
                    'amount' => $payment_amount,
                    'currency' => 'SAR',
                ],
            'description' => '',
            'country_code' => 'SA',
            'payment_type' => 'PAY_BY_INSTALMENTS',
            'instalments' => NULL,
            'locale' => 'en_US',
            'items' => $items,
            'consumer' => [
                'first_name' => $user['f_name'],
                'last_name' => $user['l_name'],
                'phone_number' => $user['phone'],
                'email' => $user['email'],
            ],
            'billing_address' => [
                'first_name' => $user['f_name'],
                'last_name' => $user['l_name'],
                'line1' => $billing_address['address'],
                'city' => $billing_address['city']['name_en'],
                'country_code' => 'SA',
                'phone_number' => $billing_address['phone'],
            ],
            'shipping_address' => [
                'first_name' => $user['f_name'],
                'last_name' => $user['l_name'],
                'line1' => $shipping_address['address'],
                'city' => $shipping_address['city']['name_en'],
                'country_code' => 'SA',
                'phone_number' => $shipping_address['phone'],
            ],
            'discount' => [
                'name' => $order['discount_name'] ?? "",
                'amount' => [
                    'amount' => $order['discount_amount'] ?? 0,
                    'currency' => 'SAR',
                ],
            ],
            'tax_amount' => [
                'amount' => $total_tax,
                'currency' => 'SAR',
            ],
            'shipping_amount' => [
                'amount' => CartManager::get_shipping_cost(),
                'currency' => 'SAR',
            ],
            'merchant_url' => [
                'success' => route('tamara.callback', ['payment_id' => $payment_data->id]),
                'failure' => route('tamara.callback', ['payment_id' => $payment_data->id]),
                'cancel' => route('tamara.callback', ['payment_id' => $payment_data->id]),
                'notification' => route('tamara.callback', ['payment_id' => $payment_data->id]),
            ]
        ];


        $plugin = new Tamara();
        $request_url = 'checkout';
        $page = $plugin->send_api_request($request_url, $data);

        if (in_array($request->payment_request_from, ['app', 'react'])) {
            return response()->json(['redirect_link' => $page], 200);
//            return response()->json(['redirect_link' => $page['redirect_url']], 200);
        }
        header('Location:' . $page['redirect_url']); /* Redirect browser */
        exit();
    }

    public function callback(Request $request)
    {
        if ($request->paymentStatus == 'approved') {
            $this->payment::where(['id' => $request['payment_id']])->update([
                'payment_method' => 'tamara',
                'is_paid' => 1,
            ]);
            $payment_data = $this->payment::where(['id' => $request['payment_id']])->first();
            if (isset($payment_data) && function_exists($payment_data->success_hook)) {
                return call_user_func($payment_data->success_hook, $payment_data);
            }
            return $this->payment_response($payment_data, 'success');
        }
        $payment_data = $this->payment::where(['id' => $request['payment_id']])->first();

        if (isset($payment_data) && function_exists($payment_data->failure_hook)) {
            return call_user_func($payment_data->failure_hook, $payment_data);
        }
        return $this->payment_response($payment_data, 'fail');
    }

    public function response(Request $request)
    {
        return response()->json($this->response_formatter(GATEWAYS_DEFAULT_200), 200);
    }
}
