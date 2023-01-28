<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Services\Interfaces\UserInterface;
use App\Http\Requests\ProfilePostRequest;

class ProfileUpdateController extends Controller
{
    private $userService;

    public function __construct(UserInterface $userService)
    {
        $this->userService = $userService;
    }

    public function profile_update(ProfilePostRequest $request)
    {
        $user = $this->userService->getById($this->userService->auth_user_details()->id);
        $this->userService->hasAccess($user);

        $user = $this->userService->profile_update($request->validated());

        return response()->json([
            'status' => 'success',
            'user' => $this->userService->geUserResource($user),
        ], 200);
    }
}
