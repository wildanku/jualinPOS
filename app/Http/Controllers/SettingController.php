<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
    public function general()
    {
        return view('setting.general');
    }

    public function updateGeneral(Request $request)
    {
        // dd($request->all());
        DB::transaction(function () use($request) {
            Setting::updateOrCreate(['name' => 'company_name'], [
                'name' => 'company_name',
                'value' => $request->company_name
            ]);

            Setting::updateOrCreate(['name' => 'company_phone'], [
                'name' => 'company_phone',
                'value' => $request->company_phone
            ]);

            Setting::updateOrCreate(['name' => 'company_address'], [
                'name' => 'company_address',
                'value' => $request->company_address
            ]);

            Setting::updateOrCreate(['name' => 'currency'], [
                'name' => 'currency',
                'value' => $request->currency
            ]);
        });

        return redirect()->back()->with('success','Setting data has been saved!');
    }
    
}
