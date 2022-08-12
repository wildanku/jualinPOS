<?php

use App\Models\Currency;
use App\Models\Setting;

function company_name()
{
    $setting =  Setting::where('name','company_name')->first();
    return $setting ? $setting->value ?? '' : '';
}

function company_phone()
{
    $setting =  Setting::where('name','company_phone')->first();
    return $setting ? $setting->value ?? '' : '';
}

function company_address()
{
    $setting =  Setting::where('name','company_address')->first();
    return $setting ? $setting->value ?? '' : '';
}

function currency()
{
    $setting =  Setting::where('name','currency')->first();
    if($setting) {
        $currency = Currency::find($setting->value);
    } else {
        $currency = Currency::first();
    }

    return $currency;
}

