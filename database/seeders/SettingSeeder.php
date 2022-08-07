<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::updateOrCreate(['name' => 'company_name'], [
            'name' => 'company_name',
            'value' => 'Jualin Store'
        ]);

        Setting::updateOrCreate(['name' => 'timezone'], [
            'name' => 'timezone',
            'value' => 'Asia/Jakarta'
        ]);

        Setting::updateOrCreate(['name' => 'language'], [
            'name' => 'language',
            'value' => 'en'
        ]);

        Setting::updateOrCreate(['name' => 'company_phone'], [
            'name' => 'company_phone',
            'value' => '021 4123841'
        ]);

        Setting::updateOrCreate(['name' => 'company_address'], [
            'name' => 'company_address',
            'value' => 'DLK Office, Kota Yogyakarta, Daerah Istimewa Yogyakarta'
        ]);
        
    }
}
