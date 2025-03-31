<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $locale = $request->header('Accept-Language', 'hu'); // Nyelv meghatározása (alapértelmezett: hu)

        return [
            'id' => $this->id,
            'name' => $locale === 'hu' ? $this->name_hu : $this->name_en,
            'material' => $locale === 'hu' ? $this->material_hu : $this->material_en,
            'description' => $locale === 'hu' ? $this->description_hu : $this->description_en,
            'price' => $locale === 'hu' ? $this->price_hu : $this->price_en,
            'image_url' => $this->image_url,
            'stock' => $this->stock,
            'category' => $locale === 'hu' ? $this->category_hu : $this->category_en,
        ];
    }
}
