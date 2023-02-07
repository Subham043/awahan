<?php

namespace App\Http\Controllers\DonationPage;

use App\Http\Controllers\Controller;
use App\Http\Services\DonationPageService;

class RandomController extends Controller
{
    private $donationPageService;

    public function __construct(DonationPageService $donationPageService)
    {
        $this->donationPageService = $donationPageService;
    }

/**
 * @OA\Get(
 *     path="/api/donation-page/random",
 *     tags={"Donation Page"},
 *     summary="Display Random Donation Page",
 *     description="Returns donation page data",
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
        $donationPage = $this->donationPageService->random();

        return response()->json([
            'status' => 'success',
            'data' => $this->donationPageService->getDonationPageCollection($donationPage),
        ], 200);

    }
}
