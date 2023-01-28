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
use App\Jobs\SendOtpEmailJob;
use App\Http\Services\UserService;

class ResendOTPController extends Controller
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function send_otp($user_id){

        $user = $this->userService->send_otp($user_id);

        //dispatch(new SendOtpEmailJob($user));

        return response()->json([
            'status' => 'success',
            'message' => 'Otp sent successfully',
        ], 201);
    }
}
