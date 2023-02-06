<?php

namespace App\Http\Controllers\Counter;

use App\Http\Controllers\Controller;
use App\Http\Requests\CounterPostRequest;
use App\Http\Services\CounterService;

class CreateController extends Controller
{
    private $counterService;

    public function __construct(CounterService $counterService)
    {
        $this->counterService = $counterService;
    }

/**
 * @OA\Post(
 *     path="/api/counter/create",
 *     tags={"Counter"},
 *     summary="Create Counter",
 *     description="Returns created counter data",
 * security={
     *           {"bearerAuth": {}}
     *       },
 *     @OA\RequestBody(
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 type="object",
 *
 *                 @OA\Property(
 *                     property="counter",
 *                     description="Counter",
 *                     example="2234",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="title",
 *                     description="Title",
 *                     example="title text",
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
    public function create(CounterPostRequest $request)
    {
        $counter = $this->counterService->create($request);

        return response()->json([
            'status' => 'success',
            'data' => $this->counterService->getCounterResource($counter),
        ], 201);

    }
}
