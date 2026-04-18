<?php

namespace App\Observers;

use App\Models\BookinMonthly;

class BookinMonthlyObserver
{
    /**
     * Handle the BookinMonthly "created" event.
     */
    public function created(BookinMonthly $bookinMonthly): void
    {
        // Notify Admins
        $admins = \App\Models\User::role(config('filament-shield.super_admin.name', 'super_admin'))->get();
        foreach ($admins as $admin) {
            $admin->notify(new \App\Notifications\AdminNewBookingNotification($bookinMonthly, 'monthly'));
        }
    }

    /**
     * Handle the BookinMonthly "updated" event.
     */
    public function updated(BookinMonthly $bookinMonthly): void
    {
        if ($bookinMonthly->isDirty('status')) {
            $newStatus = $bookinMonthly->status;
            
            // Only notify if status is one of the target states
            if (in_array($newStatus, ['accepted', 'confirmed', 'cancelled'])) {
                // Monthly booking belongs to a user through the main booking
                $user = $bookinMonthly->booking?->user;
                if ($user) {
                    $user->notify(new \App\Notifications\BookingStatusNotification($bookinMonthly, $newStatus));
                }
            }
        }
    }

    /**
     * Handle the BookinMonthly "deleted" event.
     */
    public function deleted(BookinMonthly $bookinMonthly): void
    {
        //
    }

    /**
     * Handle the BookinMonthly "restored" event.
     */
    public function restored(BookinMonthly $bookinMonthly): void
    {
        //
    }

    /**
     * Handle the BookinMonthly "force deleted" event.
     */
    public function forceDeleted(BookinMonthly $bookinMonthly): void
    {
        //
    }
}
