<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Services\Interfaces\UserInterface;

class LogoutController extends Controller
{

    private $userService;

    public function __construct(UserInterface $userService)
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
