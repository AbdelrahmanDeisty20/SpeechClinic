<?php

namespace App\Services\API;

use App\Models\Experience;

class ExperienceService
{
    /**
     * Get all experience statistics.
     */
    public function getExperiences()
    {
        $experiences = Experience::all();

        if ($experiences->isEmpty()) {
            return [
                'status' => false,
                'message' => __('messages.data_retrieved_successfully'),
                'data' => collect([])
            ];
        }

        return [
            'status' => true,
            'message' => __('messages.data_retrieved_successfully'),
            'data' => $experiences
        ];
    }
}
