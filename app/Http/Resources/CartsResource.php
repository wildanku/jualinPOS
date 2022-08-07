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
            if($item->custom_product_id) {
                array_push($carts, [
                    'id' => $item->id,
                    'user' => [
                        'id' => $item->user->id ?? '',
                        'name' => $item->user->name ?? '',
                    ],
                    'product' => [
                        'type' => 'custom',
                        'id' => $item->customProduct->id ?? '',
                        'name' => $item->customProduct->name ?? '',
                        'price' => [
                            'num' => $item->price ?? 0,
                            'text' => 'Rp. '.number_format($item->price ?? 0),
                        ],
                    ],
                    'amount' => $item->amount,
                    'total' => [
                        'num' => $item->amount * $item->price,
                        'text' => 'Rp. '.number_format($item->amount * $item->price)
                    ]
                ]);
            } else {
                array_push($carts, [
                    'id' => $item->id,
                    'user' => [
                        'id' => $item->user->id ?? '',
                        'name' => $item->user->name ?? '',
                    ],
                    'product' => [
                        'type' => 'product',
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
        }

        return $carts;
    }
}
