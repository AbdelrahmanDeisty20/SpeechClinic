<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\CallUsResource;
use Illuminate\Http\Request;
use App\Services\API\CallUsService;
use App\Traits\ApiResponse;

class callUsController extends Controller
{
    use ApiResponse;

    protected $callUsService;
    public function __construct(CallUsService $callUsService) {
        $this->callUsService = $callUsService;
    }

    public function index()
    {
        $result = $this->callUsService->getAll();
        if(!$result['status']){
            return $this->error($result['message'], 400);
        }else{
            return $this->success(CallUsResource::class, $result['data'], $result['message']);
        }
    }
}
