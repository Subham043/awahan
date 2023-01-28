<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Services\UserService;

class LogoutController extends Controller
{

    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    
    public function logout()
    {
        $this->userService->logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ], 200);
    }
}
