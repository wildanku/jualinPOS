<?php

namespace App\View\Components;

use App\Models\Setting;
use Illuminate\View\Component;

class receipt extends Component
{
    public $transaction;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($transaction)
    {
        $this->transaction = $transaction;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $company = [
            'name' => Setting::where('name','company_name')->first() ? Setting::where('name','company_name')->first()->value : '',
            'phone' => Setting::where('name','company_phone')->first() ? Setting::where('name','company_phone')->first()->value : '', 
            'address' => Setting::where('name','company_address')->first() ? Setting::where('name','company_address')->first()->value : '',
        ];
        $transaction = $this->transaction;
        return view('components.receipt', compact('transaction','company'));
    }
}
