<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AvailableTimeResource extends JsonResource
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
            'day_id' => $this->day_id,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'limit' => (int) $this->limit,
            'day' => DayResource::make($this->whenLoaded('day')),
        ];
    }
}
