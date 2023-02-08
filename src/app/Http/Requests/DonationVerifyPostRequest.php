<?php

namespace App\Http\Requests;

use App\Enums\PaymentStatusEnum;
use App\Http\Services\RazorpayService;
use Illuminate\Foundation\Http\FormRequest;
use Stevebauman\Purify\Facades\Purify;
use Uuid;

class DonationVerifyPostRequest extends FormRequest
{
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
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $request = $this->safe()->only('razorpay_order_id', 'razorpay_payment_id', 'razorpay_signature');
            $is_verified = (new RazorpayService)->verify_signature($request['razorpay_order_id'], $request['razorpay_payment_id'], $request['razorpay_signature']);
            if(!$is_verified){
                $validator->errors()->add('razorpay_signature', 'verification failed!');
            }
        });
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'razorpay_order_id' => 'required|string|exists:donation,order_id',
            'razorpay_payment_id' => 'required|string',
            'razorpay_signature' => 'required|string',
        ];
    }

    /**
     * Handle a passed validation attempt.
     *
     * @return void
     */
    protected function passedValidation()
    {
        $request = $this->safe()->only('razorpay_order_id', 'razorpay_payment_id');
        $data = [];
        $data['order_id'] = $request['razorpay_order_id'];
        $data['payment_id'] = $request['razorpay_payment_id'];
        $data['status'] = PaymentStatusEnum::COMPLETED->label();
        $this->replace(Purify::clean($data));
    }
}
