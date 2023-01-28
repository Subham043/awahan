<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Services\Interfaces\UserInterface;
use App\Http\Requests\OtpPostRequest;

class VerifyUserController extends Controller
{
    private $userService;

    public function __construct(UserInterface $userService)
    {
        $this->userService = $userService;
    }

/**
 * @OA\Post(
 *     path="/api/auth/verify-user/{id}",
 *     tags={"Auth"},
 *     summary="Verify User",
 *     description="Returns registered user data",
 *      @OA\Parameter(
 *          name="id",
 *          description="User id",
 *          required=true,
 *          in="path",
 *          @OA\Schema(
 *              type="string"
 *          )
 *      ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 type="object",
 * 
 *                  @OA\Property(
 *                     property="otp",
 *                     description="User OTP",
 *                     example="1234",
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
    public function verify_user(OtpPostRequest $request, $user_id){
        $user = $this->userService->getById($this->userService->decryptId($user_id));

        if($request->otp!=$user->otp){
            return response()->json([
                'status' => 'error',
                'message' => 'Oops! You have entered wrong otp',
            ], 400);
        }

        $user = $this->userService->verify_user($user->id);

        $token = Auth::login($user);

        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully',
            'user' => $this->userService->geUserResource($user),
            'access_token' => $token,
        ], 200);
    }
}
