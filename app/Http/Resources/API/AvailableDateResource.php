<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AvailableDateResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'date' => $this->date,
            'day' => DayResource::make($this->whenLoaded('day')),
            'times' => AvailableTimeResource::collection($this->whenLoaded('availableTimes')),
        ];
    }
}
