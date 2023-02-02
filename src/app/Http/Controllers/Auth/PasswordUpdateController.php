<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\CustomJsonException;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Services\AuthService;
use App\Http\Requests\PasswordPostRequest;

class PasswordUpdateController extends Controller
{
    private $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

        /**
 * @OA\Post(
 *     path="/api/auth/password-update",
 *     tags={"Auth"},
 *     summary="Update Password of Authenticated User",
 *     description="Returns registered user data",
 *      security={
     *           {"bearerAuth": {}}
     *       },
 *     @OA\RequestBody(
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 type="object",

 *                 @OA\Property(
 *                     property="old_password",
 *                     description="User Old Password",
 *                     example="subham",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="password",
 *                     description="User New Password",
 *                     example="subham",
 *                     type="string"
 *                 ),
 *                  @OA\Property(
 *                     property="confirm_password",
 *                     description="User Confirm Password",
 *                     example="subham",
 *                     type="string"
 *                 ),
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
    public function password_update(PasswordPostRequest $request)
    {
        $user = $this->authService->password_update($request);

        return response()->json([
            'status' => 'success',
            'user' => $this->authService->geUserResource($user),
        ], 200);
    }
}
