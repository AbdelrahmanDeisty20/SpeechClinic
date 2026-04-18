<?php

namespace App\Services\API;

use App\Http\Resources\API\BannerResource;
use App\Models\Banner;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class BannerService
{
    use ApiResponse;

    // public function getBanners()
    // {
    //     $banners = Banner::all();
    //     if ($banners->isEmpty()) {
    //         return [
    //             'status' => false,
    //             'message' => __('messages.banners_notfound'),
    //             'data' => []
    //         ];
    //     }
    //     return [
    //         'status' => true,
    //         'message' => __('messages.banners_successfully'),
    //         'data' => BannerResource::collection($banners)
    //     ];
    // }

    
}
