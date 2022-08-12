<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\PosTransactionService;
use Illuminate\Http\Request;

class PosTransactionController extends Controller
{
    public $posTransactionService;

    public function __construct()
    {
        $this->posTransactionService = new PosTransactionService();
    }

    public function getIncome(Request $request)
    {
        $request->validate([
            'type' => 'sometimes|nullable|in:daily,weekly,monthly'
        ]);

        if(!$request->type) {
            $type = 'daily';
        } else {
            $type = $request->type;
        }

        $income = $this->posTransactionService->incomeChart($type);

        return response(['success' => true, 'labels' => $income['label'], 'datasets' => $income['datasets']],200);
    }

    public function productBestSelling(Request $request)
    {
        $products = $this->posTransactionService->bestSellingProduct($request->date);

        dd($products);
    }

}
