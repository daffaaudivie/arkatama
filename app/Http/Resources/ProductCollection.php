<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductCollection extends ResourceCollection
{
    // Gunakan ProductResource untuk tiap item
    public $collects = ProductResource::class;

    /**
     * Transform the resource collection into an array.
     */
    public function toArray(Request $request): array
    {
        // Tidak perlu map manual, $collects akan otomatis format setiap item
        return $this->collection->toArray();
    }
}
