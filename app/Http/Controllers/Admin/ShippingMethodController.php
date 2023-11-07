<?php

namespace App\Http\Controllers\Admin;

use App\CPU\BackEndHelper;
use App\Http\Controllers\Controller;
use App\Model\Country;
use App\Model\ShippingMethod;
use App\Model\State;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Model\BusinessSetting;
use App\Model\Category;
use App\Model\CategoryShippingCost;

class ShippingMethodController extends Controller
{
    public function index_admin()
    {
        $shipping_methods = ShippingMethod::where(['creator_type' => 'admin'])->get();

        return view('admin-views.shipping-method.add-new', compact('shipping_methods'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:200',
            'duration' => 'required',
            'cost' => 'numeric',
            'states' => 'required',
            'country_id' => 'required'
        ]);

        $data = $request->all();

        $data['creator_id'] = auth('admin')->id();
        $data['creator_type'] = 'admin';
        $data['cost'] = BackEndHelper::currency_to_usd($request['cost']);
        $data['info'] = ['country_id' => $request->country_id, 'states' => $request->states];

        ShippingMethod::create($data);

//        DB::table('shipping_methods')->insert([
//            'creator_id' => auth('admin')->id(),
//            'creator_type' => 'admin',
//            'title' => $request['title'],
//            'duration' => $request['duration'],
//            'cost' => BackEndHelper::currency_to_usd($request['cost']),
//            'status' => 1,
//            'created_at' => now(),
//            'updated_at' => now(),
//        ]);

        Toastr::success(translate('Successfully_added'));
        return back();

    }

    public function status_update(Request $request)
    {
        ShippingMethod::where(['id' => $request['id']])->update([
            'status' => $request['status'],
        ]);
        return response()->json([
            'success' => 1,
        ], 200);
    }

    public function edit($id)
    {
        if ($id != 1) {
            $method = ShippingMethod::where(['id' => $id])->first();
            $countries = Country::where('status', 1)->get();
            $states = [];
            if (isset($method->info['country_id']))
                $states = State::where('status', 1)->where('country_id', $method->info['country_id'])->get();
            return view('admin-views.shipping-method.edit', compact('method','states','countries'));
        }
        return back();
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|max:200',
            'duration' => 'required',
            'cost' => 'numeric',
            'states' => 'required',
            'country_id' => 'required'
        ]);

        $data = $request->all();
        $method = ShippingMethod::find($id);
        $data['cost'] = BackEndHelper::currency_to_usd($request['cost']);
        $data['info'] = ['country_id' => $request->country_id, 'states' => $request->states];
        $method->update($data);
        Toastr::success(translate('successfully_updated'));
        return redirect()->back();
    }

    public function setting()
    {

        $shipping_methods = ShippingMethod::where(['creator_type' => 'admin'])->get();
        $all_category_ids = Category::where(['position' => 0])->pluck('id')->toArray();
        $category_shipping_cost_ids = CategoryShippingCost::where('seller_id', 0)->pluck('category_id')->toArray();
        $countries = Country::where('status', 1)->get();
        foreach ($all_category_ids as $id) {
            if (!in_array($id, $category_shipping_cost_ids)) {
                $new_category_shipping_cost = new CategoryShippingCost;
                $new_category_shipping_cost->seller_id = 0;
                $new_category_shipping_cost->category_id = $id;
                $new_category_shipping_cost->cost = 0;
                $new_category_shipping_cost->save();
            }
        }
        $all_category_shipping_cost = CategoryShippingCost::where('seller_id', 0)->get();
        return view('admin-views.shipping-method.setting', compact('all_category_shipping_cost', 'shipping_methods', 'countries'));
    }

    public function shippingStore(Request $request)
    {
        DB::table('business_settings')->updateOrInsert(['type' => 'shipping_method'], [
            'value' => $request['shipping_method']
        ]);

        if ($request->ajax()) {
            return response()->json();
        }

        Toastr::success(translate('shipping_responsibility_updated_successfully'));
        return back();
    }

    public function delete(Request $request)
    {

        $shipping = ShippingMethod::find($request->id);

        $shipping->delete();
        return response()->json();
    }

}
