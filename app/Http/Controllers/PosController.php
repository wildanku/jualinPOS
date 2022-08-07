<?php

namespace App\Http\Controllers;

use App\Models\PosTransaction;
use App\Services\CartService;
use App\Services\PosTransactionService;
use Illuminate\Http\Request;

class PosController extends Controller
{
    public $transactionService;

    public function __construct()
    {
        $this->posTransactionService = new PosTransactionService();
    }

    public function index()
    {
        return view('pos.index');
    }

    public function storeTransaction(Request $request)
    {
        $request->validate([
            'paymentmethod' => 'required|numeric',
            'cashAmount' => 'sometimes|nullable|numeric'
        ]);

        $cartService = new CartService();
        $carts = $cartService->get();

        if(!$carts) {
            return redirect()->back()->with('error','Failed to create a transaction');
        }

        $posTransaction = $this->posTransactionService->store($request);

        return redirect()->route('pos.show-transaction', $posTransaction->id);
    }

    public function showTransaction(PosTransaction $posTransaction)
    {
        $transaction = $posTransaction;
        return view('pos.transaction', compact('transaction'));
    }
}
