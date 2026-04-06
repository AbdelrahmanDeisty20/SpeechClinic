<?php
namespace App\Services;

use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;
use App\Models\Otp;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Str;

class ForgetPasswordService
{
    use ApiResponse;

    public function forgetPassword(array $data)
    {
        $user = User::where('email', $data['email'])->first();
        if ($user) {
            $code = random_int(100000, 999999);
            $codeHash = Hash::make((string) $code);
            $expiresAt = now()->addMinutes(10);
            Mail::to($user->email)->locale(app()->getLocale())->queue(new OtpMail($user->full_name, (string) $code, 'reset_password'));
            $otp = Otp::create([
                'phone' => $user->phone,
                'email' => $user->email,
                'otp' => $codeHash,
                'expires_at' => $expiresAt,
                'type' => 'reset_password',
                'user_id' => $user->id,
            ]);
        }
        return [
            'status' => true,
            'message' => __('messages.forget_password_otp_sent_successfully'),
            'data' => []
        ];
    }

    public function verifyOtp(array $data)
    {
        $otp = Otp::where('email', $data['email'])
            ->where('type', 'reset_password')
            ->where('expires_at', '>', now())
            ->where('verified_at', null)
            ->latest()
            ->first();

        if ($otp && Hash::check($data['otp'], $otp->otp)) {
            $otp->update([
                'verified_at' => now(),
                'reset_token' => Str::random(60),
            ]);
            return [
                'status' => true,
                'message' => __('messages.forget_password_otp_verified_successfully'),
                'data' => [
                    'reset_token' => $otp->reset_token,
                ]
            ];
        }
        return [
            'status' => false,
            'message' => __('messages.otp_verification_failed'),
            'data' => []
        ];
    }

    public function resetPassword(array $data)
    {
        $otp = Otp::where('email', $data['email'])
            ->where('reset_token', $data['token'])
            ->where('type', 'reset_password')
            ->where('expires_at', '>', now())
            ->where('verified_at', '!=', null)
            ->latest()
            ->first();

        if ($otp) {
            $user = User::where('email', $data['email'])->first();
            if ($user) {
                $user->update([
                    'password' => $data['password'],
                ]);
                return [
                    'status' => true,
                    'message' => __('messages.password_reset_successfully'),
                    'data' => []
                ];
            }
        }
        return [
            'status' => false,
            'message' => __('messages.token_invalid'),
            'data' => []
        ];
    }

    public function resendOtpForgetPassword(array $data)
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
                'type' => 'reset_password',
                'user_id' => $user->id,
            ]);
        }
        return [
            'status' => true,
            'message' => __('messages.resend_forget_password_otp_sent_successfully'),
            'data' => []
        ];
    }
}