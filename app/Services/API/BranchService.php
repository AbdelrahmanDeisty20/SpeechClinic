<?php
namespace App\Services\API;

use App\Models\Branch;
use App\Http\Resources\BranchResource;
class BranchService{
    public function getBranches()
    {
        $branches = Branch::paginate(10);
        if($branches->isEmpty()){
            return [
                'status' => false,
                'message' => __('messages.branches_not_found'),
                'data' => []
            ];
        }
        return [
            'status' => true,
            'message' => __('messages.branches_retrieved_successfully'),
            'data' => BranchResource::collection($branches)
        ];
    }
}