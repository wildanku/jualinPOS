<?php

namespace App\Http\Controllers;

use App\Models\Product;
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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $products = $this->productService->getAll($request);

        return view('product.index',compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('product.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3|max:55',
            'sku' => 'sometimes|nullable|unique:products',
            'buy_price' => 'sometimes|nullable|numeric|min:0',
            'sell_price' => 'sometimes|nullable|numeric|min:0',
            'description' => 'sometimes|nullable|min:3',
            'tax_id' => 'sometimes|nullable|numeric',
            'tax_type' => 'sometimes|nullable|in:exclude,include',
            'is_tracked' => 'sometimes|nullable|in:yes,no',
            'stock' => 'sometimes|nullable|numeric',
            'phone' => 'sometimes|nullable|image'
        ]);

        $this->productService->store($request);

        return redirect()->route('product.index')->with('success','Yeey, product added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return view('product.edit',compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|min:3|max:55',
            'sku' => 'sometimes|nullable|unique:products,sku,'.$product->id,
            'buy_price' => 'sometimes|nullable|numeric|min:0',
            'sell_price' => 'sometimes|nullable|numeric|min:0',
            'description' => 'sometimes|nullable|min:3',
            'tax_id' => 'sometimes|nullable|numeric',
            'tax_type' => 'sometimes|nullable|in:exclude,include',
            'is_tracked' => 'sometimes|nullable|in:yes,no',
            'stock' => 'sometimes|nullable|numeric',
            'photo' => 'sometimes|nullable|image'
        ]);   

        $this->productService->update($request, $product);

        return redirect()->route('product.index')->with('success','Yeey, product updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        DB::transaction(function () use($product) {
            $product->delete();
        });

        return redirect()->route('product.index')->with('success','Yeey, product deleted!');
    }
}
