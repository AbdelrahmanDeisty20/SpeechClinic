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

    /**
     * Get Vodafone Cash transfer numbers.
     */
    public function getVodafoneCash()
    {
        $numbers = TransferNumber::where('name', 'like', '%Vodafone%')
            ->orWhere('name', 'like', '%vadafone%')
            ->orWhere('name', 'like', '%فودافون%')
            ->get();

        if ($numbers->isEmpty()) {
            return $this->error(__('messages.no_transfer_numbers_found'), 404);
        }

        return $this->success(TransferNumberResource::collection($numbers), __('messages.data_retrieved_successfully'));
    }

    /**
     * Get InstaPay transfer numbers.
     */
    public function getInstaPay()
    {
        $numbers = TransferNumber::where('name', 'like', '%InstaPay%')
            ->orWhere('name', 'like', '%instabay%')
            ->orWhere('name', 'like', '%انستا%')
            ->get();

        if ($numbers->isEmpty()) {
            return $this->error(__('messages.no_transfer_numbers_found'), 404);
        }

        return $this->success(TransferNumberResource::collection($numbers), __('messages.data_retrieved_successfully'));
    }
}
