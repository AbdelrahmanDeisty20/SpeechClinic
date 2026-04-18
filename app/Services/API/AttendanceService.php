<?php

namespace App\Services\API;

use App\Models\Attendance;
use App\Models\Branch;
use App\Traits\ApiResponse;
use Exception;
use Carbon\Carbon;

class AttendanceService
{
    use ApiResponse;

    /**
     * Handle Specialist Check-in.
     */
    public function checkIn(array $data)
    {
        try {
            $specialistId = auth()->id();
            $date = Carbon::now()->format('Y-m-d');
            $time = Carbon::now()->format('H:i:s');

            // 1. Verify branch exists
            $branch = Branch::findOrFail($data['branch_id']);

            // 2. Check distance (Mandatory Check)
            $distance = $this->calculateDistance($data['lat'], $data['lng'], $branch->lat, $branch->lng);
            
            // Allow a 100-meter radius (0.1 km)
            if ($distance > 0.1) {
                return [
                    'status' => false,
                    'message' => __('messages.too_far_from_branch'),
                    'data' => [
                        'distance_meters' => round($distance * 1000, 2),
                        'max_allowed_meters' => 100
                    ]
                ];
            }

            // 3. Check for existing record
            $attendance = Attendance::where('user_id', $specialistId)
                ->where('date', $date)
                ->where('branch_id', $data['branch_id'])
                ->first();

            if ($attendance && $attendance->check_in) {
                return [
                    'status' => false,
                    'message' => __('messages.already_checked_in_today'),
                    'data' => $attendance
                ];
            }

            // 4. Record Check-in
            $attendance = Attendance::updateOrCreate(
                ['user_id' => $specialistId, 'date' => $date, 'branch_id' => $data['branch_id']],
                [
                    'check_in' => $time,
                    'lat' => $data['lat'] ?? null,
                    'lng' => $data['lng'] ?? null,
                    'status' => 'on_time', // Logic for 'late' could be added if branch has start_time
                ]
            );

            return [
                'status' => true,
                'message' => __('messages.check_in_successful'),
                'data' => $attendance
            ];

        } catch (Exception $e) {
            return [
                'status' => false,
                'message' => $e->getMessage(),
                'data' => null
            ];
        }
    }

    /**
     * Handle Specialist Check-out.
     */
    public function checkOut(array $data)
    {
        try {
            $specialistId = auth()->id();
            $date = Carbon::now()->format('Y-m-d');
            $time = Carbon::now()->format('H:i:s');

            // Find the attendance record for today (The user should check out from the last active branch)
            $attendance = Attendance::where('user_id', $specialistId)
                ->where('date', $date)
                ->whereNull('check_out')
                ->latest()
                ->first();

            if (!$attendance) {
                return [
                    'status' => false,
                    'message' => __('messages.no_active_check_in_found'),
                    'data' => null
                ];
            }

            $attendance->update([
                'check_out' => $time,
            ]);

            return [
                'status' => true,
                'message' => __('messages.check_out_successful'),
                'data' => $attendance
            ];

        } catch (Exception $e) {
            return [
                'status' => false,
                'message' => $e->getMessage(),
                'data' => null
            ];
        }
    }

    /**
     * Calculate distance between two points (Haversine Formula).
     * Returns distance in Kilometers.
     */
    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371;

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLon / 2) * sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }
}
