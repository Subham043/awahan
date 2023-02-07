<?php

namespace App\Http\Requests;

use App\Http\Services\DecryptService;
use Stevebauman\Purify\Facades\Purify;
use App\Http\Services\UserService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ResetPasswordPostRequest extends FormRequest
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'otp' => 'required|string|max:4',
            'confirm_password' => 'string|min:6|required_with:password|same:password',
            'password' => ['required',
                'string',
                Password::min(8)
                        ->letters()
                        ->mixedCase()
                        ->numbers()
                        ->symbols()
                        ->uncompromised()
            ],
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $user_id = $this->route('user_id');
            $request = $this->safe()->only('otp', 'password');
            $user = $this->userService->getById((new DecryptService)->decryptId($user_id));
            if($request['otp']!=$user->otp){
                $validator->errors()->add('otp', 'Oops! You have entered wrong otp!');
            }
        });
    }

    /**
     * Handle a passed validation attempt.
     *
     * @return void
     */
    protected function passedValidation()
    {
        $request = $this->safe()->only('otp', 'password');
        $request['password'] = Hash::make($this->password);
        $request['otp'] = rand(1000,9999);
        $this->replace(Purify::clean($request));
    }
}
