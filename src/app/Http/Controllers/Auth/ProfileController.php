<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Services\AuthService;

class ProfileController extends Controller
{
    private $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

             /**
 * @OA\Get(
 *     path="/api/auth/profile",
 *     tags={"Auth"},
 *     summary="Profile Data of Authenticated User",
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
    public function profile()
    {
        return response()->json([
            'status' => 'success',
            'user' => $this->authService->geUserResource($this->authService->auth_user_details()),
        ], 200);
    }
}
