<?php

namespace App\Http\Requests;

use App\Exceptions\CustomJsonException;
use App\Http\Services\AuthService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PasswordPostRequest extends FormRequest
{
    private $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
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
            'old_password' => 'required|string|min:6',
            'password' => ['required',
                'string',
                Password::min(8)
                        ->letters()
                        ->mixedCase()
                        ->numbers()
                        ->symbols()
                        ->uncompromised()
            ],
            'confirm_password' => 'string|min:6|required_with:password|same:password',
        ];
    }

    /**
     * Handle a passed validation attempt.
     *
     * @return void
     */
    protected function passedValidation()
    {
        $request = $this->safe()->only('old_password', 'password');
        if (!Hash::check($request['old_password'], $this->authService->auth_user_details()->getPassword())) {
            throw new CustomJsonException('Oops! Incorrect Old Password', 400);
        }
        $this->replace(['password' => Hash::make($request['password'])]);
    }
}
