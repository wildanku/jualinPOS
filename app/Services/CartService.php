<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CustomProduct;
use App\Models\Product;
use App\Models\Tax;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

Class CartService
{
    public function get()
    {
        $taxService = new TaxService();
        $user = Auth::user();
        
        $carts = Cart::where('user_id',$user->id)->get();
        $products = Product::whereIn('id',$carts->pluck('product_id'))->get();
        // dd($carts);
        $taxes = $taxService->calculateCart($carts);

        if(!$carts) {
            return false;
        }
        
        return [
            'carts' => $carts,
            'subTotal' => $taxes['subTotal'],
            'totalTax' => $taxes['totalTax'],
            'totalDiscount' => 0,
            'grandTotal' => $taxes['subTotal'] + $taxes['totalTax'],
        ];
    }

    public function create($request)
    {
        $product = Product::find($request->product_id);
            $user = Auth::user();

        if($product->is_tracked == 1 && $request->amount > $product->latest_stock()) {
            return [
                'code' => 403,
                'success' => false,
                'message' => 'Product is empty'
            ];
        }

        DB::transaction(function () use($request, $user) {
            if($request->amount == 0) {
                Cart::where(['product_id' => $request->product_id, 'user_id' => $user->id])->delete();
            } else {
                Cart::updateOrCreate(['product_id' => $request->product_id, 'user_id' => $user->id], [
                    'product_id' => $request->product_id,
                    'user_id' => $user->id,
                    'amount' => $request->amount,
                ]);
            }
            
        });

        return [
            'code' => 200,
            'success' => true,
            'message' => 'product added'
        ];
    }

    public function createCustom($request)
    {
        $user = Auth::user();

        DB::transaction(function () use($request, $user) {
            
            if(isset($request->amount) && $request->amount == 0) {
                Cart::where(['custom_product_id' => $request->product_id, 'user_id' => $user->id])->delete();
            } else {
                // update product price

                if($request->price) {
                    Cart::updateOrCreate(['custom_product_id' => $request->product_id, 'user_id' => $user->id], [
                        'amount' => $request->amount ?? 1,
                        'custom_product_id' => $request->product_id,
                        'user_id' => $user->id,
                        'price' => $request->price ?? null,
                    ]);

                    $productCustom = CustomProduct::find($request->product_id);
                    $productCustom->price = $request->price;
                    $productCustom->save();

                } else {
                    Cart::updateOrCreate(['custom_product_id' => $request->product_id, 'user_id' => $user->id], [
                        'amount' => $request->amount ?? 1,
                        'custom_product_id' => $request->product_id,
                        'user_id' => $user->id,
                    ]);
                }
            }
            
        });

        return [
            'code' => 200,
            'success' => true,
            'message' => 'product added'
        ];
    }

    public function clearCart()
    {
        $user = Auth::user();
        DB::transaction(function() use($user) {
            Cart::where('user_id',$user->id)->delete();
        });

        return true;
    }
}