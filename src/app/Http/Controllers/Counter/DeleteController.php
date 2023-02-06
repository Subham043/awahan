<?php

namespace App\Http\Controllers\Counter;

use App\Http\Controllers\Controller;
use App\Http\Services\CounterService;

class DeleteController extends Controller
{
    private $counterService;

    public function __construct(CounterService $counterService)
    {
        $this->counterService = $counterService;
    }

/**
 * @OA\Delete(
 *     path="/api/counter/delete/{id}",
 *     tags={"Counter"},
 *     summary="Display Counter",
 *     description="Returns counter data",
 * security={
     *           {"bearerAuth": {}}
     *       },
 * @OA\Parameter(
 *          name="id",
 *          description="Counter id",
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
        $counter = $this->counterService->delete($id);

        return response()->json([
            'status' => 'success',
            'data' => $this->counterService->getCounterResource($counter),
        ], 201);

    }
}
