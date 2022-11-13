<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Validator;
use Auth;

class AuthController extends Controller
{
    public function login() 
    {
        return view('auth.login');
    }

    public function logout(Request $request) 
    {
        Auth::logout();
        
        return redirect(route('login'));
    }

    public function postLogin(Request $request) 
    {
        if($request->ajax()) {
            $validateData = Validator::make($request->all(), [
                'username'    => 'required',
                'password'    => 'required',
            ]);

            if ($validateData->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validateData->errors()
                ], 401);
            }

            $username = $request->username;
            $user = User::where('user_name', $username)->first();

            if($user) {
                if($request->password == $user->user_password) {

                    Auth::login($user);

                    return response()->json([
                        'success' => true,
                        'message' => 'Berhasil Login'
                    ], 200);
                }

                return response()->json([
                    'success' => false,
                    'message' => 'Password salah'
                ], 200);
            }

            return response()->json([
                'success' => false,
                'message' => 'User tidak ditemukan'
            ], 200);
        }
    }
}
