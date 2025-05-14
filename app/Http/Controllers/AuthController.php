<?php

namespace App\Http\Controllers;

use App\Models\Crew;
use App\Models\User;
use App\Models\Admin;
use Ramsey\Uuid\Uuid;
use App\Models\Coordinator;
use App\Models\Participant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(){
        $data = [
            'title' => 'Login',
            'subTitle' => null,
            'page_id' => null
        ];
        return view('auth.login',  $data);
    }

    public function loginSubmit(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|exists:users,email',
            'password' => 'required|string',
        ]);
    
        if ($validator->fails()) {
            return redirect()->route('login')->withInput()->withErrors($validator);
        }
    
        $email = $request->input('email');
        $password = $request->input('password');
    
        // Attempt to authenticate using the determined login type
        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            $user = User::where('email', $email)->first();
            $admin = Admin::where('user_id', $user->id)->exists();
            $coordinator = Coordinator::where('user_id', $user->id)->exists();
            $participant = Participant::where('user_id', $user->id)->exists();
            $crew = Crew::where('user_id', $user->id)->exists();
            if (($admin OR $crew) OR ($coordinator OR $participant)) {
                if($user->is_default == true){
                    return redirect()->route('change');
                }
                return redirect()->route('dashboard');
            } else {
                Auth::logout();
                return redirect()->route('login')->with('error', 'You are not authorized to access this application');
            }
            return redirect()->route('dashboard');
        } else {
            return redirect()->route('login')->with('error', 'Username/Email and password are incorrect, please try again');
        }
    }
    
    public function change(){
        if(Auth::user()->is_default == false){
            return redirect()->route('dashboard');
        }
        $data = [
            'title' => 'Change Password',
            'subTitle' => null,
            'page_id' => null
        ];
        return view('auth.change-password',  $data);
    }
    public function changeSubmit(Request $request){
        $validator = Validator::make($request->all(), [
            'password' => 'required|string|min:8',
        ]);
        if ($validator->fails()) {
            return redirect()->route('change')->withInput()->withErrors($validator);
        }
        $user = User::findOrFail(Auth::user()->id);
        $user->password = Hash::make($request->password);
        $user->is_default = false;
        $user->save();
        return redirect()->route('dashboard')->with('success','Congratulation!, Your password has been changed successfully');
    }

    public function forgot(){
        $data = [
            'title' => 'Forget Password',
            'subTitle' => null,
            'page_id' => null
        ];
        return view('auth.forgot',  $data);
    }

    public function forgotSubmit(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255|exists:users',
        ]);
        if ($validator->fails()) {
            return redirect()->route('forgot')->withInput()->withErrors($validator);
        }
        $token = Uuid::uuid4();
                DB::table('password_reset_tokens')->insert([
                    'email' => $request->email, 
                    'token' => $token, 
                ]); 
        Mail::send('email.forgetPassword', ['token' => $token, 'email' => $request->email], function ($message) use ($request) {
            $message->to($request->email);
            $message->subject('Reset Password');
        });
        return redirect()->route('forgot')->with('success', 'Email sent successfuly, Please check your email for reset password');
    }

    public function reset($token){
        $cekToken = DB::table('password_reset_tokens')->where('token', '=', $token)->first();
        if (!$cekToken) {
            return redirect()->route('login')->with('error', 'Invalid token');
        }
        $data = [
            'user' => User::where('email', $cekToken->email)->firstOrFail(),
            'token' => $token,
            'title' => 'Reset Password',
            'subTitle' => null,
            'page_id' => null
        ];
        return view('auth.reset',  $data);
    }

    public function resetSubmit($token, Request $request){
        $updatePassword = DB::table('password_reset_tokens')->where(['email' => $request->email,'token' => $token])->first();
        if(!$updatePassword){
            return redirect()->route('login')->with('error','Token Invalid');
        }
        $validator = Validator::make($request->all(), [
            'password' => 'required|string|min:8',
        ]);
        if ($validator->fails()) {
            return redirect()->route('reset', $token)->withInput()->withErrors($validator);
        }
        User::where('email', $updatePassword ->email)->update(['password' => Hash::make($request->password)]);
        DB::table('password_reset_tokens')->where(['email'=> $request->email])->delete();
        return redirect()->route('login')->with('success','Congratulation!, Your password has been changed successfully');
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('home');
    }
}
