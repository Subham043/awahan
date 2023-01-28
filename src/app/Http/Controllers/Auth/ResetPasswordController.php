<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Services\Interfaces\UserInterface;
use App\Http\Requests\ResetPasswordPostRequest;

class ResetPasswordController extends Controller
{
    private $userService;

    public function __construct(UserInterface $userService)
    {
        $this->userService = $userService;
    }

        /**
 * @OA\Post(
 *     path="/api/auth/reset-password",
 *     tags={"Auth"},
 *     summary="Update Password of Unauthenticated User",
 *     description="Returns registered user data",
 *     @OA\RequestBody(
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
 *                 ),
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
    public function reset_password(ResetPasswordPostRequest $request, $user_id){
        $user = $this->userService->getById($this->userService->decryptId($user_id));
        
        $this->userService->hasAccess($user);

        if($request->otp!=$user->otp){
            return response()->json([
                'status' => 'error',
                'message' => 'Oops! You have entered wrong otp',
            ], 400);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Password reset successful',
        ], 200);
    }
}
