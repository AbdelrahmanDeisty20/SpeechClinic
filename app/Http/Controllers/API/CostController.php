<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\CostResource;
use App\Services\API\CostService;
use App\Traits\ApiResponse;

class CostController extends Controller
{
    use ApiResponse;

    protected $costService;

    public function __construct(CostService $costService)
    {
        $this->costService = $costService;
    }

    /**
     * Get clinic costs.
     */
    public function index()
    {
        $result = $this->costService->getCosts();
        
        if (!$result['status']) {
            return $this->error($result['message'], 404);
        }

        return $this->paginated(CostResource::class, $result['data'], $result['message']);
    }
}
