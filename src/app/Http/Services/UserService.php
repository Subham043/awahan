<?php

namespace App\Http\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UserCollection;
use App\Exceptions\UserAccessException;
use App\Http\Requests\RegisterPostRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;

class UserService
{
    private $userModel;

    public function __construct(User $userModel)
    {
        $this->userModel = $userModel;
    }

    public function all()
    {
        return $this->userModel->all();
    }

    public function getById(Int $id): User
    {
        return $this->userModel->findOrFail($id);
    }

    public function getByEmail(String $email): User
    {
        return $this->userModel->where('email', $email)->firstOrFail();
    }

    public function geUserResource(User $user): UserCollection
    {
        return UserCollection::make($user);
    }

    public function create(RegisterPostRequest $user) : User
    {
        return $this->userModel->create([
            'first_name' => $user['first_name'],
            'last_name' => $user['last_name'],
            'email' => $user['email'],
            'phone' => $user['phone'],
            'password' => Hash::make($user['password']),
            'otp' => rand(1000,9999),
        ]);
    }

    public function hasAccess(User $user): void
    {
        if($user->status==2 || $user->status==0){
            throw new UserAccessException($user);
        }
    }

    public function decryptId(String $id): Int
    {
        return Crypt::decryptString($id);
    }

}
