<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookinMonthlyResource extends JsonResource
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
            'booking_number' => $this->booking->booking_number ?? null,
            'image' => $this->image ? asset('storage/monthlies/' . $this->image) : null,
            'price' => $this->price,
            'status' => $this->status,
            'booking_details' => new BookingResource($this->whenLoaded('booking')),
            'appointments' => AppointmentResource::collection($this->whenLoaded('appointments')),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
