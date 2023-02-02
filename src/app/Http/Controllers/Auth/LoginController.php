<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\CustomJsonException;
use App\Http\Controllers\Controller;
use App\Http\Services\AuthService;
use App\Http\Requests\LoginPostRequest;

class LoginController extends Controller
{
    private $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }
/**
 * @OA\Post(
 *     path="/api/auth/login",
 *     tags={"Auth"},
 *     summary="Authenticate User",
 *     description="Returns authenticated user data",
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
        $token = $this->authService->login($request->all());

        if (!$token) {
            throw new CustomJsonException('Oops! Invalid Credentials', 401);
        }

        $user = $this->authService->getByEmail($request->email);

        $this->authService->hasAccess($user);

        return response()->json([
            'status' => 'success',
            'user' => $this->authService->geUserResource($user),
            'access_token' => $token,
        ], 200);

    }
}
