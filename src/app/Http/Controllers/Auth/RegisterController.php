<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Jobs\SendVerificationEmailJob;
use App\Http\Services\Interfaces\UserInterface;
use App\Http\Requests\RegisterPostRequest;

class RegisterController extends Controller
{
    private $userService;

    public function __construct(UserInterface $userService)
    {
        $this->userService = $userService;
    }

    public function register(RegisterPostRequest $request){

        $this->userService->create($request->validated());

        $user = $this->userService->getByEmail($request->email);
        //dispatch(new SendVerificationEmailJob($user));

        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully',
            'user' => $this->userService->geUserResource($user),
        ], 201);
    }
}
