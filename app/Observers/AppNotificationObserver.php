<?php

namespace App\Observers;

use App\Models\AppNotification;
use App\Models\UserFcmToken;
use App\Services\API\FirebaseNotificationService;

class AppNotificationObserver
{
    protected $firebaseService;

    public function __construct(FirebaseNotificationService $firebaseService)
    {
        $this->firebaseService = $firebaseService;
    }

    /**
     * Handle the AppNotification "created" event.
     */
    public function created(AppNotification $notification): void
    {
        $title = $notification->title;
        $body = $notification->body;
        $data = array_merge($notification->data ?? [], [
            'id' => (string) $notification->id,
            'type' => $notification->type,
        ]);

        if ($notification->user_id) {
            // Private Notification
            $tokens = UserFcmToken::where('user_id', $notification->user_id)->pluck('token')->toArray();
        } else {
            // General Notification (Broadcast)
            $tokens = UserFcmToken::pluck('token')->toArray();
        }

        foreach ($tokens as $token) {
            $this->firebaseService->sendToToken($token, $title, $body, $data);
        }
    }
}
