<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Services\Interfaces\UserInterface;

class RefreshController extends Controller
{
    private $userService;

    public function __construct(UserInterface $userService)
    {
        $this->userService = $userService;
    }
         /**
 * @OA\Get(
 *     path="/api/auth/refresh",
 *     tags={"Auth"},
 *     summary="Refresh Token of Authenticated User",
 *     description="Returns registered user data",
 *      security={
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
    public function refresh()
    {
        return response()->json([
            'status' => 'success',
            'user' => $this->userService->geUserResource($this->userService->auth_user_details()),
            'refresh_token' => $this->userService->auth_refresh(),
        ], 200);
    }
}
