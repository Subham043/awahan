<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Jobs\SendVerificationEmailJob;
use App\Http\Services\Interfaces\UserInterface;
use App\Http\Requests\RegisterPostRequest;

class RegisterController extends Controller
{
    private $userService;

    public function __construct(UserInterface $userService)
    {
        $this->userService = $userService;
    }

    /**
 * @OA\Post(
 *     path="/api/auth/register",
 *     tags={"Auth"},
 *     summary="Register User",
 *     description="Returns registered user data",
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
 *          response=201,
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
    public function register(RegisterPostRequest $request){

        $this->userService->create($request->validated());

        $user = $this->userService->getByEmail($request->email);
        //dispatch(new SendVerificationEmailJob($user));

        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully',
            'user' => $this->userService->geUserResource($user),
        ], 201);
    }
}
