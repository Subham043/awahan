<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Services\AuthService;

class LogoutController extends Controller
{

    private $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

/**
 * @OA\Get(
 *     path="/api/auth/logout",
 *     tags={"Auth"},
 *     summary="Logout Authenticated User",
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
    public function logout()
    {
        $this->authService->logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ], 200);
    }
}
