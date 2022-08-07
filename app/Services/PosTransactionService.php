<?php

namespace App\Services;

use App\Models\Account;
use App\Models\Cart;
use App\Models\PosTransaction;
use App\Models\PosTransactionDetail;
use App\Models\TaxTransaction;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

Class PosTransactionService
{
    public function store($request)
    {
        // 1. find Cart 
        $cartService = new CartService();
        $carts = $cartService->get();

        if(!$carts) {
            return [
                'success' => false,
                'message' => 'Transaction Failed'
            ];
        }

        return DB::transaction(function () use($request, $carts) {
            
            // 2. save transaction
            $posTransaction = PosTransaction::create([
                'operator_id'   => Auth::user()->id,
                'type'          => 'in',
                'total'         => $carts['subTotal'],
                'discount'      => $carts['totalDiscount'],
                'tax'           => $carts['totalTax'],
                'grandTotal'    => $carts['grandTotal'],
                'payment_method_id' => $request->paymentmethod,
                'cash_amount'   => $request->paymentmethod == 0 ? $request->cashAmount ?? 0 : 0,
                'change_amount' => $request->paymentmethod == 0 ? $request->cashAmount - $carts['grandTotal'] : 0,
            ]);

            // dd($posTransaction->id);
            
            // 3. save transaction detail
            foreach($carts['carts'] as $cart) {
                if($cart->custom_product_id) {
                    $price = $cart->price;
                } else {
                    $price = $cart->product->sell_price_after_tax();
                }

                PosTransactionDetail::create([
                    'pos_transaction_id' => $posTransaction->id,
                    'product_id' => $cart->product_id,
                    'product_name' => $cart->product->name ?? null,
                    'custom_product_id' => $cart->custom_product_id,
                    'custom_product_name' => $cart->customProduct->name ?? null,
                    'amount' => $cart->amount,
                    'price' => $price,
                    'total' => $cart->amount * $price
                ]);
            }

            // 3.2 update pos transaction table 
            $posTransaction->product_detail = json_encode($posTransaction->details);
            $posTransaction->save();

            // 4 recap and clasify each transaction type
            // 4.1 POS Transaction
            // save to account code => 4-40001
            // @todo fixing all default account
            $posTransactionAccount = Account::where('code','4-40001')->first();
            Transaction::create([
                'user_id' => Auth::user()->id,
                'account_id' => $posTransactionAccount->id,
                'type' => 'income',
                'transaction_type' => 'pos',
                'amount' => $carts['subTotal'], // amount transaction before tax and discount
                'reference' => 'App\Models\PosTransaction',
                'document_id' => $posTransaction->id,
            ]);

            // 4.2 Taxes Transaction and Taxes recap
            foreach ($carts['carts']->whereNotNull('product_id') as $cart) {
                $taxTransaction = Transaction::create([
                    'user_id' => Auth::user()->id,
                    'account_id' => $cart->product->tax->account_id,
                    'type' => 'income',
                    'transaction_type' => 'pos',
                    'amount' => $cart->product->countTax(), // amount transaction before tax and discount
                    'reference' => 'App\Models\PosTransaction',
                    'document_id' => $posTransaction->id,
                ]);

                TaxTransaction::create([
                    'tax_id' => $cart->product->tax_id,
                    'transaction_id' => $taxTransaction->id,
                    'hasModelRelation' => 'App\Models\Product',
                    'relation_id' => $cart->product_id,
                    'amount' => $taxTransaction->amount
                ]);
            }

            // 4.3 Discount Transaction 
            // @todo Discount Transaction Feature

            // 5 Delete Cart
            Cart::where('user_id',Auth::user()->id)->delete();

            return $posTransaction;
        });
    }
}