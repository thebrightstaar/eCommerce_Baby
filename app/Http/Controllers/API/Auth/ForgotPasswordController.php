<?php

namespace App\Http\Controllers\API\Auth;


use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    public function forgot(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => __('auth.validateError'), 'data' => $validator->errors()], 400);
        }

        $email = $request->email;

        if (User::where('email', $email)->doesntExist()) {
            return response()->json(['error' => __('auth.failed')], 400);
        }

        $token = Str::random(6);

        try {
            DB::table('password_resets')->insert([
                'email' => $email,
                'token' => $token
            ]);

            Mail::send('Mails.forgot', ['token' => $token], function (Message $message)  use ($email) {
                $message->to($email);
                $message->subject(__('auth.reset'));
            });

            return response([
                'message' => __('auth.checkEmail')
            ]);
        } catch (\Exception $exception) {
            return response()->json(['error', 'data' => $exception->getMessage()], 400);
        }
    }

    public function reset(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => __('auth.validateError'), 'data' => $validator->errors()], 400);
        }

        $token = $request->token;
        $passwordResets = DB::table('password_resets')->where('token', $token)->first();

        if (!$passwordResets) {
            return response()->json(['error' => __('auth.invalid')], 400);
        }

        $user = User::where('email', $passwordResets->email)->first();

        if (!$user) {
            return response()->json(['error' => __('auth.failed')], 400);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json(['message' => __('auth.change')], 200);
    }
}
