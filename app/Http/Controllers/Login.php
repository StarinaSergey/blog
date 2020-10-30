<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use DB;
use Illuminate\Support\Str;
use GuzzleHttp;

/**
 * @OA\Post(
 *      path="/api/login",
 *      operationId="/api/login",
 *      tags={"Auth"},
 *      summary="Log in",
 *      description="Log in to client account to manage orders.",
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
class Login extends Controller
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {

        // Check if a user with the specified email exists
        $client = $this->userRepository->getClientForEmail($request->input('email'));

        if (!$client) {
            return response()->json([
                'message' => 'Wrong email or password',
                'status' => 422
            ], 422);
        }

        // If a user with the email was found - check if the specified password
        // belongs to this user
        if (!Hash::check($request->input('password'), $client->password)) {
            return response()->json([
                'message' => 'Wrong email or password',
                'status' => 422
            ], 422);
        }

        // Send an internal API request to get an access token
        $oauthClient = DB::table('oauth_clients')
            ->where('password_client', true)
            ->first();

        // Make sure a Password Client exists in the DB
        if (!$oauthClient) {
            return response()->json([
                'message' => 'Not set up properly.',
                'status' => 500
            ], 500);
        }

//        $http2 = new GuzzleHttp\Client;
//        $state = Str::random(40);
//        $query = http_build_query([
//            'client_id' => $oauthClient->id,
//            'redirect_uri' => 'http://127.0.0.1:8001/api/login',
//            'response_type' => 'code',
//            'scope' => '',
//            'state' => $state,
//        ]);
//        $response = $http2->get("http://127.0.0.1:8001/oauth/authorize?". $query);
//        var_dump($response);die;


        //var_dump($data);die;

        //$http = new GuzzleHttp\Client;
//        $response = $http->post(secure_url('/') . '/oauth/token', [
//            'form_params' => [
//                //'grant_type' => 'authorization_code',
//                //'client_id' => $oauthClient->id,
//                //'client_secret' => $oauthClient->secret,
//                //'redirect_uri' => "http://127.0.0.1:8001/login",
//                //'code' => $request->code,
//            ],
//        ]);
//        var_dump($response);die;
        $data = [
            'grant_type' => 'authorization_code',
            //'redirect_uri' => 'http://127.0.0.1:8001/api/login',
            //'code' => $request->code,
            'client_id' => $oauthClient->id,
            'client_secret' => $oauthClient->secret,
            'username' => $client->email,
            'password' => $client->password,
        ];
        $request = Request::create(secure_url('/') . '/oauth/token', 'POST', $data);

        $response = app()->handle($request);
        var_dump($response);die;

    }
}
