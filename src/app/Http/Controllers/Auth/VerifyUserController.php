<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Resources\UserCollection;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Carbon\Carbon;
use App\Http\Services\UserService;
use App\Http\Requests\OtpPostRequest;

class VerifyUserController extends Controller
{
    private $userService;

    public function __construct(UserService $userService)
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
