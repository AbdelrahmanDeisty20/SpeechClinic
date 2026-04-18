<?php

namespace App\Services\API;

use App\Models\Appointment;
use App\Traits\ApiResponse;
use Exception;

class SpecialistService
{
    use ApiResponse;

    /**
     * Get the sessions for the authenticated specialist on a specific date.
     */
    public function getSpecialistDailySessions(int $specialistId, ?string $date = null)
    {
        try {
            $date = $date ?? now()->format('Y-m-d');

            $appointments = Appointment::with(['bookinMonthly.booking', 'day'])
                ->where('specialist_id', $specialistId)
                ->where('date', $date)
                ->orderBy('time', 'asc')
                ->get();

            return [
                'status' => true,
                'message' => __('messages.data_retrieved_successfully'),
                'data' => [
                    'specialist_name' => auth()->user()->full_name,
                    'date' => $date,
                    'day_name' => \Carbon\Carbon::parse($date)->translatedFormat('l'),
                    'sessions_count' => $appointments->count(),
                    'sessions' => $appointments,
                ]
            ];
        } catch (Exception $e) {
            return [
                'status' => false,
                'message' => $e->getMessage(),
                'data' => null
            ];
        }
    }
}
