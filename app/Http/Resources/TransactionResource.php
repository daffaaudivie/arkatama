<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'total_price' => $this->total_price,
            'status' => $this->status,
            'payment_proof' => $this->payment_proof ? asset('storage/' . $this->payment_proof) : null,
            'created_at' => $this->created_at->toDateTimeString(),
        ];

        if ($this->details->count()) {
            $data['details'] = $this->details->map(function ($detail) {
                return [
                    'product_name' => $detail->product->name,
                    'quantity' => $detail->quantity,
                    'price_per_item' => $detail->price_per_item,
                    'subtotal' => $detail->subtotal
                ];
            });
        }

        return $data;
    }
}
