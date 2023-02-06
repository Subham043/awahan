<?php

namespace App\Http\Controllers\Counter;

use App\Http\Controllers\Controller;
use App\Http\Services\CounterService;
use Illuminate\Http\Request;

class PaginateController extends Controller
{
    private $counterService;

    public function __construct(CounterService $counterService)
    {
        $this->counterService = $counterService;
    }

/**
 * @OA\Get(
 *     path="/api/counter/paginate",
 *     tags={"Counter"},
 *     summary="Paginate Counter",
 *     description="Returns counter collection data",
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
        $counter = $this->counterService->pagination($request);
        return $this->counterService->getCounterCollection($counter);

    }
}
