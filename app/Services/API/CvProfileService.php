<?php
namespace App\Services\API;

use App\Http\Resources\API\CVResource;
use App\Models\Cv;
class CvProfileService{
    public function getCvProfile()
    {
      $cv = Cv::all();
      if($cv->isEmpty()){
        return [
            'status' => false,
            'message' => __('messages.cv_notfound'),
            'data' => []
        ];
      }
      return [
        'status' => true,
        'message' => __('messages.cv_successfully'),
        'data' => CVResource::collection($cv)
      ];  
    }
}