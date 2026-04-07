<?php

namespace App\Services;

use App\Http\Resources\API\UserResource;
use App\Mail\OtpMail;
use App\Models\Otp;
use App\Models\RefreshToken;
use App\Models\User;
use App\Traits\ApiResponse;
use Hash;
use Mail;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Str;

class AuthService
{
    use ApiResponse;

    public function register(array $data)
    {
        $user = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'phone' => $data['phone'],
            'email' => $data['email'],
            'password' => $data['password'],
        ]);
        if ($user) {
            $code = random_int(100000, 999999);
            $codeHash = Hash::make((string) $code);
            $expiresAt = now()->addMinutes(10);
            Mail::to($user->email)->queue(new OtpMail($user->full_name, (string) $code, 'register'));
            $otp = Otp::create([
                'phone' => $user->phone,
                'email' => $user->email,
                'otp' => $codeHash,
                'expires_at' => $expiresAt,
                'type' => 'register',
                'user_id' => $user->id,
            ]);
        }
        return [
            'status' => true,
            'message' => __('messages.user_registered_successfully'),
            'data' => new UserResource($user)
        ];
    }

    public function verifyOtp(array $data)
    {
        $otp = Otp::where('email', $data['email'])
            ->where('verified_at', null)
            ->where('expires_at', '>', now())
            ->latest()
            ->first();

        if ($otp && Hash::check($data['otp'], $otp->otp)) {
            $otp->update([
                'verified_at' => now(),
            ]);
            $otp->user->update([
                'is_active' => true,
                'email_verified_at' => now(),
            ]);
            return [
                'status' => true,
                'message' => __('messages.otp_verified_successfully'),
                'data' => new UserResource($otp->user)
            ];
        }
        return [
            'status' => false,
            'message' => __('messages.otp_verification_failed'),
            'data' => []
        ];
    }

    public function login(array $data)
    {
        $user = User::where('email', $data['email'])->first();
        if (!$user->email_verified_at) {
            return [
                'status' => false,
                'message' => __('messages.user_not_active'),
                'data' => []
            ];
        }
        if ($user) {
            if (Hash::check($data['password'], $user->password)) {
                $token = $user->createToken('auth_token')->plainTextToken;
                $refreshToken = Str::random(64);
                RefreshToken::create([
                    'user_id' => $user->id,
                    'expires_at' => now()->addDays(30),
                    'token' => Hash('sha256', $refreshToken),
                ]);
                return [
                    'status' => true,
                    'message' => __('messages.user_logged_in_successfully'),
                    'data' => [
                        'user' => new UserResource($user),
                        'token' => $token,
                        'refresh_token' => $refreshToken,
                    ]
                ];
            }
        }
        return [
            'status' => false,
            'message' => __('messages.user_login_failed'),
            'data' => []
        ];
    }

    public function resendOtp(array $data)
    {
        $user = User::where('email', $data['email'])->first();
        if ($user) {
            $code = random_int(100000, 999999);
            $codeHash = Hash::make((string) $code);
            $expiresAt = now()->addMinutes(10);
            Mail::to($user->email)->locale(app()->getLocale())->queue(new OtpMail($user->full_name, (string) $code, 'register'));
            $otp = Otp::create([
                'phone' => $user->phone,
                'email' => $user->email,
                'otp' => $codeHash,
                'expires_at' => $expiresAt,
                'type' => 'register',
                'user_id' => $user->id,
            ]);
        }
        return [
            'status' => true,
            'message' => __('messages.register_otp_sent_successfully'),
            'data' => []
        ];
    }

    public function showProfile() {
        $user = auth()->user();
        return [
            'status' => true,
            'message' => __('messages.user_profile_fetched_successfully'),
            'data' => new UserResource($user)
        ];
    }

    public function updateProfile(array $data)
    {
        $user = auth()->user();
        $user->update($data);
        return [
            'status' => true,
            'message' => __('messages.user_profile_updated_successfully'),
            'data' => new UserResource($user)
        ];
    }

    public function logout()
    {
        $user = auth()->user();
        $user->currentAccessToken()->delete();
        return [
            'status' => true,
            'message' => __('messages.user_logged_out_successfully'),
            'data' => []
        ];
    }

    public function refreshToken(array $data)
    {
        $refreshToken = RefreshToken::where('token', Hash('sha256', $data['refresh_token']))->first();
        if ($refreshToken) {
            $refreshToken->update([
                'expires_at' => now()->addDays(30),
            ]);
            $token = $refreshToken->user->createToken('auth_token')->plainTextToken;
            return [
                'status' => true,
                'message' => __('messages.token_refreshed_successfully'),
                'data' => [
                    'user' => new UserResource($refreshToken->user),
                    'token' => $token,
                    'refresh_token' => $refreshToken->token,
                ]
            ];
        }
        return [
            'status' => false,
            'message' => __('messages.token_refresh_failed'),
            'data' => []
        ];
    }

    public function firebaseGoogleLogin(array $data)
    {
        try {
            $auth = Firebase::auth();
            $verifiedIdToken = $auth->verifyIdToken($data['idToken']);
            $claims = $verifiedIdToken->claims();
            $email = $claims->get('email');
            $name = $claims->get('name');
            $avatar = $claims->get('picture');
            $firebaseId = $claims->get('sub');

            $user = User::where('email', $email)->first();

            if (!$user) {
                // Split name into first and last name if possible
                $nameParts = explode(' ', $name, 2);
                $firstName = $nameParts[0];
                $lastName = $nameParts[1] ?? '';

                $user = User::create([
                    'first_name'        => $firstName,
                    'last_name'         => $lastName,
                    'email'             => $email,
                    'password'          => \Hash::make($firebaseId), // Random password
                    'image'            => $avatar,
                    'is_active'         => true,
                    'email_verified_at' => now(),
                ]);
            }

            $token = $user->createToken('auth_token')->plainTextToken;
            $refreshToken = Str::random(64);
            RefreshToken::create([
                'user_id' => $user->id,
                'expires_at' => now()->addDays(30),
                'token' => Hash('sha256', $refreshToken),
            ]);

            return [
                'status' => true,
                'message' => __('messages.user_logged_in_successfully'),
                'data' => [
                    'user' => new UserResource($user),
                    'token' => $token,
                    'refresh_token' => $refreshToken,
                ]
            ];
        } catch (\Exception $e) {
            return [
                'status' => false,
                'message' => __('messages.social_login_failed'),
                'data' => [
                    'error' => $e->getMessage()
                ]
            ];
        }
    }
}
