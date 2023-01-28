<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Resources\UserCollection;
use App\Jobs\SendForgotPasswordEmailJob;
use App\Exceptions\UserAccessException;
use App\Http\Services\UserService;
use App\Http\Requests\ForgotPasswordPostRequest;

class ForgotPasswordController extends Controller
{
    private $userService;

    public function __construct(UserService $userService)
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
