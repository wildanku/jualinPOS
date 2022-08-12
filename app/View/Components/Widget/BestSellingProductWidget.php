<?php

namespace App\View\Components\Widget;

use App\Services\PosTransactionService;
use Illuminate\View\Component;

class BestSellingProductWidget extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $posService = new PosTransactionService();
        $products = $posService->bestSellingProduct();
        return view('components.widget.best-selling-product-widget', compact('products'));
    }
}
