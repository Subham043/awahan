<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Services\Interfaces\UserInterface;
use App\Http\Requests\OtpPostRequest;

class VerifyUserController extends Controller
{
    private $userService;

    public function __construct(UserInterface $userService)
    {
        $this->userService = $userService;
    }

    public function verify_user(OtpPostRequest $request, $user_id){
        $user = $this->userService->getById($this->userService->decryptId($user_id));

        if($request->otp!=$user->otp){
            return response()->json([
                'status' => 'error',
                'message' => 'Oops! You have entered wrong otp',
            ], 400);
        }

        $user = $this->userService->verify_user($user->id);

        $token = Auth::login($user);

        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully',
            'user' => $this->userService->geUserResource($user),
            'access_token' => $token,
        ], 201);
    }
}
