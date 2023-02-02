<?php

namespace App\Http\Requests;

use App\Exceptions\CustomJsonException;
use App\Http\Services\UserService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

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
            'password' => 'required|string|min:6',
        ];
    }

    /**
     * Handle a passed validation attempt.
     *
     * @return void
     */
    protected function passedValidation()
    {
        $user_id = $this->route('user_id');
        $request = $this->safe()->only('otp', 'password');
        $user = $this->userService->getById($this->userService->decryptId($user_id));
        if($request['otp']!=$user->otp){
            throw new CustomJsonException('Oops! You have entered wrong otp', 400);
        }
        $request['password'] = Hash::make($this->password);
        $request['otp'] = rand(1000,9999);
        $this->replace($request);
    }
}
