<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\storeTokenRequest;
use App\Services\API\NotificationService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    use ApiResponse;

    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function sendToken(storeTokenRequest $request)
    {
        $result = $this->notificationService->sendToken($request->all());

        if (!$result['status']) {
            return $this->error($result['message'], 400);
        }

        return $this->success([], $result['message']);
    }

    public function notifications()
    {
        $result = $this->notificationService->notifications();

        if (!$result['status']) {
            return $this->error($result['message'], 400);
        }

        return $this->success($result['data'], $result['message']);
    }

    public function markAsRead($id)
    {
        $result = $this->notificationService->markAsRead($id);

        if (!$result['status']) {
            return $this->error($result['message'], 400);
        }

        return $this->success($result['data'], $result['message']);
    }
    public function sendNotificationToGuests(Request $request)
    {
        $result = $this->notificationService->sendNotificationToGuests($request->title, $request->body, $request->data);

        if (!$result['status']) {
            return $this->error($result['message'], 400);
        }

        return $this->success($result['data'], $result['message']);
    }
}
