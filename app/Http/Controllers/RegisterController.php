<?php


namespace App\Http\Controllers;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\User;


class RegisterController extends  Controller{


    /*
    |----------------------------------------------------------------
    | Register Controller
    |----------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as
    | their validation and creation. By default this controller uses
    | a trait to provide this functionality without requiring any
    | additional code.
    |
    */

    use RegistersUsers;

    // ...

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }



    /**
     * @OA\Post(
     * path="/api/register",
     * summary="Register",
     * description="Register new user",
     * operationId="register",
     * tags={"Auth"},
     *   @OA\RequestBody(
     *      required=true,
     *      description="Save user credentials",
     *      @OA\JsonContent(
     *             required={"email","password"},
     *             @OA\Property(property="name", type="string", example="Prueba"),
     *             @OA\Property(property="email", type="string", format="email", example="user1@mail.com"),
     *             @OA\Property(property="password", type="string", format="password", example="PassWord12345"),
     *             @OA\Property(property="password_confirmation", type="string", format="password", example="PassWord12345"),
     *      ),
     *   ),
     *   @OA\Response(
     *    response=422,
     *    description="Wrong credentials response",
     *     @OA\JsonContent(
     *        @OA\Property(property="message", type="string", example="The given data was invalid."),
     *        @OA\Property(property="errors",
     *           @OA\Property(property="email", type="object", example="['The email has already been taken.']"),
     *        ),
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
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }



    protected function registered(Request $request, $user)
    {
        $user->generateToken();

        return response()->json(['data' => $user->toArray()], 201);
    }

}
