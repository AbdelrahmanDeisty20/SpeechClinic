<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Filament\Notifications\Notification as FilamentNotification;
use Filament\Notifications\Actions\Action;
use App\Filament\Resources\BookingResource;
use App\Filament\Resources\BookinMonthlyResource;

class AdminNewBookingNotification extends Notification
{
    use Queueable;

    protected $booking;
    protected $type;

    /**
     * Create a new notification instance.
     */
    public function __construct($booking, $type)
    {
        $this->booking = $booking;
        $this->type = $type; // 'assessment' or 'monthly'
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        if ($this->type === 'assessment') {
            $title = 'حجز تقييمي جديد';
            $message = "يوجد حجز تقييمي جديد قيد الانتظار للطفل {$this->booking->child_name}.";
        } else {
            $title = 'حجز شهري جديد';
            $bookingNumber = $this->booking->booking->booking_number ?? $this->booking->booking_id;
            $message = "تم حجز كشف شهري جديد برقم طلب {$bookingNumber}.";
        }

        $url = $this->type === 'assessment' 
            ? BookingResource::getUrl('view', ['record' => $this->booking->id])
            : BookinMonthlyResource::getUrl('view', ['record' => $this->booking->id]);

        return FilamentNotification::make()
            ->title($title)
            ->body($message)
            ->info()
            ->actions([
                Action::make('view')
                    ->label(__('عرض التفاصيل'))
                    ->url($url)
                    ->color('primary'),
            ])
            ->getDatabaseMessage();
    }
}
