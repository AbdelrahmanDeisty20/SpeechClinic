<?php

namespace App\Services\API;

use App\Models\Day;
use App\Traits\ApiResponse;

class DayService
{
    use ApiResponse;
    /**
     * Create a new class instance.
     */
    public function getAllDays()
    {
        $days = Day::with('availableTimes','branch')->paginate(10);

        if ($days->isEmpty()) {
            return [
                'status' => false,
                'message' => __('messages.days_notfound'),
                'data' => []
            ];
        }

        return [
            'status' => true,
            'message' => __('messages.days_successfully'),
            'data' => $days
        ];
    }
}
