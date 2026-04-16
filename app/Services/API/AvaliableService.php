<?php

namespace App\Services\API;

use App\Models\AvailableTime;
use App\Traits\ApiResponse;

class AvaliableService
{
    use ApiResponse;
    /**
     * Create a new class instance.
     */
    public function getAllAvailableTimes()
    {
        $availableTimes = AvailableTime::paginate(10);

        if ($availableTimes->isEmpty()) {
            return [
                'status' => false,
                'message' => __('messages.available_times_notfound'),
                'data' => []
            ];
        }

        return [
            'status' => true,
            'message' => __('messages.available_times_successfully'),
            'data' => $availableTimes
        ];
    }
}
