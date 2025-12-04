<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
  
    public function toArray(Request $request): array
{
    $originalImage = $this->image; //tampilan nama clean

    $displayImage = preg_replace('/^\d+_/', '', $this->image); //tampilan url sesuai nama asli

    return [
        'id' => $this->id,
        'name' => $this->name,
        'category' => $this->category?->name,
        'image' => $displayImage,
        'image_url' => asset('storage/products/' . $originalImage), // pakai file sebenarnya
        'description' => $this->description,
        'price' => $this->price,
        'stock' => $this->stock,
    ];
}

}
