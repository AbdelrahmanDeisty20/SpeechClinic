<?php

namespace App\Observers;

use App\Models\Booking;

class BookingObserver
{
    /**
     * Handle the Booking "created" event.
     */
    public function created(Booking $booking): void
    {
        if ($booking->type === 'assessment') {
            // Notify Admins
            $admins = \App\Models\User::role(config('filament-shield.super_admin.name', 'super_admin'))->get();
            foreach ($admins as $admin) {
                $admin->notify(new \App\Notifications\AdminNewBookingNotification($booking, 'assessment'));
            }
        }
    }

    /**
     * Handle the Booking "updated" event.
     */
    public function updated(Booking $booking): void
    {
        if ($booking->isDirty('status')) {
            $newStatus = $booking->status;
            
            // Only notify if status is one of the target states
            if (in_array($newStatus, ['accepted', 'confirmed', 'cancelled', 'completed'])) {
                $booking->user->notify(new \App\Notifications\BookingStatusNotification($booking, $newStatus));
            }
        }
    }

    /**
     * Handle the Booking "deleted" event.
     */
    public function deleted(Booking $booking): void
    {
        //
    }

    /**
     * Handle the Booking "restored" event.
     */
    public function restored(Booking $booking): void
    {
        //
    }

    /**
     * Handle the Booking "force deleted" event.
     */
    public function forceDeleted(Booking $booking): void
    {
        //
    }
}
