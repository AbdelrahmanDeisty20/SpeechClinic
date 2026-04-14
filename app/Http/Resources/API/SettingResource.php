<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

class SettingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $locale = app()->getLocale();

        return [
            'id'    => $this->id,
            'key'   => $locale === 'ar' ? $this->key_ar   : $this->key_en,
            'value' => $locale === 'ar' ? $this->value_ar : $this->value_en,
            'type'  => $this->type,
        ];
    }
}
