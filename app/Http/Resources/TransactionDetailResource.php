<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'product_id'     => $this->product_id,
            'quantity'       => $this->quantity,
            'price_per_item' => $this->price_per_item,
            'subtotal'       => $this->subtotal,
            'product_name'   => $this->product->name ?? null, 
        ];
    }
}
