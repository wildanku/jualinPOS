<?php

namespace App\Services;

use App\Models\Account;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Tax;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

Class TaxService 
{
    public $accountTypeId = 9;

    public function create($data)
    {
        $accountTypeId = $this->accountTypeId;
        DB::transaction(function () use($data, $accountTypeId) {
            $tax = Tax::create($data);
            $taxAccountID =  Account::where('account_type_id',$accountTypeId)->count() + 1;
            $code = "2-205".str_pad($taxAccountID, 2, '0', STR_PAD_LEFT);

            // by default, Tax will generate account data, if user do not select account ID, then automaticaly system will generate default account
            if(!isset($data['account_id'])) {
                $account = Account::create([
                    'name' => $tax->name,
                    'code' => $code,
                    'account_type_id' => $accountTypeId,
                ]);

                $tax->account_id = $account->id;
                $tax->save();
            }
        });

        return true;
    }

    public function update($data, $tax)
    {
        DB::transaction(function () use($data, $tax) {
            $tax->update($data);
        });
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

    public function destroy($tax) 
    {
        DB::transaction(function() use($tax) {
            Account::where('id', $tax->account_id)->update(['archived_at' => Carbon::now()]);
            $tax->delete();
        });

        return true;
    }
    
}