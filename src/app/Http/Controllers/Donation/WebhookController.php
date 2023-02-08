<?php

namespace App\Http\Controllers\Donation;

use App\Http\Controllers\Controller;
use App\Http\Services\DonationService;
use App\Http\Services\RazorpayService;
use Illuminate\Http\Request;

class WebhookController extends Controller
{
    private $donationService;

    public function __construct(DonationService $donationService)
    {
        $this->donationService = $donationService;
    }

    public function webhook(Request $request)
    {
        $data = (new RazorpayService)->verify_webhook($request);
        if($data){
            $this->donationService->verify_webhook($data['order_id'], $data['payment_id']);
        }

        return response()->json([
            'status' => 'success',
        ], 200);

    }
}
