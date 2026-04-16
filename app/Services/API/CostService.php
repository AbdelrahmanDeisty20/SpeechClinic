<?php

namespace App\Services\API;

use App\Http\Resources\API\CostResource;
use App\Models\Cost;
use App\Traits\ApiResponse;

class CostService
{
    use ApiResponse;
    /**
     * Create a new class instance.
     */
    public function getAllCosts()
    {
        $costs = Cost::with('branch')->paginate(10);

        if ($costs->isEmpty()) {
            return [
                'status' => false,
                'message' => __('messages.costs_not_found'),
                'data' => null,
            ];
        }

        return [
            'status' => true,
            'message' => __('messages.costs_successfully'),
            'data' => CostResource::collection($costs),
        ];
    }
}
