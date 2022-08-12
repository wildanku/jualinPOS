<?php

namespace App\Services;

use App\Models\Account;
use App\Models\Cart;
use App\Models\PosTransaction;
use App\Models\PosTransactionDetail;
use App\Models\TaxTransaction;
use App\Models\Transaction;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
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
                if($cart->product->tax) {
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
            }

            // 4.3 Discount Transaction 
            // @todo Discount Transaction Feature

            // 5 Delete Cart
            Cart::where('user_id',Auth::user()->id)->delete();

            return $posTransaction;
        });
    }

    public function transactions($type = 'all')
    {
        $transactions = new PosTransaction();
        
        if($type == 'all') {
            $transactions = $transactions->orderBy('created_at','DESC')->paginate(30);
        }

        if($type == 'daily') {
            $transactions = $transactions
                                ->select(
                                    DB::raw('DATE_FORMAT(created_at, "%d %M %Y") as date'),
                                    DB::raw('sum(grandTotal) as grand_total'),
                                    DB::raw('count(id) as transaction_num')
                                )
                                ->groupBy('date')
                                ->orderBy('date','desc')
                                ->paginate(30);

            
        }

        if($type == 'weekly') {
            $transactions = $transactions
                                ->select(
                                    DB::raw('WEEK(created_at) as date'),
                                    DB::raw('sum(grandTotal) as grand_total'),
                                    DB::raw('count(id) as transaction_num')
                                )
                                ->groupBy('date')
                                ->orderBy('date','desc')
                                ->paginate(30);
        }

        if($type == 'monthly') {
            $transactions = $transactions
                                ->select(
                                    DB::raw('DATE_FORMAT(created_at,"%M") as date'),
                                    DB::raw('sum(grandTotal) as grand_total'),
                                    DB::raw('count(id) as transaction_num')
                                )
                                ->groupBy('date')
                                ->orderBy('date','desc')
                                ->paginate(30);
        }

        if($type == 'yearly') {
            $transactions = $transactions
                                ->select(
                                    DB::raw('YEAR(created_at) as date'),
                                    DB::raw('sum(grandTotal) as grand_total'),
                                    DB::raw('count(id) as transaction_num')
                                )
                                ->groupBy('date')
                                ->orderBy('date','desc')
                                ->paginate(30);
        }

        return $transactions;
    }

    public function incomeChart($type = 'daily')
    {
        $transactions = new PosTransaction();
        $datasets = [];
        if($type == 'daily') {
            $start = Carbon::now()->subMonth(1);
            $end = Carbon::now();
            $transactions = $transactions
                                ->whereBetween('created_at',[$start, $end])
                                ->select(
                                    DB::raw('DATE_FORMAT(created_at, "%d/%m") as date'),
                                    DB::raw('sum(grandTotal) as grand_total'),
                                    DB::raw('count(id) as transaction_num')
                                )
                                ->groupBy('date')
                                ->orderBy('date','desc')
                                ->get();
                                
            for($date = $start->copy(); $date->lte($end->copy()); $date->addDay()) {
                $labels[] = $date->format('d/m');
                $dateFilters[] = $date->format('d/m/y');
            }
                                
        }

        if($type == 'weekly') {
            $start = Carbon::now()->subMonth(3);
            $end = Carbon::now();
            $transactions = $transactions
                                ->whereBetween('created_at',[$start, $end])
                                ->select(
                                    DB::raw('WEEK(created_at) as date'),
                                    DB::raw('sum(grandTotal) as grand_total'),
                                    DB::raw('count(id) as transaction_num')
                                )
                                ->groupBy('date')
                                ->orderBy('date','desc')->get();
            
            
            foreach (CarbonPeriod::create($start, '1 week', Carbon::now()) as $month) {
                $labels[] = $month->format('W');
            }
        }

        if($type == 'monthly') {
            $start = Carbon::now()->subMonth(11);
            $end = Carbon::now();
            $transactions = $transactions
                                ->whereBetween('created_at',[$start, $end])
                                ->select(
                                    DB::raw('DATE_FORMAT(created_at,"%m/%y") as date'),
                                    DB::raw('sum(grandTotal) as grand_total'),
                                    DB::raw('count(id) as transaction_num')
                                )
                                ->groupBy('date')
                                ->orderBy('date','desc')->get();

            foreach (CarbonPeriod::create($start, '1 month', Carbon::now()) as $month) {
                $labels[] = $month->format('m/y');
            }
        }

        

        $datas = [];
        for($i = 0; $i < count($labels); $i++) {
            $transaction = $transactions->where('date',$labels[$i])->first();
            if($transaction) {
                array_push($datas, $transaction->grand_total);
            } else {
                array_push($datas, 0);
            }
        }

        array_push($datasets, [
            'label' => 'Income',
            'data' => $datas,
            'backgroundColor' => ['rgba(0,0,0,0.1)'],
            'borderColor' => [sprintf('#%06X', mt_rand(0, 0xFFFFFF))],
            'borderWidth' => 2
        ]);

        return [
            'label' => $labels,
            'datasets' => $datasets
        ];
    }

    public function bestSellingProduct($dates = null)
    {
        $products = DB::table('pos_transaction_details')
                        ->join('products','products.id','=','pos_transaction_details.product_id')
                        ->select(DB::raw('sum(pos_transaction_details.amount) as amount'), 'products.name',DB::raw('sum(pos_transaction_details.total) as total'),'products.id as id')
                        ->groupBy('pos_transaction_details.product_id')
                        ->orderBy('amount','DESC')
                        ->get()->take(20);
        return $products; 
    }

}