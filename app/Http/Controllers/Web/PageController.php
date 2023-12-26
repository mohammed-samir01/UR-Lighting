<?php

namespace App\Http\Controllers\Web;

use App\CPU\Helpers;
use App\Http\Controllers\Controller;
use App\Model\BusinessSetting;
use App\Model\HelpTopic;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function __construct(
        private BusinessSetting $business_settings,
    ) {

    }
    public function helpTopic()
    {
        $helps = HelpTopic::Status()->latest()->get();
        $page_title_banner = $this->business_settings->where('type', 'banner_faq_page')->whereJsonContains('value', ['status' => '1'])->first('value');
        return view(VIEW_FILE_NAMES['faq'], compact('helps','page_title_banner'));
    }

    public function contacts()
    {
        $recaptcha = \App\CPU\Helpers::get_business_settings('recaptcha');
        return view(VIEW_FILE_NAMES['contacts'],compact('recaptcha'));
    }

    public function about_us()
    {
        $lang = (Helpers::app_lang());
        $about_us = BusinessSetting::where('type', 'about_us_' . $lang)->first();
        $page_title_banner = $this->business_settings->where('type', 'banner_about_us')->whereJsonContains('value', ['status' => '1'])->first('value');
        return view(VIEW_FILE_NAMES['about_us'], [
            'about_us' => $about_us,
            'page_title_banner' => $page_title_banner,
        ]);
    }

    public function termsand_condition()
    {
        $lang = (Helpers::app_lang());
        $page_title_banner = $this->business_settings->where('type', 'banner_terms_conditions')->whereJsonContains('value', ['status' => '1'])->first('value');
        $terms_condition = BusinessSetting::where('type', 'terms_condition_' . $lang)->first();
        return view(VIEW_FILE_NAMES['terms_conditions_page'], compact('terms_condition','page_title_banner'));
    }

    public function privacy_policy()
    {
        $lang = (Helpers::app_lang());
        $page_title_banner = $this->business_settings->where('type', 'banner_privacy_policy')->whereJsonContains('value', ['status' => '1'])->first('value');
        $privacy_policy = BusinessSetting::where('type', 'privacy_policy_' . $lang)->first();
        return view(VIEW_FILE_NAMES['privacy_policy_page'], compact('privacy_policy','page_title_banner'));
    }

    public function refund_policy()
    {
        $lang = (Helpers::app_lang());
        $re = BusinessSetting::where('type', 'refund-policy_'.$lang)->first();
        if (!$re){
            $re = (object)['value' => json_encode(['status' => true,'content' => ''])];
        }
        $refund_policy = json_decode($re->value);

        if(!$refund_policy->status){
            return back();
        }
        $refund_policy = $refund_policy->content;
        $page_title_banner = $this->business_settings->where('type', 'banner_refund_policy')->whereJsonContains('value', ['status' => '1'])->first('value');
        return view(VIEW_FILE_NAMES['refund_policy_page'], compact('refund_policy','page_title_banner'));
    }

    public function return_policy()
    {
        $lang = (Helpers::app_lang());
        $policy = BusinessSetting::where('type', 'return-policy_'.$lang)->first();
        if (!$policy){
            $policy = (object)['value' => json_encode(['status' => true,'content' => ''])];
        }
        $return_policy = json_decode($policy->value);
        if(!$return_policy->status){
            return back();
        }
        $return_policy = $return_policy->content;
        $page_title_banner = $this->business_settings->where('type', 'banner_return_policy')->whereJsonContains('value', ['status' => '1'])->first('value');
        return view(VIEW_FILE_NAMES['return_policy_page'], compact('return_policy','page_title_banner'));
    }

    public function cancellation_policy()
    {
        $lang = (Helpers::app_lang());
        $ca = BusinessSetting::where('type', 'cancellation-policy_'.$lang)->first();
        if (!$ca){
            $ca = (object)['value' => json_encode(['status' => true,'content' => ''])];
        }
        $cancellation_policy = json_decode($ca->value);
        if(!$cancellation_policy->status){
            return back();
        }
        $cancellation_policy = $cancellation_policy->content;
        $page_title_banner = $this->business_settings->where('type', 'banner_cancellation_policy')->whereJsonContains('value', ['status' => '1'])->first('value');
        return view(VIEW_FILE_NAMES['cancellation_policy_page'], compact('cancellation_policy','page_title_banner'));
    }
}
