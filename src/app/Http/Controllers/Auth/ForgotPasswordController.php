<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Jobs\SendForgotPasswordEmailJob;
use App\Http\Services\Interfaces\UserInterface;
use App\Http\Requests\ForgotPasswordPostRequest;

class ForgotPasswordController extends Controller
{
    private $userService;

    public function __construct(UserInterface $userService)
    {
        $this->userService = $userService;
    }

    public function forgot_password(ForgotPasswordPostRequest $request){

        $user = $this->userService->forgot_password($request->email);

        //dispatch(new SendForgotPasswordEmailJob($user));

        return response()->json([
            'status' => 'success',
            'message' => 'Password reset link has been shared with your email address.',
            'user' => $this->userService->geUserResource($user),
        ], 200);
    }
}
