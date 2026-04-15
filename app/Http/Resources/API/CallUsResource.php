<?php

namespace App\Http\Resources\API;

use App\Http\Resources\BranchResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

class CallUsResource extends JsonResource
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
            'phone' => $this->phone,
            'branch' => BranchResource::make($this->whenLoaded('branch')),
        ];
    }
}
