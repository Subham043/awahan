<?php

namespace App\Http\Controllers\Banner;

use App\Http\Controllers\Controller;
use App\Http\Services\BannerService;
use Illuminate\Http\Request;

class PaginateController extends Controller
{
    private $bannerService;

    public function __construct(BannerService $bannerService)
    {
        $this->bannerService = $bannerService;
    }

/**
 * @OA\Get(
 *     path="/api/banner/paginate",
 *     tags={"Banner"},
 *     summary="Paginate Banner",
 *     description="Returns banner collection data",
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
        $banner = $this->bannerService->pagination($request);
        return $this->bannerService->getBannerCollection($banner);

    }
}
