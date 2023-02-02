<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminLoginPostRequest extends LoginPostRequest
{
    protected function passedValidation()
    {
        $request = $this->safe()->only('email', 'password');
        $request['userType'] = 1;
        $this->replace($request);
    }
}
