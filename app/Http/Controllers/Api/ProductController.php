<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductApiResource;
use App\Http\Resources\ProductsPosResource;
use App\Http\Resources\ProductsResource;
use App\Models\CustomProduct;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public $productService;

    public function __construct()
    {
        $this->productService = new ProductService();    
    }

    public function productApi(Request $request)
    {
        $products = $this->productService->get($request);

        return response([
            'http_code' => 200,
            'success'   => true,
            'data'      => new ProductApiResource($products)
        ]);
    }

    public function productsPos(Request $request)
    {
        $products = $this->productService->get($request);

        return response([
            'http_code' => 200,
            'success'   => true,
            'data'      => new ProductsPosResource($products)
        ]);
    }

    public function getCustomProduct(Request $request)
    {   
        $customProduct = new CustomProduct();

        if($request->q) {
            $customProduct = $customProduct->where('name','like','%'.$request->q.'%');
        }

        $customProduct = $customProduct->get()->take(10);
        $customs = [];
        foreach($customProduct as $item) {
            array_push($customs, [
                'id' => $item->id,
                'name' => $item->name,
                'price' => $item->price,
            ]);
        }

        return response([
            'success' => true,
            'message' => 'Custom product found',
            'data' => $customs
        ]);
    }

    public function createCustomProduct(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'nullable|sometimes|numeric'
        ]);

        $customProduct = DB::transaction(function () use($request) {
            $customProduct = CustomProduct::create($request->all());
            
            return $customProduct;
        });

        return response([
            'success' => true,
            'message' => 'Custom product added',
            'data' => $customProduct
        ]);
    }
}
