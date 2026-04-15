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
        $callUs = callUs::with('branch')->paginate(10);
        if ($callUs->isEmpty()) {
            return [
                'status' => 404,
                'message' => __('messages.no_call_us_found'),
                'data' => [],
            ];
        }
        return [
            'status' => 200,
            'message' => __('messages.call_us_fetched_successfully'),
            'data' => $callUs,
        ];
    }
}
