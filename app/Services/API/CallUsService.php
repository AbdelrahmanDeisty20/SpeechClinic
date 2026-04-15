<?php

namespace App\Services\API;

use App\Http\Resources\API\CallUsResource;
use App\Models\callUs;
use App\Traits\ApiResponse;

class CallUsService
{
    use ApiResponse;
    /**
     * Create a new class instance.
     */
    public function getAll()
    {
        $data = callUs::with('branch')->paginate(10);
        if ($data->isEmpty()) {
            return [
                'status' => 404,
                'message' => __('messages.no_call_us_found'),
                'data' => [],
            ];
        }
        return [
            'status' => 200,
            'message' => __('messages.call_us_fetched_successfully'),
            'data' => $data,
        ];
    }
}
