<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductsPosResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $products = [];
        foreach($this->collection as $item) {
            array_push($products, [
                'id' => $item->id,
                'sku' => $item->sku,
                'name' => $item->name,
                'sell_price' => [
                    'num' => $item->sell_price_after_tax() ?? 0,
                    'text' => $item->sell_price_after_tax() ? currency()->symbol.' '.number_format($item->sell_price_after_tax() ?? 0) : 0
                ],
                'image' => $item->photo ? asset($item->photo) : asset('images/no_product.png'),
                'is_tracked' => $item->is_tracked,
                'stock' => [
                    'num' => $item->latest_stock() ?? 0,
                    'text' => $item->is_tracked == 1 ? $item->latest_stock().' left' : 'not tracked'
                ],
                'in_cart' => $item->getCart()
            ]);
        }

        return $products;
    }
}
