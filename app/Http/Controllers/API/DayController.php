<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\DayResource;
use App\Services\API\DayService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class DayController extends Controller
{
    use ApiResponse;
    protected $dayService;
    public function __construct(DayService $dayService)
    {
        $this->dayService = $dayService;
    }
    public function index()
    {
        $result = $this->dayService->getAllDays();
        if (!$result['status']) {
            return $this->error($result['message'], 404);
        } else {
            return $this->paginated(DayResource::class, $result['data'], $result['message']);
        }
    }
}
