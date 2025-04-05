<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name_hu' =>$this->name_hu,
            'name_en' =>$this->name_en,
            'material_hu' =>$this->material_hu,
            'material_en' =>$this->material_en,
            'description_hu' => $this->description_hu,
            'description_en' => $this->description_en,
            'price_hu' =>$this->price_hu,
            'price_en' =>$this->price_en,
            'image_url' => $this->image_url,
            'stock' => $this->stock,
            'category_hu' =>$this->category_hu,
            'category_en' =>$this->category_en,
        ];
    }
}
