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
        $messages = [
            'accepted' => 'تم قبول حجزك بنجاح. سنقوم بالتواصل معك قريباً لتأكيد الموعد.',
            'confirmed' => "تم تأكيد حجزك بنجاح. رقم الحجز الخاص بك هو: {$this->booking->booking_number}",
            'cancelled' => 'نعتذر، لقد تم إلغاء حجزك.',
        ];

        $title = 'تحديث حالة الحجز';
        $body = $messages[$this->status] ?? 'تم تحديث حالة حجزك.';

        // Send FCM Notification manually via service
        $fcmService = app(\App\Services\API\FirebaseNotificationService::class);
        foreach ($notifiable->fcmTokens as $token) {
            $fcmService->sendToToken($token->token, $title, $body, [
                'booking_id' => (string) $this->booking->id,
                'status' => $this->status,
                'type' => 'booking_status_update'
            ]);
        }

        $url = $this->booking->type === 'assessment' 
            ? BookingResource::getUrl('view', ['record' => $this->booking->id])
            : BookinMonthlyResource::getUrl('view', ['record' => $this->booking->id]);

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
