<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Resources\UserCollection;
use App\Http\Services\UserService;

class ProfileController extends Controller
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function profile()
    {
        return response()->json([
            'status' => 'success',
            'user' => $this->userService->geUserResource($this->userService->auth_user_details()),
        ], 200);
    }
}
