<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use App\Traits\ApiResponser;
use Carbon\Carbon;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use ApiResponser;

    public $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function auth(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'email' => 'required|string|email',
                'password' => 'required|string',
                'remember_me' => 'boolean'
            ]
        );

        if ($validator->fails())
            return response()->json(['error' => $validator->errors()], 200);

        $credentials = request(['email', 'password']);

        if (!Auth::attempt($credentials))
            return $this->errorMessage("Invalid Credentials.", 401);

        $user = $request->user();
        if ($user->status != 1)
            return $this->errorMessage("Unauthorized! Account is unapproved.", 401);

        $tokenResult = $user->createToken('Personal Access Client');
        $token = $tokenResult->token;
        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();
        return $this->successResponse([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ]);
        //return $this->userService->authUser($request->all());
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }
}
