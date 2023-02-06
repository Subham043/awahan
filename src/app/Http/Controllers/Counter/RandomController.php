<?php

namespace App\Http\Controllers\Counter;

use App\Http\Controllers\Controller;
use App\Http\Services\CounterService;

class RandomController extends Controller
{
    private $counterService;

    public function __construct(CounterService $counterService)
    {
        $this->counterService = $counterService;
    }

/**
 * @OA\Get(
 *     path="/api/counter/random",
 *     tags={"Counter"},
 *     summary="Display Random Counter",
 *     description="Returns counter data",
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
        $counter = $this->counterService->random();

        return response()->json([
            'status' => 'success',
            'data' => $this->counterService->getCounterCollection($counter),
        ], 200);

    }
}
