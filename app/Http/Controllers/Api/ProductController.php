<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductsPosResource;
use App\Http\Resources\ProductsResource;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public $productService;

    public function __construct()
    {
        $this->productService = new ProductService();    
    }

    public function productsPos(Request $request)
    {
        $products = $this->productService->get($request);

        return response([
            'http_code' => 200,
            'success' => true,
            'data' => new ProductsPosResource($products)
        ]);
    }
}
