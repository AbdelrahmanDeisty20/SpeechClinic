<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\SpecialistSessionResource;
use App\Services\API\SpecialistService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class SpecialistController extends Controller
{
    use ApiResponse;

    protected $specialistService;

    public function __construct(SpecialistService $specialistService)
    {
        $this->specialistService = $specialistService;
    }

    /**
     * Get the specialist's sessions for a specific date.
     */
    public function getDailySessions(Request $request)
    {
        $result = $this->specialistService->getSpecialistDailySessions(
            auth()->id(),
            $request->date
        );

        if (!$result['status']) {
            return $this->error($result['message'], 404);
        }

        // Wrap data with the Resource collection
        $responseData = $result['data'];
        $responseData['sessions'] = SpecialistSessionResource::collection($responseData['sessions']);

        return $this->success($responseData, $result['message']);
    }
}
