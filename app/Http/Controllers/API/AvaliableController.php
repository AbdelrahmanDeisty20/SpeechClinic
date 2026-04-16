<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\AvailableTimeResource;
use App\Services\API\AvaliableService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class AvaliableController extends Controller
{
    use ApiResponse;
    protected $avaliableService;
    public function __construct(AvaliableService $avaliableService)
    {
        $this->avaliableService = $avaliableService;
    }
    public function index()
    {
        $result = $this->avaliableService->getAllAvailableTimes();
        if (!$result['status']) {
            return $this->error($result['message'], 404);
        } else {
            return $this->paginated(AvailableTimeResource::class, $result['data'], $result['message']);
        }
    }
}
