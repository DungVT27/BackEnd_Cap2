<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserProfile;
use App\Models\TSProfile;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UserInfoResource;
use JWTAuth;
use JWTAuthException;
use Illuminate\Support\Facades\RateLimiter;
use App\Http\Requests\AuthRequest;

class AuthController extends Controller
{
    public function loginUser(Request $request){
        $credentials = $request->only('email', 'password');
        $token = null;
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['msg' => 'Đăng nhập thất bại', 'email' => $request->email, 'status' => 401], 401);
            }
        } catch (JWTAuthException $e) {
            return response()->json(['failed_to_create_token'], 500);
        }

        if(Auth::user()->user_roles === 'ts'){
            return response()->json(['msg' => 'Đăng nhập thất bại', 'email' => $request->email, 'status' => 401], 401);
        }
        return response()->json([
            'msg' => 'Đăng nhập thành công',
            'token' => $token, 
            'user_info' =>
                new UserInfoResource(User::find(Auth::user()->id)),
            'status' => 200,
        ], 200);
    }

    public function loginTS(Request $request){
        $credentials = $request->only('email', 'password');
        $token = null;
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['msg' => 'Đăng nhập thất bại', 'email' => $request->email, 'status' => 401], 401);
            }
        } catch (JWTAuthException $e) {
            return response()->json(['failed_to_create_token'], 500);
        }
        if(Auth::user()->user_roles == 'user'){
            return response()->json(['msg' => 'Đăng nhập thất bại', 'email' => $request->email, 'status' => 401], 401);
        }
        return response()->json([
            'msg' => 'Đăng nhập thành công',
            'token' => $token, 
            'user_info' =>
                new UserInfoResource(User::find(Auth::user()->id)),
            'status' => 200,
        ], 200);
    }

    public function getUserInfo(Request $request){
        $user = JWTAuth::toUser($request->token);
        return response()->json($user);
    }

    public function userRegister(Request $request){
        try{
            $email = User::where('email', $request->email)->firstOrFail();
            return response()->json(['msg' => 'Đăng ký thất bại email của bạn đã tồn tại', 
                                    'data' =>[
                                        'email' => $request->email,
                                        'phone_number' => $request->phone_number,
                                        'password' => $request->password,
                                        'name' => $request->name,
                                        'status' => 401
                                    ]], 401);
        }
        catch(\Exception){
            $email = $request->email;
        }
        
        $user = User::create([
            'name' => $request->name,
            'email' => $email,
            'phone_number' => $request->phone_number,
            'password' => $request->password,
            'is_Admin' => false,
            'user_roles' => "user",
        ]);

        UserProfile::create([
            'user_id' => $user->id,
            'gender' => 'female',
            'avatar' => ''
        ]); 

        return response()->json(['msg' => "Đăng ký thành công", 'status' => 200], 200);
    }

    public function tsRegister(Request $request){
        try{
            $email = User::where('email', $request->email)->firstOrFail();
            return response()->json(['msg' => 'Đăng ký thất bại email của bạn đã tồn tại', 
                                    'data' =>[
                                        'email' => $request->email,
                                        'phone_number' => $request->phone_number,
                                        'password' => $request->password,
                                        'name' => $request->name,
                                        'status' => 401
                                    ]], 401);
        }
        catch(\Exception){
            $email = $request->email;
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $email,
            'phone_number' => $request->phone_number,
            'password' => $request->password,
            'is_Admin' => false,
            'user_roles' => "ts",
        ]);

        TsProfile::create([
            'user_id' => $user->id,
            'avatar' => ''
        ]);

        return response()->json(['msg' => "Đăng ký thành công", 'status' => 200], 200);
    }

    public function adminLoginPage()
    {
        return view('Login');
    }

    public function adminLogin(AuthRequest $request)
    {
        if (RateLimiter::tooManyAttempts($request->email, 5)) {
            $second = RateLimiter::availableIn($request->email);
            return redirect()->back()->with('error', "Your account has been locked! Please turn back in $second s");
        } // Lock login in 2 minutes if user login fail 5 times 

        if (!Auth::attempt($request->only(['email', 'password']), $request->filled('remember'))) {
            RateLimiter::hit($request->email, 120);

            return redirect()->back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])->onlyInput('email');
        } // if wrong email or password, return error

        if (Auth::user()->is_admin != 1) {
            $request->session()->invalidate();
            return redirect()->back()->withErrors([
                'email' => 'No access permission',
            ])->onlyInput('email');
        }

        $request->session()->regenerate();

        return to_route('dashboard');
    }

    public function adminLogout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return to_route('login');
    }
}
