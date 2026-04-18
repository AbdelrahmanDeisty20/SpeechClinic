<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\GetMonthlyBookingDetailsRequest;
use App\Http\Resources\API\BookinMonthlyResource;
use App\Services\API\BookingService;
use App\Traits\ApiResponse;

class BookingMonthlyController extends Controller
{
    use ApiResponse;

    protected $bookingService;

    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    /**
     * Get the full details of a monthly booking by assessment booking number.
     * 
     * @param GetMonthlyBookingDetailsRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDetails(GetMonthlyBookingDetailsRequest $request)
    {
        $result = $this->bookingService->getMonthlyBookingDetails($request->booking_number);

        if (!$result['status']) {
            return $this->error($result['message'], 404);
        }

        return $this->success(new BookinMonthlyResource($result['data']), $result['message']);
    }
}
