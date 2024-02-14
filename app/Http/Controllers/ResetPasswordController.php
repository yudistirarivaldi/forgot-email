<?php

namespace App\Http\Controllers;

use App\Models\PasswordReset;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;
// use App\Models\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
// use Illuminate\Auth\Events\PasswordReset;

class ResetPasswordController extends Controller
{
    public function forgetPassword(Request $request)
    {
        try {

            $user = User::where('email', $request->email)->get();

            if(count($user) > 0) {

                $token = Str::random(40);
                $domain = URL::to('/');
                $url = $domain.'reset-password?token='.$token;

                $data['url'] = $url;
                $data['email'] = $request->email;
                $data['title'] = "Password Reset";
                $data['body'] = "Please click on below link to reset your password.";

                Mail::send('forgot-password-mail', ['data' => $data], function($message) use ($data) {
                    $message->to($data['email'])->subject($data['title']);
                });

                $datetime = Carbon::now()->format('Y-m-d H:i:s');
                PasswordReset::updateOrCreate(
                    ['email' => $request->email],
                    [
                        'email' => $request->email,
                        'token' => $token,
                        'created_at' => $datetime,
                    ]
                );
                 return response()->json(['success' => true, 'msg' => 'Please check your email to reset password']);
            } else {
                 return response()->json(['success' => false, 'msg' => 'User not found']);
            }

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'msg' => $e->getMessage()]);
        }
    }

    public function resetPasswordLoad(Request $request) {

        $resetData = PasswordReset::where('token', $request->token)->get();

        if(isset($request->token) && count($resetData) > 0) {

            $user = User::where('email', $resetData[0]['email'])->get();
            return view('reset-password', compact('user'));

        } else {
            return view('404');
        }
    }

    public function forgotPasswordLoad(Request $request) {

          return view('email-forgot');
    }

    public function resetPassword(Request $request) {

        $request->validate([
            'password' => 'required|string|confirmed'
        ]);

        $user = User::find($request->id);
        // $user->password = Hash::make($request->password);
        $user->password = $request->password;
        $user->save();

        PasswordReset::where('email', $user->email)->delete();

        return "MANTULLL BERHASIL UPDATE";

    }



}
