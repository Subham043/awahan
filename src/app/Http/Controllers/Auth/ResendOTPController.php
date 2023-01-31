<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Jobs\SendOtpEmailJob;
use App\Http\Services\AuthService;

class ResendOTPController extends Controller
{
    private $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

/**
 * @OA\Get(
 *     path="/api/auth/resent-otp/{id}",
 *     tags={"Auth"},
 *     summary="Re-send Otp",
 *     description="Returns registered user data",
 * @OA\Parameter(
 *          name="id",
 *          description="User id",
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
    public function send_otp($user_id){

        $user = $this->authService->send_otp($user_id);

        //dispatch(new SendOtpEmailJob($user));

        return response()->json([
            'status' => 'success',
            'message' => 'Otp sent successfully',
        ], 200);
    }
}
