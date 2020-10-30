<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
/**
 * @OA\Post(
 *      path="/api/create-user",
 *      operationId="/api/create-user",
 *      tags={"Auth"},
 *      summary="Log in",
 *      description="Log in to client account to manage orders.",
 *     @OA\Parameter(
 *          name="name",
 *          description="Name of user",
 *          example="Test",
 *          required=true,
 *          in="query",
 *          @OA\Schema(
 *              type="string"
 *          )
 *      ),
 *      @OA\Parameter(
 *          name="email",
 *          description="Email of user",
 *          example="ruslanpanasovskyi@gmail.com",
 *          required=true,
 *          in="query",
 *          @OA\Schema(
 *              type="string"
 *          )
 *      ),
 *      @OA\Parameter(
 *          name="password",
 *          description="Password of user",
 *          example="ilikelaravel",
 *          required=true,
 *          in="query",
 *          @OA\Schema(
 *              type="string"
 *          )
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="Successful operation",
 *
 *       ),
 *      @OA\Response(
 *          response=422,
 *          description="Unauthenticated",
 *      )
 *  )
 */
class CreateUser extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $user = new User();
        $user->name = $request->input('name');
        $user->password = Hash::make($request->input('password'));
        $user->email = $request->input('email');
        $user->save();
    }
}
