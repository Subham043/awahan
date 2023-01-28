<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Services\Interfaces\UserInterface;
use App\Http\Requests\LoginPostRequest;

class AdminLoginController extends Controller
{
    private $userService;

    public function __construct(UserInterface $userService)
    {
        $this->userService = $userService;
    }

/**
 * @OA\Post(
 *     path="/api/auth/admin-login",
 *     tags={"Auth"},
 *     summary="Authenticate Admin",
 *     description="Returns authenticated admin data",
 *     @OA\RequestBody(
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 type="object",
 * 
 *                 @OA\Property(
 *                     property="email",
 *                     description="User Email",
 *                     example="subham.5ine@gmail.com",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="password",
 *                     description="User Password",
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
    public function login(LoginPostRequest $request)
    {
        $credentials = $request->safe()->only('email', 'password');
        $credentials['userType'] = 1;

        $token = $this->userService->login($credentials);
        
        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid Credentials',
            ], 401);
        }
        
        $user = $this->userService->getByEmail($request->email);

        $this->userService->hasAccess($user);

        return response()->json([
            'status' => 'success',
            'user' => $this->userService->geUserResource($data['user']),
            'access_token' => $data['token'],
        ], 200);

    }
}
