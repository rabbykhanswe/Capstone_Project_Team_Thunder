<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SiteSetting extends Model
{
    protected $fillable = ['key', 'value'];

    public static function get(string $key, $default = null)
    {
        return Cache::rememberForever('site_setting_' . $key, function () use ($key, $default) {
            $setting = static::where('key', $key)->first();
            return $setting ? $setting->value : $default;
        });
    }

    public static function set(string $key, $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
        Cache::forget('site_setting_' . $key);
        Cache::forget('site_settings_all');
    }

    public static function all_settings(): array
    {
        return Cache::rememberForever('site_settings_all', function () {
            return static::pluck('value', 'key')->toArray();
        });
    }

    public static function flushAll(): void
    {
        $keys = static::pluck('key')->all();
        foreach ($keys as $key) {
            Cache::forget('site_setting_' . $key);
        }
        Cache::forget('site_settings_all');
    }

    public static function defaults(): array
    {
        return [
            'site_name'        => 'Oronno Plants',
            'site_tagline'     => "Bangladesh's trusted digital nursery for plants and gardening.",
            'contact_email'    => 'oronnoplants@gmail.com',
            'contact_phone'    => '+8801920202157',
            'contact_address'  => 'Dhaka, Bangladesh',
            'facebook_url'     => 'https://www.facebook.com/oronnoplants',
            'whatsapp_number'  => '8801920202157',
            'business_hours'   => 'Sat–Thu: 9AM–8PM | Fri: 2PM–8PM',
            'currency_symbol'  => '৳',
            'shipping_fee'     => '60',
            'about_text'       => 'Oronno Plants is Bangladesh\'s trusted digital nursery, bringing fresh plants and gardening joy to every home since 2024.',
            'sms_api_token'    => '',
            'sms_api_url'      => '',
            'meta_description' => 'Buy fresh indoor & outdoor plants online in Bangladesh. Free delivery available.',
        ];
    }
}
