<?php

namespace App\Http\Resources\API;

use App\Filament\Resources\BranchResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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
            'branch' => BranchResource::class::make($this->whenLoaded('branch')),
        ];
    }
}
