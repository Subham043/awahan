<?php

namespace App\Http\Controllers\Donation;

use App\Http\Controllers\Controller;
use App\Http\Requests\DonationVerifyPostRequest;
use App\Http\Services\DonationService;

class VerifyController extends Controller
{
    private $donationService;

    public function __construct(DonationService $donationService)
    {
        $this->donationService = $donationService;
    }

/**
 * @OA\Post(
 *     path="/api/donation/verify",
 *     tags={"Donation"},
 *     summary="Verify Donation",
 *     description="Returns created donation data",
 *     @OA\RequestBody(
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 type="object",
 *
 *                 @OA\Property(
 *                     property="razorpay_order_id",
 *                     description="Razorpay Order Id",
 *                     example="xxxxxx",
 *                     type="string"
 *                 ),
 *                  @OA\Property(
 *                     property="razorpay_payment_id",
 *                     description="Razorpay Payment Id",
 *                     example="xxxxxxxx",
 *                     type="string"
 *                 ),
 *                  @OA\Property(
 *                     property="razorpay_signature",
 *                     description="Razorpay Signature",
 *                     example="xxxxxxx",
 *                     type="string"
 *                 ),
 *             )
 *          )
 *     ),
 *     @OA\Response(
 *          response=201,
 *          description="Successful operation",
 *          @OA\MediaType(
*              mediaType="application/json",
*           ),
*       ),
*      @OA\Response(
*          response=400,
*          description="Bad Request"
*      ),
*      @OA\Response(
*          response=401,
*          description="Unauthenticated",
*      ),
*      @OA\Response(
*          response=403,
*          description="Forbidden"
*      ),
*      @OA\Response(
*          response=422,
*          description="Unprocessable Content"
*      )
* )
*/
    public function verify(DonationVerifyPostRequest $request)
    {
        $donation = $this->donationService->verify($request);

        return response()->json([
            'status' => 'success',
            'data' => $this->donationService->getDonationResource($donation),
        ], 201);

    }
}
