<?php

namespace App\Http\Controllers\Donation;

use App\Http\Controllers\Controller;
use App\Http\Requests\DonationCreatePostRequest;
use App\Http\Services\DonationService;

class CreateController extends Controller
{
    private $donationService;

    public function __construct(DonationService $donationService)
    {
        $this->donationService = $donationService;
    }

/**
 * @OA\Post(
 *     path="/api/donation/create",
 *     tags={"Donation"},
 *     summary="Create Donation",
 *     description="Returns created donation data",
 *     @OA\RequestBody(
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 type="object",
 *
 *                 @OA\Property(
 *                     property="name",
 *                     description="Donor's Name",
 *                     example="saha",
 *                     type="string"
 *                 ),
 *                  @OA\Property(
 *                     property="phone",
 *                     description="Donor's Phone",
 *                     example="7892156160",
 *                     type="string"
 *                 ),
 *                  @OA\Property(
 *                     property="email",
 *                     description="Donor's Email",
 *                     example="subham.5ine@gmail.com",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="amount",
 *                     description="Donation Amount",
 *                     example="100",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="message",
 *                     description="Donation Message",
 *                     example="test",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="donation_page_id",
 *                     description="Donation Page id",
 *                     example="1",
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
    public function create(DonationCreatePostRequest $request)
    {
        $donation = $this->donationService->create($request);

        return response()->json([
            'status' => 'success',
            'data' => $this->donationService->getDonationResource($donation),
        ], 201);

    }
}
