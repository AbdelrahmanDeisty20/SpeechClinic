<?php
namespace App\Services\API;

use App\Http\Resources\API\SettingResource;
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