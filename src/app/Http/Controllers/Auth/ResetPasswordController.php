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
use App\Exceptions\UserAccessException;
use App\Http\Services\UserService;
use App\Http\Requests\ResetPasswordPostRequest;

class ResetPasswordController extends Controller
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function reset_password(ResetPasswordPostRequest $request, $user_id){
        $user = $this->userService->getById($this->userService->decryptId($user_id));
        
        $this->userService->hasAccess($user);

        if($request->otp!=$user->otp){
            return response()->json([
                'status' => 'error',
                'message' => 'Oops! You have entered wrong otp',
            ], 400);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Password reset successful',
        ], 201);
    }
}
