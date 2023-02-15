<?php

namespace App\Http\Controllers\DonationPage;

use App\Http\Controllers\Controller;
use App\Http\Requests\DonationPageUpdatePostRequest;
use App\Http\Services\DonationPageService;

class UpdateController extends Controller
{
    private $donationPageService;

    public function __construct(DonationPageService $donationPageService)
    {
        $this->donationPageService = $donationPageService;
    }

/**
 * @OA\Post(
 *     path="/api/donation-page/update/{id}",
 *     tags={"Donation Page"},
 *     summary="Update Donation Page",
 *     description="Returns updated donation page data",
 * security={
     *           {"bearerAuth": {}}
     *       },
 *     @OA\Parameter(
 *          name="id",
 *          description="Donation Page id",
 *          required=true,
 *          in="path",
 *          @OA\Schema(
 *              type="string"
 *          )
 *      ),
 *     @OA\RequestBody(
 *         @OA\MediaType(
 *             mediaType="multipart/form-data",
 *             @OA\Schema(
 *                 type="object",
 *                  @OA\Property(
 *                     property="image",
 *                      format="binary",
 *                     description="Image",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="image_alt",
 *                     description="Image Alt",
 *                     example="image alt text",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="image_title",
 *                     description="Image Title",
 *                     example="image title text",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="title",
 *                     description="Title",
 *                     example="title text",
 *                     type="string"
 *                 ),
 *                  @OA\Property(
 *                     property="slug",
 *                     description="Slug",
 *                     example="slug",
 *                     type="string"
 *                 ),
 *                  @OA\Property(
 *                     property="funds_required",
 *                     description="Funds required",
 *                     example="120000",
 *                     type="string"
 *                 ),
 *                  @OA\Property(
 *                     property="fund_required_within",
 *                     description="Funds required within",
 *                     example="120000",
 *                     type="string"
 *                 ),
 *                  @OA\Property(
 *                     property="campaigner_name",
 *                     description="Campaigner Name",
 *                     example="Dilip",
 *                     type="string"
 *                 ),
 *                  @OA\Property(
 *                     property="campaigner_funds_collected",
 *                     description="Campaigner funds collected till now",
 *                     example="120000",
 *                     type="string"
 *                 ),
 *                  @OA\Property(
 *                     property="beneficiary_name",
 *                     description="Beneficiary Name",
 *                     example="Ashish",
 *                     type="string"
 *                 ),
 *
 *                  @OA\Property(
 *                     property="beneficiary_relationship_with_campaigner",
 *                     description="Relationship of beneficiary with campaigner",
 *                     example="Sibling Of",
 *                     type="string"
 *                 ),
 *                  @OA\Property(
 *                     property="beneficiary_funds_collected",
 *                     description="Funds collected till now",
 *                     example="120000",
 *                     type="string"
 *                 ),
 *                  @OA\Property(
 *                     property="donation_detail",
 *                     description="Detail of donation page",
 *                     example="test",
 *                     type="string"
 *                 ),
 *                  @OA\Property(
 *                     property="terms_condition",
 *                     description="Terms & Condition",
 *                     example="test",
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
    public function update(DonationPageUpdatePostRequest $request, $id)
    {
        $donationPage = $this->donationPageService->update($request, $id);

        return response()->json([
            'status' => 'success',
            'data' => $this->donationPageService->getDonationPageResource($donationPage),
        ], 201);

    }
}
