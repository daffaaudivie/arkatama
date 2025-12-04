<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
{
    $data = [
        'id'          => $this->id,
        'total_price' => $this->total_price,
        'status'      => $this->status,
        'created_at'  => $this->created_at->toDateTimeString(),
    ];

// if (auth()->guard('sanctum')->user() instanceof \App\Models\Admin) {
    //     $data['details'] = TransactionDetailResource::collection($this->details);
    // }

    if ($this->details->count()) {
    $data['details'] = TransactionDetailResource::collection($this->details);
}

    return $data;
}

}
