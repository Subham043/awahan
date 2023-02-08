<?php

namespace App\Http\Controllers\Donation;

use App\Http\Controllers\Controller;
use App\Http\Services\DonationService;
use App\Http\Services\DecryptService;

class DisplayController extends Controller
{
    private $donationService;

    public function __construct(DonationService $donationService)
    {
        $this->donationService = $donationService;
    }

/**
 * @OA\Get(
 *     path="/api/donation/display/{id}",
 *     tags={"Donation"},
 *     summary="Display Donation",
 *     description="Returns donation data",
 * security={
     *           {"bearerAuth": {}}
     *       },
 * @OA\Parameter(
 *          name="id",
 *          description="Donation id",
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
        $donation = $this->donationService->getById((new DecryptService)->decryptId($id));

        return response()->json([
            'status' => 'success',
            'data' => $this->donationService->getDonationResource($donation),
        ], 201);

    }
}
