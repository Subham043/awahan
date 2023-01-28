<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Resources\UserCollection;
use App\Exceptions\UserAccessException;

use App\Http\Services\UserService;
use App\Http\Requests\LoginPostRequest;

class LoginController extends Controller
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function login(LoginPostRequest $request)
    {

        $credentials = $request->safe()->only('email', 'password');

        $data = $this->userService->login($credentials);

        return response()->json([
            'status' => 'success',
            'user' => $this->userService->geUserResource($data['user']),
            'access_token' => $data['token'],
        ], 200);

    }
}
