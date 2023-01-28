<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Services\UserService;

class RefreshController extends Controller
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    
    public function refresh()
    {
        return response()->json([
            'status' => 'success',
            'user' => $this->userService->geUserResource($this->userService->auth_user_details()),
            'refresh_token' => $this->userService->auth_refresh(),
        ], 201);
    }
}
