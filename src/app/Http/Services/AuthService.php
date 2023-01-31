<?php

namespace App\Http\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LoginPostRequest;
use App\Http\Requests\ProfilePostRequest;
use Carbon\Carbon;

class AuthService extends UserService
{
    public function __construct(User $userModel)
    {
       parent::__construct($userModel);
    }

    public function logout(): void
    {
        Auth::logout();
    }

    public function login(LoginPostRequest $request)
    {
        $credentials = $request->safe()->only('email', 'password');
        return $this->attempt_login($credentials);

    }

    public function admin_login(LoginPostRequest $request)
    {
        $credentials = $request->safe()->only('email', 'password');
        $credentials['userType'] = 1;
        return $this->attempt_login($credentials);

    }

    public function attempt_login(array $credentials){
        return Auth::attempt($credentials);
    }

    public function getOtp(): Int
    {
        return rand(1000,9999);
    }

    public function forgot_password(String $email): User
    {
        $user = $this->getByEmail($email);
        $this->hasAccess($user);
        $user->otp = $this->getOtp();
        $user->save();
        return $user;
    }


    public function auth_user_details(): User
    {
        return Auth::user();
    }

    public function auth_refresh(): String
    {
        return Auth::refresh();
    }

    public function send_otp(String $id): User
    {
        $decryptedId = $this->decryptId($id);
        $user = $this->getById($decryptedId);
        $user->otp = $this->getOtp();
        $user->save();

        return $user;
    }

    public function verify_user(String $id): User
    {
        $user = $this->getById($id);
        $user->otp = $this->getOtp();
        $user->status = 1;
        $user->email_verified_at = Carbon::now()->toDateTimeString();
        $user->save();
        return $user;
    }

    public function profile_update(ProfilePostRequest $request)
    {
        $user = $this->getById($this->auth_user_details()->id);
        $user->update([
            ...$request->validated()
        ]);
        return $user;
    }
}
