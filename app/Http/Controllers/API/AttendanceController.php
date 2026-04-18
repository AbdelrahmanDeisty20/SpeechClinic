<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\CheckInRequest;
use App\Http\Resources\API\AttendanceResource;
use App\Services\API\AttendanceService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    use ApiResponse;

    protected $attendanceService;

    public function __construct(AttendanceService $attendanceService)
    {
        $this->attendanceService = $attendanceService;
    }

    /**
     * Specialist Check-in.
     */
    public function checkIn(CheckInRequest $request)
    {
        $result = $this->attendanceService->checkIn($request->validated());

        if (!$result['status']) {
            return $this->error($result['message'], 422, $result['data']);
        }

        return $this->success(new AttendanceResource($result['data']), $result['message']);
    }

    /**
     * Specialist Check-out.
     */
    public function checkOut(Request $request)
    {
        $result = $this->attendanceService->checkOut($request->all());

        if (!$result['status']) {
            return $this->error($result['message'], 422);
        }

        return $this->success(new AttendanceResource($result['data']), $result['message']);
    }
}
