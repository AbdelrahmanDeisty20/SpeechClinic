<?php

namespace App\Services\API;

use App\Http\Resources\API\BookingResource;
use App\Models\AvailableTime;
use App\Models\Booking;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Exception;

class BookingService
{
    use ApiResponse;

    /**
     * Create a new assessment booking.
     */
    public function createBooking(array $data)
    {
        try {
            return DB::transaction(function () use ($data) {
                // Lock the available time for update to prevent race conditions
                $availableTime = AvailableTime::with('day.branch.cost')
                    ->lockForUpdate()
                    ->findOrFail($data['available_time_id']);

                // 1. Check if limit is sufficient
                if ($availableTime->limit <= 0) {
                    return [
                        'status' => false,
                        'message' => __('messages.insufficient_limit'),
                        'data' => null
                    ];
                }

                // 2. Fetch price from branch cost
                $branch = $availableTime->day->branch;
                $cost = $branch->cost;

                if (!$cost) {
                    return [
                        'status' => false,
                        'message' => __('messages.branch_cost_not_found'),
                        'data' => null
                    ];
                }

                // 3. Handle child photo upload
                $photoPath = null;
                if (isset($data['child_photo']) && $data['child_photo'] instanceof \Illuminate\Http\UploadedFile) {
                    $originalPath = $data['child_photo']->store('children', 'public');
                    $photoPath = basename($originalPath);
                }

                // Generate booking number
                $bookingNumber = $this->generateBookingNumber();

                // 4. Create the booking
                $booking = Booking::create([
                    'user_id' => auth()->id(),
                    'available_time_id' => $data['available_time_id'],
                    'booking_number' => $bookingNumber,
                    'child_name' => $data['child_name'],
                    'child_age' => $data['child_age'],
                    'child_photo' => $photoPath,
                    'problem_description' => $data['problem_description'],
                    'type' => 'assessment',
                    'price' => $cost->price,
                    'status' => 'pending',
                ]);

                // 5. Decrement the limit
                $availableTime->decrement('limit');

                return [
                    'status' => true,
                    'message' => __('messages.booking_success'),
                    'data' => $booking
                ];
            });
        } catch (Exception $e) {
            return [
                'status' => false,
                'message' => $e->getMessage(),
                'data' => null
            ];
        }
    }

    /**
     * Get user bookings.
     */
    public function getUserBookings()
    {
        $bookings = Booking::with('availableTime.day.branch')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        if ($bookings->isEmpty()) {
            return [
                'status' => false,
                'message' => __('messages.no_bookings_found'),
                'data' => null
            ];
        }

        return [
            'status' => true,
            'message' => __('messages.bookings_fetched_successfully'),
            'data' => BookingResource::collection($bookings)
        ];
    }
    public function getAllBookings()
    {
        $bookings = Booking::with('availableTime.day.branch')
            ->latest()
            ->paginate(10);

        if ($bookings->isEmpty()) {
            return [
                'status' => false,
                'message' => __('messages.no_bookings_found'),
                'data' => []
            ];
        }

        return [
            'status' => true,
            'message' => __('messages.bookings_fetched_successfully'),
            'data' => BookingResource::collection($bookings)
        ];
    }
}
