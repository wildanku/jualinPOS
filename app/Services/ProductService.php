<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductPrice;
use App\Models\ProductStockHistory;
use Illuminate\Support\Facades\DB;

Class ProductService
{
    public function getAll($request)
    {
        $products = new Product();

        if($request->q ?? null) {
            $products = $products->where('name','like','%'.$request->q.'%')->orWhere('sku','like','%'.$request->q.'%');
        }

        $products = $products->paginate($request->offset ?? 30);

        return $products;
    }

    public function get($request)
    {
        $products = new Product();

        if($request->q ?? null) {
            $products = $products->where('name','like','%'.$request->q.'%')->orWhere('sku','like','%'.$request->q.'%');
        }

        $products = $products->take($request->offset ?? 30)->get();

        return $products;
    }

    public function store($request)
    {
        return DB::transaction(function () use($request) {
            if($request->is_tracked == 'yes') {
                $is_tracked = 1;
            } elseif($request->is_tracked == 'no') {
                $is_tracked = 0;
            }

            $product = Product::create([
                'name' => $request->name,
                'description' => $request->description,
                'sku' => $request->sku,
                'is_tracked' => $is_tracked,
                'tax_id' => $request->tax_id,
                'tax_type' => $request->tax_type
            ]);

            if($request->buy_price) {
                ProductPrice::create([
                    'product_id' => $product->id,
                    'type' => 'buy_price',
                    'price' => $request->buy_price
                ]);
            }

            if($request->sell_price) {
                ProductPrice::create([
                    'product_id' => $product->id,
                    'type' => 'sell_price',
                    'price' => $request->sell_price
                ]);
            }

            if($request->is_tracked == 'yes') {
                ProductStockHistory::create([
                    'product_id' => $product->id,
                    'type' => 'in',
                    'amount' => $request->stock,
                    'current_stock' => $request->stock
                ]);
            }

            if($request->photo) {
                $imageName = date('Ymd-His').'.'.$request->photo->extension();
                $request->photo->move(public_path('images/products'), $imageName);  

                $product->photo = 'images/products/'.$imageName;
                $product->save();
            }

        });
    }

    public function update($request, $product)
    {
        return DB::transaction(function () use($request, $product) {
            if($request->is_tracked == 'yes') {
                $is_tracked = 1;
            } elseif($request->is_tracked == 'no') {
                $is_tracked = 0;
            }

            $product->update([
                'name' => $request->name,
                'description' => $request->description,
                'sku' => $request->sku,
                'is_tracked' => $is_tracked,
                'tax_id' => $request->tax_id,
                'tax_type' => $request->tax_type
            ]);

            if($product->buy_prices()->count() > 0 && $request->buy_price != $product->buy_price()) {
                
                ProductPrice::create([
                    'product_id' => $product->id,
                    'type' => 'buy_price',
                    'price' => $request->buy_price
                ]);
            }

            if($product->sell_prices()->count() > 0 && $request->sell_price != $product->sell_price()) {
                ProductPrice::create([
                    'product_id' => $product->id,
                    'type' => 'sell_price',
                    'price' => $request->sell_price
                ]);
            }

            if($request->is_tracked == 'yes') {
                if($request->stock != $product->latest_stock()) {
                    if ($request->stock < $product->latest_stock()) {
                        $stockType = 'out';
                        $amountStock = (int)$product->latest_stock() - (int)$request->stock;
                        $current_stock = $request->stock;
                    } elseif ($request->stock > $product->latest_stock()) {
                        $stockType = 'in';
                        $amountStock = (int)$product->latest_stock() + (int)$request->stock;
                        $current_stock = $request->stock;
                    }

                    ProductStockHistory::create([
                        'product_id' => $product->id,
                        'type' => $stockType,
                        'amount' => $amountStock,
                        'current_stock' => $current_stock
                    ]);
                }
            }

            if($request->photo) {
                $imageName = date('Ymd-His').'.'.$request->photo->extension();
                $request->photo->move(public_path('images/products'), $imageName);  

                $product->photo = 'images/products/'.$imageName;
                $product->save();
            }

        });
    }

    public function adjustSaveStock($request) 
    {
        
    }
}