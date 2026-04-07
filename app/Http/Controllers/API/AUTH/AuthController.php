<?php

namespace App\Http\Controllers\API\AUTH;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\AUTH\FirebaseGoogleLoginRequest;
use App\Http\Requests\API\AUTH\LoginRequest;
use App\Http\Requests\API\AUTH\RefreshTokenRequest;
use App\Http\Requests\API\AUTH\RegisterRequest;
use App\Http\Requests\API\AUTH\ResendOtpRegisterRequest;
use App\Http\Requests\API\AUTH\UpdateProfileRequest;
use App\Http\Requests\API\AUTH\VerifyOtpRequest;
use App\Services\AuthService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    use ApiResponse;
    protected $authService;
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(RegisterRequest $request)
    {
      $result = $this->authService->register($request->validated());
      if(!$result['status']){
        return $this->error($result['message'],400);
      }
      return $this->success($result['data'], $result['message'],200);
    }

    public function verifyOtp(VerifyOtpRequest $request)
    {
      $result = $this->authService->verifyOtp($request->validated());
      if(!$result['status']){
        return $this->error($result['message'],400);
      }
      return $this->success($result['data'], $result['message'],200);
    }

    public function login(LoginRequest $request)
    {
      $result = $this->authService->login($request->validated());
      if(!$result['status']){
        return $this->error($result['message'],400);
      }
      return $this->success($result['data'], $result['message'],200);
    }
    public function resendOtpRegister(ResendOtpRegisterRequest $request)
    {
      $result = $this->authService->resendOtp($request->validated());
      if(!$result['status']){
        return $this->error($result['message'],400);
      }
      return $this->success([], $result['message'],200);
    }

    public function showProfile()
    {
      $result = $this->authService->showProfile();
      if(!$result['status']){
        return $this->error($result['message'],400);
      }
      return $this->success($result['data'], $result['message'],200);
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
      $result = $this->authService->updateProfile($request->validated());
      if(!$result['status']){
        return $this->error($result['message'],400);
      }
      return $this->success($result['data'], $result['message'],200);
    }

    public function logout()
    {
      $result = $this->authService->logout();
      if(!$result['status']){
        return $this->error($result['message'],400);
      }
      return $this->success($result['data'], $result['message'],200);
    }

    public function refreshToken(RefreshTokenRequest $request)
    {
      $result = $this->authService->refreshToken($request->validated());
      if(!$result['status']){
        return $this->error($result['message'],400);
      }
      return $this->success($result['data'], $result['message'],200);
    }

    public function firebaseGoogleLogin(FirebaseGoogleLoginRequest $request)
    {
      $result = $this->authService->firebaseGoogleLogin($request->validated());
      if(!$result['status']){
        return $this->error($result['message'], 400, $result['data']);
      }
      return $this->success($result['data'], $result['message'], 200);
    }
}
