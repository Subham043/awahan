<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Services\AuthService;
use App\Http\Requests\ProfilePostRequest;

class ProfileUpdateController extends Controller
{
    private $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

        /**
 * @OA\Post(
 *     path="/api/auth/profile-update",
 *     tags={"Auth"},
 *     summary="Update Profile of Authenticated User",
 *     description="Returns registered user data",
 *      security={
     *           {"bearerAuth": {}}
     *       },
 *     @OA\RequestBody(
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 type="object",
 *
 *                 @OA\Property(
 *                     property="first_name",
 *                     description="User First Name",
 *                     example="subham",
 *                     type="string"
 *                 ),
 *                  @OA\Property(
 *                     property="last_name",
 *                     description="User Last Name",
 *                     example="saha",
 *                     type="string"
 *                 ),
 *                  @OA\Property(
 *                     property="phone",
 *                     description="User Phone",
 *                     example="7892156160",
 *                     type="string"
 *                 ),
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
    public function profile_update(ProfilePostRequest $request)
    {
        $user = $this->authService->profile_update($request);

        return response()->json([
            'status' => 'success',
            'user' => $this->authService->geUserResource($user),
        ], 200);
    }
}
