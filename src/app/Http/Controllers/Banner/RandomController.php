<?php

namespace App\Http\Controllers\Banner;

use App\Http\Controllers\Controller;
use App\Http\Services\BannerService;

class RandomController extends Controller
{
    private $bannerService;

    public function __construct(BannerService $bannerService)
    {
        $this->bannerService = $bannerService;
    }

/**
 * @OA\Get(
 *     path="/api/banner/random",
 *     tags={"Banner"},
 *     summary="Display Random Banner",
 *     description="Returns banner data",
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
        $banner = $this->bannerService->random();

        return response()->json([
            'status' => 'success',
            'data' => $this->bannerService->getBannerCollection($banner),
        ], 200);

    }
}
