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
        //
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
