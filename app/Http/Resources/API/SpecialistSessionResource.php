<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SpecialistSessionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        $booking = $this->bookinMonthly?->booking;

        return [
            'id' => $this->id,
            'child_name' => $booking?->child_name ?? __('N/A'),
            'problem' => $booking?->problem_description ?? __('N/A'),
            'date' => $this->date,
            'day_name' => $this->day?->name ?? \Carbon\Carbon::parse($this->date)->translatedFormat('l'),
            'time' => $this->time ? \Carbon\Carbon::parse($this->time)->format('h:i A') : null,
            'status' => $this->bookinMonthly?->status ?? 'pending',
        ];
    }
}
