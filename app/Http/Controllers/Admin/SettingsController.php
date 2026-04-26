<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SiteSetting;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = SiteSetting::pluck('value', 'key')->toArray();
        $settings  = array_merge(SiteSetting::defaults(), $settings);
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'site_name'       => 'required|string|max:100',
            'site_tagline'    => 'nullable|string|max:255',
            'contact_email'   => 'nullable|email|max:100',
            'contact_phone'   => 'nullable|string|max:30',
            'contact_address' => 'nullable|string|max:255',
            'facebook_url'    => 'nullable|string|max:255',
            'whatsapp_number' => 'nullable|string|max:20',
            'business_hours'  => 'nullable|string|max:200',
            'about_text'      => 'nullable|string|max:1000',
            'currency_symbol' => 'nullable|string|max:5',
            'shipping_fee'    => 'nullable|numeric|min:0',
            'meta_description'=> 'nullable|string|max:255',
        ]);

        $fields = [
            'site_name','site_tagline','contact_email','contact_phone',
            'contact_address','facebook_url','whatsapp_number','business_hours',
            'about_text','currency_symbol','shipping_fee','meta_description',
        ];

        foreach ($fields as $field) {
            SiteSetting::set($field, $request->input($field));
        }

        SiteSetting::flushAll();

        return back()->with('success', 'Site settings updated successfully!');
    }

    public function updateSms(Request $request)
    {
        $request->validate([
            'sms_api_token' => 'nullable|string|max:255',
            'sms_api_url'   => 'nullable|string|max:255',
        ]);

        SiteSetting::set('sms_api_token', $request->sms_api_token);
        SiteSetting::set('sms_api_url',   $request->sms_api_url);
        SiteSetting::flushAll();

        return back()->with('success', 'SMS settings updated successfully!');
    }
}
