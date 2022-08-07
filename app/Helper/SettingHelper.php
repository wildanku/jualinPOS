<?php 

namespace App\Helper;

use App\Models\Setting;

Class SettingHelper 
{
    function company_name()
    {
        $setting =  Setting::where('name','company_name')->first();
        return $setting ? $setting->value ?? '' : '';
    }
}