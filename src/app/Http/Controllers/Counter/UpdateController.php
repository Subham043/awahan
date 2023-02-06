<?php

namespace App\Http\Controllers\Counter;

use App\Http\Controllers\Controller;
use App\Http\Requests\CounterPostRequest;
use App\Http\Services\CounterService;

class UpdateController extends Controller
{
    private $counterService;

    public function __construct(CounterService $counterService)
    {
        $this->counterService = $counterService;
    }

/**
 * @OA\Post(
 *     path="/api/counter/update/{id}",
 *     tags={"Counter"},
 *     summary="Update Counter",
 *     description="Returns updated counter data",
 * security={
     *           {"bearerAuth": {}}
     *       },
 *     @OA\Parameter(
 *          name="id",
 *          description="Counter id",
 *          required=true,
 *          in="path",
 *          @OA\Schema(
 *              type="string"
 *          )
 *      ),
 *     @OA\RequestBody(
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 type="object",
 *
 *                 @OA\Property(
 *                     property="counter",
 *                     description="counter",
 *                     example="22341",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="title",
 *                     description="Counter Title",
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
    public function update(CounterPostRequest $request, $id)
    {
        $counter = $this->counterService->update($request, $id);

        return response()->json([
            'status' => 'success',
            'data' => $this->counterService->getCounterResource($counter),
        ], 201);

    }
}
