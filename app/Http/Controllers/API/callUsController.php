<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\CallUsResource;
use App\Services\API\CallUsService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class callUsController extends Controller
{
    use ApiResponse;

    protected $callUsService;

    public function __construct(CallUsService $callUsService)
    {
        $this->callUsService = $callUsService;
    }

    public function index()
    {
        $result = $this->callUsService->getAll();
        if (!$result['status']) {
            return $this->error($result['message'], 404);
        } else {
            return $this->paginated(CallUsResource::class, $result['data'], $result['message']);
        }
    }
}
