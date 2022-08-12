<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = database_path('currency.json');
        $currencies = json_decode(file_get_contents($path), true); 

        foreach($currencies as $currency) {
            Currency::create($currency);
        }
        
    }
}
