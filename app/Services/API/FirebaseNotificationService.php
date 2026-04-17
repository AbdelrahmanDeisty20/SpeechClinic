<?php

namespace App\Services;

use Google\Auth\Credentials\ServiceAccountCredentials;
use Illuminate\Support\Facades\Http;

class FirebaseNotificationService
{
    private function accessToken()
    {
        $credentials = new ServiceAccountCredentials(
            ['https://www.googleapis.com/auth/firebase.messaging'],
            json_decode(
                file_get_contents(base_path(env('FIREBASE_CREDENTIALS_NOTIFICATION'))),
                true
            )
        );

        $credentials->fetchAuthToken();
        return $credentials->getLastReceivedToken()['access_token'];
    }

    public function sendToToken(string $token, string $title, string $body, array $data = [])
    {
        $payload = [
            'message' => [
                'token' => $token,
                'notification' => [
                    'title' => $title,
                    'body' => $body,
                ]
            ]
        ];

        if (!empty($data)) {
            // FCM v1 requires data values to be strings
            $payload['message']['data'] = array_map('strval', $data);
        }

        return Http::withToken($this->accessToken())
            ->post(
                'https://fcm.googleapis.com/v1/projects/' . env('FIREBASE_PROJECT_ID') . '/messages:send',
                $payload
            )
            ->json();
    }
}
