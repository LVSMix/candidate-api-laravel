<?php


namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class LoginController extends  Controller{


    /*
   |-------------------------------------------------------------------
   | Login Controller
   |-------------------------------------------------------------------
   |
   | This controller handles authenticating users for the application and
   | redirecting them to your home screen. The controller uses a trait
   | to conveniently provide its functionality to your applications.
   |
   */

    use AuthenticatesUsers;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * @OA\Post(
     * path="/api/login",
     * summary="Login",
     * description="Login by email, password",
     * operationId="login",
     * tags={"Auth"},
     *   @OA\RequestBody(
     *      required=true,
     *      description="Save user credentials",
     *      @OA\JsonContent(
     *             required={"email","password"},
     *             @OA\Property(property="email", type="string", format="email", example="user1@mail.com"),
     *             @OA\Property(property="password", type="string", format="password", example="PassWord12345"),
     *      ),
     *   ),
     *   @OA\Response(
     *    response=401,
     *    description="Wrong credentials response",
     *     @OA\JsonContent(
     *        @OA\Property(property="message", type="string", example="No Autorizado")
     *     ),
     *   ),
     *   @OA\Response(
     *    response=200,
     *    description="Success",
     *     @OA\JsonContent(
     *        @OA\Property(property="data",
     *              @OA\Property(property="id", type="string", example="1"),
     *              @OA\Property(property="name", type="string", example="Prueba"),
     *              @OA\Property(property="email", type="string", example="lvsmix@gmail.com"),
     *              @OA\Property(property="email_verified_at", type="string", example="null"),
     *              @OA\Property(property="created_at", type="string", example="2020-09-07T05:48:19.000000Z"),
     *              @OA\Property(property="updated_at", type="string", example="2020-09-16T03:55:56.000000Z"),
     *              @OA\Property(property="api_token", type="string", example="myX3QjZObLGuReiCJgmfibMCijDchupJwV9bqxAHVjmTktpKBHw0uttSM2dc")
     *        )
     *     ),
     *   ),
     * ),
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        if ($this->attemptLogin($request)) {
            $user = $this->guard()->user();
            $user->generateToken();

            return response()->json([
                'data' => $user->toArray(),
            ]);
        }

        return $this->sendFailedLoginResponse($request);
    }

    public function logout(Request $request)
    {
        $user = Auth::guard('api')->user();

        if ($user) {
            $user->api_token = null;
            $user->save();
        }

        return response()->json(['data' => 'User logged out.'], 200);
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return response()->json(['error' => 'Unauthenticated'], 401);
    }

}
