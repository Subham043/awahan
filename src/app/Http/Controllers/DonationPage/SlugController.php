<?php

namespace App\Http\Controllers\DonationPage;

use App\Http\Controllers\Controller;
use App\Http\Services\DonationPageService;

class SlugController extends Controller
{
    private $donationPageService;

    public function __construct(DonationPageService $donationPageService)
    {
        $this->donationPageService = $donationPageService;
    }

/**
 * @OA\Get(
 *     path="/api/donation-page/display/{slug}",
 *     tags={"Donation Page"},
 *     summary="Display Donation Page",
 *     description="Returns donation Page data",
 * @OA\Parameter(
 *          name="slug",
 *          description="Donation Page slug",
 *          required=true,
 *          in="path",
 *          @OA\Schema(
 *              type="string"
 *          )
 *      ),
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
    public function slug($slug)
    {
        $donationPage = $this->donationPageService->getBySlug($slug);

        return response()->json([
            'status' => 'success',
            'data' => $this->donationPageService->getDonationPageResource($donationPage),
        ], 201);

    }
}
