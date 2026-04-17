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
                    ->where('type', 'assessment')
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
                $cost = $branch
                    ->cost()
                    ->where('type', 'assessment')
                    ->first();

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
                $bookingNumber = rand(100000, 999999);
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

    public function bookingMonthly(array $data)
    {
        try {
            return DB::transaction(function () use ($data) {
                // 1. Verify assessment booking exists and is for the same child/parent?
                // We'll rely on the assessment booking number.
                $assessment = Booking::where('booking_number', $data['booking_number'])
                    ->where('user_id', auth()->id())  // Ensure they own it
                    ->where('type', 'assessment')
                    ->first();

                if (!$assessment) {
                    return [
                        'status' => false,
                        'message' => __('messages.booking_number_not_found'),
                        'data' => null
                    ];
                }

                // 2. Available time logic
                $availableTime = AvailableTime::with('day.branch.cost')
                    ->lockForUpdate()
                    ->findOrFail($data['available_time_id']);

                if ($availableTime->limit <= 0) {
                    return [
                        'status' => false,
                        'message' => __('messages.insufficient_limit'),
                        'data' => null
                    ];
                }

                // 3. Fetch monthly price
                $branch = $availableTime->day->branch;
                $cost = $branch
                    ->cost()
                    ->where('type', 'monthly')
                    ->first();

                if (!$cost) {
                    return [
                        'status' => false,
                        'message' => __('messages.branch_cost_not_found'),
                        'data' => null
                    ];
                }

                // 4. Handle child photo (monthly might use the same or a new one)
                $photoPath = $assessment->child_photo;  // Default to assessment photo
                if (isset($data['child_photo']) && $data['child_photo'] instanceof \Illuminate\Http\UploadedFile) {
                    $originalPath = $data['child_photo']->store('children', 'public');
                    $photoPath = basename($originalPath);
                }

                // 5. Create the monthly booking
                $booking = Booking::create([
                    'user_id' => auth()->id(),
                    'available_time_id' => $data['available_time_id'],
                    'child_name' => $data['child_name'],
                    'child_age' => $data['child_age'],
                    'child_photo' => $photoPath,
                    'problem_description' => $data['problem_description'],
                    'type' => 'monthly',
                    'price' => $cost->price,
                    'status' => 'pending',
                ]);

                // 6. Decrement the limit
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
