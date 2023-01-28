<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Services\UserService;
use App\Http\Requests\PasswordPostRequest;

class PasswordUpdateController extends Controller
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function password_update(PasswordPostRequest $request)
    {
        $user = $this->userService->getById($this->userService->auth_user_details()->id);
        $this->userService->hasAccess($user);
        
        if (!Hash::check($request->old_password, $user->getPassword())) {
            return response()->json([
                'status' => 'error',
                'message' => 'Oops! Incorrect Password.',
            ], 400);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json([
            'status' => 'success',
            'user' => $this->userService->geUserResource($user),
        ], 200);
    }
}
