<?php

namespace App\Http\Requests;

use App\Http\Services\AuthService;
use App\Http\Services\DecryptService;
use Illuminate\Foundation\Http\FormRequest;
use Stevebauman\Purify\Facades\Purify;

class OtpPostRequest extends FormRequest
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
            'otp' => 'required|string|max:4'
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    // public function withValidator($validator)
    // {
    //     $validator->after(function ($validator) {
    //         $validator->errors()->add('otp', $this->otp);
    //         // $user_id = $this->route('user_id');
    //         // $request = $this->safe()->only('otp');
    //         // $user = $this->authService->getById(
    //         //     (new DecryptService)->decryptId($user_id)
    //         // );
    //         // if($request['otp']!=$user->otp){
    //         //     $validator->errors()->add('otp', 'Oops! You have entered wrong otp!');
    //         // }
    //     });
    // }

    /**
     * Handle a passed validation attempt.
     *
     * @return void
     */
    protected function passedValidation()
    {
        $request = $this->safe()->only('otp');
        $user_id = $this->route('user_id');
        // $request = $this->safe()->only('otp');
        $user = $this->authService->getById(
            (new DecryptService)->decryptId($user_id)
        );
        if($request['otp']!=$user->otp){
            $this->errors()->add('otp', 'Oops! You have entered wrong otp!');
        }
        $this->replace(Purify::clean($request));
    }
}
