<?php

namespace App\Http\Controllers\Banner;

use App\Http\Controllers\Controller;
use App\Http\Requests\BannerUpdatePostRequest;
use App\Http\Services\BannerService;

class UpdateController extends Controller
{
    private $bannerService;

    public function __construct(BannerService $bannerService)
    {
        $this->bannerService = $bannerService;
    }

/**
 * @OA\Post(
 *     path="/api/banner/update/{id}",
 *     tags={"Banner"},
 *     summary="Update Banner",
 *     description="Returns updated banner data",
 * security={
     *           {"bearerAuth": {}}
     *       },
 *     @OA\Parameter(
 *          name="id",
 *          description="Banner id",
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
 *                     property="imsge",
 *                      format="binary",
 *                     description="Banner Image",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="alt",
 *                     description="Banner Alt",
 *                     example="image alt text",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="title",
 *                     description="Banner Title",
 *                     example="image title text",
 *                     type="string"
 *                 )
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
    public function update(BannerUpdatePostRequest $request, $id)
    {
        $banner = $this->bannerService->update($request, $id);

        return response()->json([
            'status' => 'success',
            'data' => $this->bannerService->getBannerResource($banner),
        ], 201);

    }
}
