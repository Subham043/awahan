<?php

namespace App\Http\Services\Interfaces;

interface UserInterface
{
    public function all();
    public function login($credentials);
    public function getById($id);
    public function getByEmail($email);
    public function geUserResource($user);
    public function create($user);
    public function hasAccess($user);
    public function forgot_password($email);
    public function logout();
    public function auth_user_details();
    public function auth_refresh();
    public function decryptId($id);
    public function send_otp($id);
    public function verify_user($id);
    public function profile_update($request);
}