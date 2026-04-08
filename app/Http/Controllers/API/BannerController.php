<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\BannerService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    use ApiResponse;

    protected $bannerService;

    public function __construct(BannerService $bannerService)
    {
        $this->bannerService = $bannerService;
    }

    public function index()
    {
        $result = $this->bannerService->getBanners();
        if (!$result['status']) {
            return $this->error($result['message'], 400);
        }
        return $this->success($result['data'], $result['message'], 200);
    }

    // public function store(Request $request)
    // {
    //     $result = $this->bannerService->storeBanner($request);
    //     if (!$result['status']) {
    //         return $this->error($result['message'], 400);
    //     }
    //     return $this->success($result['data'], $result['message'], 200);
    // }
}
