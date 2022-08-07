<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CartsResource;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public $cartService;

    public function __construct()
    {
        $this->cartService = new CartService();    
    }

    public function get()
    {
        $carts = $this->cartService->get();
        return response([
            'http_code' => 200,
            'success' => true,
            'data' => [
                'carts' => new CartsResource($carts['carts']),
                'subTotal' => [
                    'num' => $carts['subTotal'],
                    'text' => 'Rp. '.number_format($carts['subTotal'])
                ],
                'totalTax' => [
                    'num' => $carts['totalTax'],
                    'text' => 'Rp. '.number_format($carts['totalTax'])
                ],
                'grandTotal' => [
                    'num' => $carts['grandTotal'],
                    'text' => 'Rp. '.number_format($carts['grandTotal'])
                ],
            ],
            
        ]);  
    }

    public function create(Request $request)
    {
        $request->validate([
            'product_id' => 'required|numeric',
            'amount' => 'required|numeric|min:0'
        ]);

        $addCart = $this->cartService->create($request);

        return response([
            'http_code' => $addCart['code'],
            'success' => $addCart['success'],
            'message' => $addCart['message']
        ],$addCart['code']);
    }

    public function createCustom(Request $request)
    {
        $request->validate([
            'product_id' => 'required|numeric',
            'price' => 'nullable|sometimes|numeric|min:0',
            'amount' => 'nullable|sometimes|numeric|min:0'
        ]);

        $addCart = $this->cartService->createCustom($request);

        return response([
            'http_code' => $addCart['code'],
            'success' => $addCart['success'],
            'message' => $addCart['message']
        ],$addCart['code']);
    }

    public function clear()
    {
        $this->cartService->clearCart();
        
        return response([
            'http_code' => 200,
            'success' => true,
            'message' => 'Cart deleted'
        ],200);
    }
}
