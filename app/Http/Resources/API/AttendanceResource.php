<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttendanceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'specialist_name' => $this->user?->full_name,
            'branch' => [
                'id' => $this->branch_id,
                'name' => $this->branch?->name,
            ],
            'date' => $this->date,
            'check_in' => $this->check_in ? \Carbon\Carbon::parse($this->check_in)->format('h:i A') : null,
            'check_out' => $this->check_out ? \Carbon\Carbon::parse($this->check_out)->format('h:i A') : null,
            'status' => $this->status,
            'location' => [
                'lat' => $this->lat,
                'lng' => $this->lng,
            ],
        ];
    }
}
