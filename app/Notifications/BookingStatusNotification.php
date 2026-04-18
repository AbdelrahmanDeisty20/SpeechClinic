<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Filament\Notifications\Notification as FilamentNotification;
use Filament\Actions\Action;
use App\Filament\Resources\BookingResource;
use App\Filament\Resources\BookinMonthlyResource;

class BookingStatusNotification extends Notification
{
    use Queueable;

    protected $booking;
    protected $status;

    /**
     * Create a new notification instance.
     */
    public function __construct($booking, $status)
    {
        $this->booking = $booking;
        $this->status = $status;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        $isMonthly = $this->booking instanceof \App\Models\BookinMonthly;
        $bookingNumber = $isMonthly ? $this->booking->booking?->booking_number : $this->booking->booking_number;
        $bookingType = $isMonthly ? 'الشهري' : 'التقييمي';

        $messages = [
            'accepted' => "تم قبول حجزك {$bookingType} بنجاح. سنقوم بالتواصل معك قريباً لتأكيد الموعد.",
            'confirmed' => "تم تأكيد حجزك {$bookingType} بنجاح. رقم الحجز الخاص بك هو: {$bookingNumber}",
            'cancelled' => "نعتذر، لقد تم إلغاء حجزك {$bookingType}.",
        ];

        $title = 'تحديث حالة الحجز';
        $body = $messages[$this->status] ?? 'تم تحديث حالة حجزك.';

        \App\Models\AppNotification::create([
            'user_id' => $notifiable->id,
            'title' => $title,
            'body' => $body,
            'type' => 'booking_status_update',
            'data' => [
                'booking_id' => (string) ($isMonthly ? $this->booking->booking_id : $this->booking->id),
                'status' => $this->status,
            ],
        ]);

        $url = (!$isMonthly && $this->booking->type === 'assessment') 
            ? BookingResource::getUrl('view', ['record' => $this->booking->id])
            : BookinMonthlyResource::getUrl('view', ['record' => ($isMonthly ? $this->booking->id : $this->booking->monthlyBooking?->id)]);

        return FilamentNotification::make()
            ->title($title)
            ->body($body)
            ->success()
            ->actions([
                Action::make('view')
                    ->label(__('عرض التفاصيل'))
                    ->url($url)
                    ->color('primary'),
            ])
            ->getDatabaseMessage();
    }
}
