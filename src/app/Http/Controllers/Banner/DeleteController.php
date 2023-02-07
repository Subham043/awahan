<?php

namespace App\Http\Controllers\Banner;

use App\Http\Controllers\Controller;
use App\Http\Services\BannerService;

class DeleteController extends Controller
{
    private $bannerService;

    public function __construct(BannerService $bannerService)
    {
        $this->bannerService = $bannerService;
    }

/**
 * @OA\Delete(
 *     path="/api/banner/delete/{id}",
 *     tags={"Banner"},
 *     summary="Delete Banner",
 *     description="Returns banner data",
 * security={
     *           {"bearerAuth": {}}
     *       },
 * @OA\Parameter(
 *          name="id",
 *          description="Banner id",
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
    public function delete($id)
    {
        $banner = $this->bannerService->delete($id);

        return response()->json([
            'status' => 'success',
            'data' => $this->bannerService->getBannerResource($banner),
        ], 201);

    }
}
