<?php

namespace App\Services\API;

use App\Http\Resources\API\NotificationResource;
use App\Models\AppNotification;
use App\Models\UserFcmToken;
use App\Services\API\FirebaseNotificationService;

class NotificationService
{
    protected $firebaseService;

    public function __construct(FirebaseNotificationService $firebaseService)
    {
        $this->firebaseService = $firebaseService;
    }

    public function sendToken(array $data)
    {
        $userId = $data['user_id'] ?? auth()->id();

        $token = UserFcmToken::updateOrCreate(
            [
                'device_id' => $data['device_id'] ?? null,
                'user_id' => $userId,
            ],
            [
                'token' => $data['token'],
            ]
        );

        return [
            'status' => true,
            'message' => __('messages.fcm_token_stored_successfully'),
            'data' => $token,
        ];
    }

    public function sendNotificationToGuests($title, $body, $data = [])
    {
        $tokens = UserFcmToken::whereNull('user_id')->pluck('fcm_token')->toArray();

        $results = [];
        foreach ($tokens as $token) {
            $results[] = $this->firebaseService->sendToToken($token, $title, $body, $data);
        }

        return [
            'status' => true,
            'message' => 'Test notifications sent to all guest tokens',
            'count' => count($tokens),
            'details' => $results,
        ];
    }

    public function sendNotificationToUsers($title, $body, $data = [])
    {
        $tokens = UserFcmToken::whereNotNull('user_id')->pluck('fcm_token')->toArray();

        $results = [];
        foreach ($tokens as $token) {
            $results[] = $this->firebaseService->sendToToken($token, $title, $body, $data);
        }

        return [
            'status' => true,
            'message' => 'Test notifications sent to all registered users',
            'count' => count($tokens),
            'details' => $results,
        ];
    }

    public function broadcastNotification($title, $body, $data = [])
    {
        $tokens = UserFcmToken::pluck('fcm_token')->toArray();

        $results = [];
        foreach ($tokens as $token) {
            $results[] = $this->firebaseService->sendToToken($token, $title, $body, $data);
        }

        return [
            'status' => true,
            'message' => 'Broadcast notification sent to all tokens',
            'count' => count($tokens),
            'details' => $results,
        ];
    }

    public function sendToUser($userId, $title, $body, $data = [])
    {
        $tokens = UserFcmToken::where('user_id', $userId)->pluck('fcm_token')->toArray();

        $results = [];
        foreach ($tokens as $token) {
            $results[] = $this->firebaseService->sendToToken($token, $title, $body, $data);
        }

        return [
            'status' => true,
            'message' => 'Notification sent to specific user',
            'count' => count($tokens),
            'details' => $results,
        ];
    }
    public function notifications()
    {
        $notifications = AppNotification::where(function ($query) {
                $query->where('user_id', auth()->id())
                    ->orWhereNull('user_id');
            })
            ->latest()
            ->get();

        if ($notifications->isEmpty()) {
            return [
                'status' => false,
                'message' => __('messages.no_notifications_found'),
            ];
        }

        return [
            'status' => true,
            'message' => __('messages.notifications_fetched_successfully'),
            'data' => NotificationResource::collection($notifications),
        ];
    }

    public function markAsRead($id)
    {
        $notification = AppNotification::where(function ($query) {
                $query->where('user_id', auth()->id())
                    ->orWhereNull('user_id');
            })
            ->find($id);

        if (!$notification) {
            return [
                'status' => false,
                'message' => __('messages.notification_not_found'),
            ];
        }

        $notification->update([
            'is_read' => true,
            'read_at' => now(),
        ]);

        return [
            'status' => true,
            'message' => __('messages.notification_marked_as_read_successfully'),
            'data' => new NotificationResource($notification),
        ];
    }
}