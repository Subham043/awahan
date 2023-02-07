<?php

namespace App\Http\Controllers\DonationPage;

use App\Http\Controllers\Controller;
use App\Http\Services\DonationPageService;
use Illuminate\Http\Request;

class PaginateController extends Controller
{
    private $donationPageService;

    public function __construct(DonationPageService $donationPageService)
    {
        $this->donationPageService = $donationPageService;
    }

/**
 * @OA\Get(
 *     path="/api/donation-page/paginate",
 *     tags={"Donation Page"},
 *     summary="Paginate Donation Page",
 *     description="Returns donation page collection data",
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
        $donationPage = $this->donationPageService->pagination($request);
        return $this->donationPageService->getDonationPageCollection($donationPage);

    }
}
