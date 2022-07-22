<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductsResource extends ResourceCollection
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
                'name' => $item->name,
                'sell_price' => $item->sell_price_after_tax() ?? 0,
                // 'buy_price'
            ]);
        }

        return $products;
    }
}
