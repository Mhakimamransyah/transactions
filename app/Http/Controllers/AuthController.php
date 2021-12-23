<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Model\User;

class AuthController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
    }

    public function login(Request $request){

        $this->validate($request, [
            'username' => 'required|min:4|max:45',
            'password' => 'required|min:4|max:225',
        ]);

        
         $user = User::where('user_name', $request->username)->where('password',md5($request->password))->first();
         
         if ($user) {
            if (! $token = Auth::login($user)){
                  return response()->json([
                    'error' => false,
                    'message' => 'Users not found',
                ], 400);
            }

            return response()->json([
                    'data'  => $user,
                    'token' => $token,
                    'message' => 'Login Berhasil!',
                ], 200);

         } else {
            return response()->json([
                'message' => 'Username atau password salah',
            ], 400);
         }

        // return response()->json(compact('token'));

    }

    public function me()
    {
        return response()->json(auth()->user());
    } 


}
