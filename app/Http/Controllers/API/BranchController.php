<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\API\BranchService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

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
        return $this->paginated($result['data'], $result['message'], 200);
    }
}
