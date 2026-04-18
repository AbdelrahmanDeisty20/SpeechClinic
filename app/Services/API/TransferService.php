<?php

namespace App\Services\API;

use App\Models\TransferNumber;

class TransferService
{
    /**
     * Get Vodafone Cash transfer numbers.
     */
    public function getVodafoneCash()
    {
        $numbers = TransferNumber::where(function($query) {
            $query->where('name', 'like', '%Vodafone%')
                  ->orWhere('name', 'like', '%vadafone%')
                  ->orWhere('name', 'like', '%فودافون%');
        })->get();

        if ($numbers->isEmpty()) {
            return [
                'status' => false,
                'message' => __('messages.no_transfer_numbers_found'),
                'data' => null
            ];
        }

        return [
            'status' => true,
            'message' => __('messages.data_retrieved_successfully'),
            'data' => $numbers
        ];
    }

    /**
     * Get InstaPay transfer numbers.
     */
    public function getInstaPay()
    {
        $numbers = TransferNumber::where(function($query) {
            $query->where('name', 'like', '%InstaPay%')
                  ->orWhere('name', 'like', '%instabay%')
                  ->orWhere('name', 'like', '%انستا%');
        })->get();

        if ($numbers->isEmpty()) {
            return [
                'status' => false,
                'message' => __('messages.no_transfer_numbers_found'),
                'data' => null
            ];
        }

        return [
            'status' => true,
            'message' => __('messages.data_retrieved_successfully'),
            'data' => $numbers
        ];
    }
}
