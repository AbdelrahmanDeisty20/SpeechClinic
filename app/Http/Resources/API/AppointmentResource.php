<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentResource extends JsonResource
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
            'date' => $this->date,
            'time' => $this->time ? \Carbon\Carbon::parse($this->time)->format('h:i A') : null,
            'day' => [
                'id' => $this->day_id,
                'name_ar' => $this->day?->name_ar,
                'name_en' => $this->day?->name_en,
            ],
            'specialist' => [
                'id' => $this->specialist_id,
                'full_name' => $this->specialist?->full_name,
            ],
            'branch' => [
                'id' => $this->day?->branch_id,
                'name' => $this->day?->branch?->name,
            ],
        ];
    }
}
