<?php

namespace App\Services\API;

use App\Models\Cost;

class CostService
{
    public function getCosts()
    {
        $costs = Cost::with('branch')->paginate(10);

        if ($costs->isEmpty()) {
            return [
                'status' => false,
                'message' => __('messages.costs_not_found'),
                'data' => []
            ];
        }

        return [
            'status' => true,
            'message' => __('messages.costs_successfully'),
            'data' => $costs
        ];
    }
}
