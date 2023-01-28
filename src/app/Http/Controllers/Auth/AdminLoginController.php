<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Services\Interfaces\UserInterface;
use App\Http\Requests\LoginPostRequest;

class AdminLoginController extends Controller
{
    private $userService;

    public function __construct(UserInterface $userService)
    {
        $this->userService = $userService;
    }

    public function login(LoginPostRequest $request)
    {
        $credentials = $request->safe()->only('email', 'password');
        $credentials['userType'] = 1;

        $data = $this->userService->login($credentials);

        return response()->json([
            'status' => 'success',
            'user' => $this->userService->geUserResource($data['user']),
            'access_token' => $data['token'],
        ], 200);

    }
}
