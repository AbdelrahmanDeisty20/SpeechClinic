<?php
namespace App\Services;

use App\Http\Resources\SettingResource;
use App\Models\Setting;
class SettingService{
    public function getSettings()
    {
        $settings = Setting::all();

        if($settings->isEmpty()){
            return [
                'status' => false,
                'message' => __('messages.settings_notfound'),
                'data' => []
            ];
        }
        return [
            'status' => true,
            'message' => __('messages.settings_successfully'),
            'data' => SettingResource::collection($settings)
        ];
    }
}