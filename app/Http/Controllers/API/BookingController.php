<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\BookingMonthlyRequest;
use App\Http\Requests\API\BookingRequest;
use App\Http\Resources\API\BookingResource;
use App\Services\API\BookingService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    use ApiResponse;
    protected $bookingService;

    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    public function index()
    {
        $result = $this->bookingService->getUserBookings();
        if (!$result['status']) {
            return $this->error($result['message'], 404);
        }
        return $this->paginated(BookingResource::class, $result['data'], $result['message']);
    }

    public function store(BookingRequest $request)
    {
        $result = $this->bookingService->createBooking($request->validated());
        if (!$result['status']) {
            return $this->error($result['message'], 422);
        }
        return $this->success(BookingResource::make($result['data']), $result['message']);
    }
    public function storeMonthly(BookingMonthlyRequest $request)
    {
        $result = $this->bookingService->bookingMonthly($request->validated());
        if (!$result['status']) {
            return $this->error($result['message'], 422);
        }
        return $this->success(BookingResource::make($result['data']), $result['message']);
    }
    public function getAllBookings()
    {
        $result = $this->bookingService->getAllBookings();
        if (!$result['status']) {
            return $this->error($result['message'], 404);
        }
        return $this->paginated(BookingResource::class, $result['data'], $result['message']);
    }
}
