<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Tax;

Class TaxService 
{
    public function get()
    {

    }

    public function calculateCart($carts)
    {
        // $products = Product::whereIn('id',$carts->pluck('product_id'))->get();
        // $taxes = Tax::whereIn('id',$products->pluck('tax_id'))->get();
        $totalTax = 0;
        $subTotal = 0;

        foreach($carts as $item) {
            if($item->product_id) {
                if($item->product->tax_id) {
                    if($item->product->tax_type == "include") {
                        $countInclude = $this->countIncludeTax($item->amount * $item->product->sell_price(), $item->product->tax->percent);
                        
                        $totalTax += $countInclude['tax'];
                        $subTotal += $countInclude['total'];
                    } else {
                        $totalTax += $this->countExcludeTax($item->product->sell_price() * $item->amount, $item->product->tax->percent);
                        $subTotal += $item->product->sell_price() * $item->amount;
                    }
                } else {
                    $subTotal += $item->product->sell_price() * $item->amount;
                }  
            } else {
                $subTotal += $item->price * $item->amount;
            }
        }

        return [
            'totalTax' => $totalTax,
            'subTotal' => $subTotal,
        ];
    }

    public function countIncludeTax($amount, $tax)
    {
        $afterTax = ceil( (100/(100+$tax)) * $amount );

        return [
            'total' => $afterTax,
            'tax' => $amount - $afterTax
        ];
    }

    public function countExcludeTax($amount, $tax)
    {
        return $amount * ($tax/100);
    }
    
}