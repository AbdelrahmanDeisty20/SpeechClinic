<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\BranchResource;
use App\Services\API\BranchService;
use App\Traits\ApiResponse;

class BranchController extends Controller
{
    use ApiResponse;

    protected $branchService;

    public function __construct(BranchService $branchService)
    {
        $this->branchService = $branchService;
    }

    public function getBranches()
    {
        $result = $this->branchService->getBranches();
        if (!$result['status']) {
            return $this->error($result['message'], 400);
        }
        return $this->paginated(BranchResource::class, $result['data'], $result['message']);
    }
}
