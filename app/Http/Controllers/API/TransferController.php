<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\TransferNumberResource;
use App\Models\TransferNumber;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class TransferController extends Controller
{
    use ApiResponse;

    protected $transferService;

    public function __construct(\App\Services\API\TransferService $transferService)
    {
        $this->transferService = $transferService;
    }

    /**
     * Get Vodafone Cash transfer numbers.
     */
    public function getVodafoneCash()
    {
        $result = $this->transferService->getVodafoneCash();
        
        if (!$result['status']) {
            return $this->error($result['message'], 404);
        }

        return $this->success(TransferNumberResource::collection($result['data']), $result['message']);
    }

    /**
     * Get InstaPay transfer numbers.
     */
    public function getInstaPay()
    {
        $result = $this->transferService->getInstaPay();
        
        if (!$result['status']) {
            return $this->error($result['message'], 404);
        }

        return $this->success(TransferNumberResource::collection($result['data']), $result['message']);
    }
}

