<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\SettingService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    use ApiResponse;
    
    protected $SettingService;
    public function __construct(SettingService $SettingService){
        $this->SettingService = $SettingService;
    }
    public function index(){
        $settings = $this->SettingService->getSettings();
        if(!$settings['status']){
            return $this->error($settings['message'], 400);
        }
        return $this->success($settings['data'], $settings['message'], 200);
    }
}
