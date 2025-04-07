<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductApiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'sku' => $this->sku,
            'name' => $this->name,
            'sell_price' => [
                'num' => $this->sell_price_after_tax() ?? 0,
                'text' => $this->sell_price_after_tax() ? currency()->symbol . ' ' . number_format($this->sell_price_after_tax() ?? 0) : 0
            ],
            'image' => $this->photo ? asset($this->photo) : asset('images/no_product.png'),
            'is_tracked' => $this->is_tracked,
            'stock' => [
                'num' => $this->latest_stock() ?? 0,
                'text' => $this->is_tracked == 1 ? $this->latest_stock() . ' left' : 'not tracked'
            ],
        ];
    }
}
