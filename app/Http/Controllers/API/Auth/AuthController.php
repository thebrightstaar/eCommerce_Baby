<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\API\Auth\ActivationService;
use App\Http\Controllers\API\Auth\ActivationRepository;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    protected $activationService;

    public function __construct(ActivationService $activationService)
    {
        $this->middleware(['guest'], ['except' => 'logout']);
        $this->activationService = $activationService;
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'type' => 'string'
        ]);
        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 422);
        }
        $request['password'] = Hash::make($request['password']);
        $request['type'] = $request['type'] === 'admin' ? 1  : 0;
        $user = User::create($request->toArray());
        // $user->sendEmailVerificationNotification();
        // $token = $user->createToken('eCommerce Baby Made By TG Developer')->accessToken;
        // $response = ['token' => $token];
        $this->activationService->sendActivationMail($user);
        return response()->json(['message' => 'Check your email for verification'], 200);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
        ]);
        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 422);
        }
        $user = User::where('email', $request->email)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                if (!$user->activated) {
                    $this->activationService->sendActivationMail($user);
                    auth()->logout();
                    return response([
                        'error' => 'warning',
                        'message' => 'You need to confirm your account. We have sent you an activation code, please check your email.'
                    ], 404);
                }
                $token = $user->createToken('eCommerce Baby Made By TG Developer')->accessToken;
                $response = ['token' => $token];
                return response($response, 200);
            } else {
                $response = ["message" => "Password mismatch"];
                return response($response, 422);
            }
        } else {
            $response = ["message" => 'User does not exist'];
            return response($response, 422);
        }
    }

    public function logout(Request $request)
    {
        $token = $request->user()->token();
        $token->revoke();
        $response = ['message' => 'You have been successfully logged out!'];
        return response($response, 200);
    }
}
