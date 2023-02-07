<?php

namespace App\Http\Controllers\DonationPage;

use App\Http\Controllers\Controller;
use App\Http\Services\DonationPageService;

class DisplayController extends Controller
{
    private $donationPageService;

    public function __construct(DonationPageService $donationPageService)
    {
        $this->donationPageService = $donationPageService;
    }

/**
 * @OA\Get(
 *     path="/api/donation-page/display/{id}",
 *     tags={"Donation Page"},
 *     summary="Display Donation Page",
 *     description="Returns donation Page data",
 * security={
     *           {"bearerAuth": {}}
     *       },
 * @OA\Parameter(
 *          name="id",
 *          description="Donation Page id",
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
    public function display($id)
    {
        $donationPage = $this->donationPageService->getById($this->donationPageService->decryptId($id));

        return response()->json([
            'status' => 'success',
            'data' => $this->donationPageService->getDonationPageResource($donationPage),
        ], 201);

    }
}
