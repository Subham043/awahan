<?php

namespace App\Http\Controllers\Donation;

use App\Http\Controllers\Controller;
use App\Http\Services\DonationService;
use Illuminate\Http\Request;

class PaginateController extends Controller
{
    private $donationService;

    public function __construct(DonationService $donationService)
    {
        $this->donationService = $donationService;
    }

/**
 * @OA\Get(
 *     path="/api/donation/paginate",
 *     tags={"Donation"},
 *     summary="Paginate Donation",
 *     description="Returns donation collection data",
 * security={
     *           {"bearerAuth": {}}
     *       },
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
    public function paginate(Request $request)
    {
        $donation = $this->donationService->pagination($request);
        return $this->donationService->getDonationCollection($donation);

    }
}
