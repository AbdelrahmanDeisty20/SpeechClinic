<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\API\CvProfileService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class CVProfileController extends Controller
{
    use ApiResponse;
    protected $CvProfileService;
    public function __construct(CvProfileService $CvProfileService)
    {
        $this->CvProfileService = $CvProfileService;
    }
    public function getCvProfile()
    {
        $cv = $this->CvProfileService->getCvProfile();
        if(!$cv['status']){
            return $this->error($cv['message'], 400);
        }
        return $this->success($cv['data'], $cv['message'], 200);
    }
}
