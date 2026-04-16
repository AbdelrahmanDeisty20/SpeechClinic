<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'child_name' => $this->child_name,
            'child_age' => $this->child_age,
            'child_photo' => $this->child_photo_url,
            'problem_description' => $this->problem_description,
            'type' => $this->type,
            'price' => (float) $this->price,
            'status' => $this->status,
            'available_time' => AvailableTimeResource::make($this->whenLoaded('availableTime')),
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
