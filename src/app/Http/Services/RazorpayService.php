<?php

namespace App\Http\Services;

use App\Exceptions\CustomJsonException;
use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;

class RazorpayService
{

    public function generate_order_id(String $receipt, Int $amount): String
    {
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
        $orderData = [
            'receipt'         => $receipt,
            'amount'          => $amount*100, // 39900 rupees in paise
            'currency'        => 'INR',
            'partial_payment' => false,
        ];

        $razorpayOrder = $api->order->create($orderData);
        $razorpayOrderId = $razorpayOrder['id'];
        return $razorpayOrderId;
    }

    public function verify_signature(String $razorpay_order_id, String $razorpay_payment_id, String $razorpay_signature): bool{
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
        try
        {
            $attributes = array(
                'razorpay_order_id' => $razorpay_order_id,
                'razorpay_payment_id' => $razorpay_payment_id,
                'razorpay_signature' => $razorpay_signature,
                'status' => 1,
            );

            $api->utility->verifyPaymentSignature($attributes);
            return true;
        }
        catch(SignatureVerificationError $e)
        {
            //$error = 'Razorpay Error : ' . $e->getMessage();
            // throw new CustomJsonException('Donation verification failed', 400);
            return false;
        }
    }

}
