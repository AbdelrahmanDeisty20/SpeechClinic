<?php

namespace App\Http\Controllers\API\AUTH;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\AUTH\FORGETPASSWORD\ForgetPasswordRequest;
use App\Http\Requests\API\AUTH\FORGETPASSWORD\ResendOtpRegisterRequest;
use App\Http\Requests\API\AUTH\FORGETPASSWORD\ResetPasswordRequest;
use App\Http\Requests\API\AUTH\FORGETPASSWORD\VerifyOtpRequest;
use App\Services\ForgetPasswordService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class ForgetPasswordController extends Controller
{
    use ApiResponse;
    protected $forgetPasswordService;
    public function __construct(ForgetPasswordService $forgetPasswordService)
    {
        $this->forgetPasswordService = $forgetPasswordService;
    }

    public function forgetPassword(ForgetPasswordRequest $request)
    {
        $result = $this->forgetPasswordService->forgetPassword($request->validated());
        if(!$result['status']){
            return $this->error($result['message'],400);
        }
        return $this->success([], $result['message'],200);
    }

    public function verifyOtp(VerifyOtpRequest $request)
    {
        $result = $this->forgetPasswordService->verifyOtp($request->validated());
        if(!$result['status']){
            return $this->error($result['message'],400);
        }
        return $this->success($result['data'], $result['message'],200);
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $result = $this->forgetPasswordService->resetPassword($request->validated());
        if(!$result['status']){
            return $this->error($result['message'],400);
        }
        return $this->success([], $result['message'],200);
    }

    public function resendOtpForgetPassword(ResendOtpRegisterRequest $request)
    {
        $result = $this->forgetPasswordService->resendOtpForgetPassword($request->validated());
        if(!$result['status']){
            return $this->error($result['message'],400);
        }
        return $this->success([], $result['message'],200);
    }
}
