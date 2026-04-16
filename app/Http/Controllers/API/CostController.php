<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\CostResource;
use App\Services\API\CostService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class CostController extends Controller
{
    use ApiResponse;
    protected $costService;
    public function __construct(CostService $costService)
    {
        $this->costService = $costService;
    }
    public function index()
    {
        $result = $this->costService->getAllCosts();
        if (!$result['status']) {
            return $this->error($result['message'], 404);
        } else {
            return $this->paginated(CostResource::class, $result['data'], $result['message']);
        }
    }
}
