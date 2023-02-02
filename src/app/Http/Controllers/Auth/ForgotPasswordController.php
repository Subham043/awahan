<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Jobs\SendForgotPasswordEmailJob;
use App\Http\Services\AuthService;
use App\Http\Requests\ForgotPasswordPostRequest;

class ForgotPasswordController extends Controller
{
    private $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }
    /**
 * @OA\Post(
 *     path="/api/auth/forgot-password",
 *     tags={"Auth"},
 *     summary="Forgot Password of User",
 *     description="Returns registered user data",
 *     @OA\RequestBody(
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 type="object",
 *
 *                  @OA\Property(
 *                     property="email",
 *                     description="User Email",
 *                     example="subham.5ine@gmail.com",
 *                     type="string"
 *                 )
 *             )
 *          )
 *     ),
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
    public function forgot_password(ForgotPasswordPostRequest $request){

        $user = $this->authService->forgot_password($request);

        //dispatch(new SendForgotPasswordEmailJob($user));

        return response()->json([
            'status' => 'success',
            'message' => 'Password reset link has been shared with your email address.',
            'user' => $this->authService->geUserResource($user),
        ], 200);
    }
}
