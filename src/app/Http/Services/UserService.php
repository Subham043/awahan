<?php

namespace App\Http\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UserCollection;
use App\Exceptions\UserAccessException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Carbon\Carbon;

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

    public function login($credentials)
    {
        $token= Auth::attempt($credentials);
        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid Credentials',
            ], 401);
        }
        $this->hasAccess($this->auth_user_details());
        return [
            'token' => $token,
            'user' => $this->getById($this->auth_user_details()->id),
        ];
    }
    
    public function getById($id)
    {
        return $this->userModel->findOrFail($id);
    }

    public function getByEmail($email)
    {
        return $this->userModel->where('email', $email)->firstOrFail();
    }

    public function geUserResource($user)
    {
        return UserCollection::make($user);
    }

    public function create($user)
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

    public function hasAccess($user)
    {
        if($user->status==2 || $user->status==0){
            throw new UserAccessException($user);
        }
    }

    public function forgot_password($email)
    {
        $user = $this->getByEmail($email);
        $this->hasAccess($user);
        $user->otp = rand(1000,9999);
        $user->save();
        return $user;
    }

    public function logout()
    {
        Auth::logout();
    }

    public function auth_user_details(){
        return Auth::user();
    }
    
    public function auth_refresh(){
        return Auth::refresh();
    }

    public function decryptId($id){
        return Crypt::decryptString($id);
    }

    public function send_otp($id){
        $decryptedId = $this->decryptId($id);
        $user = $this->getById($decryptedId);
        $user->otp = rand(1000,9999);
        $user->save();

        return $user;
    }

    public function verify_user($id){
        $user = $this->getById($id);
        $user->otp = rand(1000,9999);
        $user->status = 1;
        $user->email_verified_at = Carbon::now()->toDateTimeString();
        $user->save();
        return $user;
    }

    public function profile_update($request){
        $user = $this->getById($this->auth_user_details()->id);

        $user->first_name = $request['first_name'];
        $user->last_name = $request['last_name'];
        $user->phone = $request['phone'];
        $user->email = $request['email'];
        $user->save();
        return $user;
    }
}