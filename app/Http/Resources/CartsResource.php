<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CartsResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $carts = [];

        foreach($this->collection as $item) {
            array_push($carts, [
                'id' => $item->id,
                'user' => [
                    'id' => $item->user->id ?? '',
                    'name' => $item->user->name ?? '',
                ],
                'product' => [
                    'id' => $item->product->id,
                    'name' => $item->product->name,
                    'price' => [
                        'num' => $item->product->sell_price_after_tax() ?? 0,
                        'text' => 'Rp. '.number_format($item->product->sell_price_after_tax() ?? 0),
                    ],
                ],
                'amount' => $item->amount,
                'total' => [
                    'num' => $item->amount * $item->product->sell_price_after_tax(),
                    'text' => 'Rp. '.number_format($item->amount * $item->product->sell_price_after_tax())
                ]
            ]);
        }

        return $carts;
    }
}