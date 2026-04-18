<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\ExperienceResource;
use App\Services\API\ExperienceService;
use App\Traits\ApiResponse;

class ExperienceController extends Controller
{
    use ApiResponse;

    protected $experienceService;

    public function __construct(ExperienceService $experienceService)
    {
        $this->experienceService = $experienceService;
    }

    /**
     * Get all experience statistics.
     */
    public function index()
    {
        $result = $this->experienceService->getExperiences();
        
        return $this->success(
            ExperienceResource::collection($result['data']), 
            $result['message']
        );
    }
}
