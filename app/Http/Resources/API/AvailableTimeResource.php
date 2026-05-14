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
            'time' => $this->time ? \Carbon\Carbon::parse($this->time)->format('h:i A') : null,
            'limit' => (int) $this->limit,
            'day' => $this->when($this->day_id, DayResource::make($this->whenLoaded('day'))),
            'date' => $this->when($this->date_id, AvailableDateResource::make($this->whenLoaded('date'))),
        ];
    }
}
