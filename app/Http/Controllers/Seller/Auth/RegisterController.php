<?php

namespace App\Http\Controllers\Seller\Auth;

use App\CPU\ImageManager;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Shipping\Oto;
use App\Model\Seller;
use App\Model\Shop;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\CPU\Helpers;
use Illuminate\Support\Facades\Session;
use function App\CPU\translate;

class RegisterController extends Controller
{
    public function create()
    {
        $business_mode = Helpers::get_business_settings('business_mode');
        $seller_registration = Helpers::get_business_settings('seller_registration');
        if ((isset($business_mode) && $business_mode == 'single') || (isset($seller_registration) && $seller_registration == 0)) {
            Toastr::warning(translate('access_denied!!'));
            return redirect('/');
        }
        return view(VIEW_FILE_NAMES['seller_registration']);
    }

    public function store(Request $request)
    {

        $request->validate([
            'image' => 'required|mimes: jpg,jpeg,png,gif',
            'logo' => 'required|mimes: jpg,jpeg,png,gif',
            'banner' => 'required|mimes: jpg,jpeg,png,gif',
            'bottom_banner' => 'mimes: jpg,jpeg,png,gif',
            'email' => 'required|unique:sellers',
            'shop_address' => 'required',
            'f_name' => 'required',
            'l_name' => 'required',
            'shop_name' => 'required',
            'phone' => 'required',
            'password' => 'required|min:8',
        ],
            [

                'image.required' => translate('image_is_required') . '!',
                'logo.required' => translate('logo_name_is_required') . '!',
                'banner.required' => translate('banner_name_is_required') . '!',
                'bottom_banner.required' => translate('bottom_banner_name_is_required') . '!',
                'shop_address.required' => translate('shop_address_is_required') . '!',
            ]
        );

        if ($request['from_submit'] != 'admin') {
            //recaptcha validation
            $recaptcha = Helpers::get_business_settings('recaptcha');
            if (isset($recaptcha) && $recaptcha['status'] == 1) {
                try {
                    $request->validate([
                        'g-recaptcha-response' => [
                            function ($attribute, $value, $fail) {
                                $secret_key = Helpers::get_business_settings('recaptcha')['secret_key'];
                                $response = $value;
                                $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . $secret_key . '&response=' . $response;
                                $response = \file_get_contents($url);
                                $response = json_decode($response);
                                if (!$response->success) {
                                    $fail(\App\CPU\translate('ReCAPTCHA Failed'));
                                }
                            },
                        ],
                    ]);
                } catch (\Exception $exception) {
                }
            } else {
                if (strtolower($request->default_recaptcha_id_seller_regi) != strtolower(Session('default_recaptcha_id_seller_regi'))) {
                    Session::forget('default_recaptcha_id_seller_regi');
                    return back()->withErrors(\App\CPU\translate('Captcha Failed'));
                }
            }
        }

        DB::beginTransaction();
        $seller = new Seller();
        $seller->f_name = $request->f_name;
        $seller->l_name = $request->l_name;
        $seller->phone = $request->phone;
        $seller->email = $request->email;
        $seller->image = ImageManager::upload('seller/', 'png', $request->file('image'));
        $seller->password = bcrypt($request->password);
        $seller->status = $request->status == 'approved' ? 'approved' : "pending";
        $seller->save();

        $shop = new Shop();
        $shop->seller_id = $seller->id;
        $shop->name = $request->shop_name;
        $shop->address = $request->shop_address;
        $shop->country_id = $request->country_id;
        $shop->state_id = $request->state_id;
        $shop->city_id = $request->city_id;
        $shop->commercial_num = $request->commercial_num;
        $shop->tax_num = $request->tax_num;
        $shop->build_num = $request->build_num;
        $shop->additional_num = $request->additional_num;
        $shop->subdivision = $request->subdivision;
        $shop->zib = $request->zib;
        $shop->contact = $request->phone;
        $shop->image = ImageManager::upload('shop/', 'png', $request->file('logo'));
        $shop->banner = ImageManager::upload('shop/banner/', 'png', $request->file('banner'));
        $shop->bottom_banner = ImageManager::upload('shop/banner/', 'png', $request->file('bottom_banner'));
        $shop->save();

        DB::table('seller_wallets')->insert([
            'seller_id' => $seller['id'],
            'withdrawn' => 0,
            'commission_given' => 0,
            'total_earning' => 0,
            'pending_withdraw' => 0,
            'delivery_charge_earned' => 0,
            'collected_cash' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::commit();
        $location = [
            'name' => $request->shop_name,
            'code' => rand(10, 1000),
            'mobile' => $request->phone,
            'city' => "Riyadh",
            'country' => "SA",
            'address' => $request->shop_address,
            'contact_email' => $request->email,
            'contact_name' => $request->f_name . ' ' . $request->l_name,
        ];
        $pickup_location = Oto::createPickupLocation($location);
        if ($pickup_location['success'])
            $shop->update(['pickup_code' => $pickup_location['pickupLocationCode']]);

        if ($request->status == 'approved') {
            Toastr::success(translate('shop_apply_successfully'));
            return back();
        } else {
            Toastr::success(translate('shop_apply_successfully'));
            return redirect()->route('seller.auth.login');
        }


    }
}
