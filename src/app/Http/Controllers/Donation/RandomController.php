<?php

namespace App\Http\Controllers\Donation;

use App\Http\Controllers\Controller;
use App\Http\Services\DonationService;

class RandomController extends Controller
{
    private $donationService;

    public function __construct(DonationService $donationService)
    {
        $this->donationService = $donationService;
    }

/**
 * @OA\Get(
 *     path="/api/donation/random",
 *     tags={"Donation"},
 *     summary="Display Random Donation",
 *     description="Returns donation data",
 *     @OA\Response(
 *          response=200,
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
    public function random()
    {
        $donation = $this->donationService->random();

        return response()->json([
            'status' => 'success',
            'data' => $this->donationService->getDonationCollection($donation),
        ], 200);

    }
}
