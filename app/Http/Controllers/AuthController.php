<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function login(Request $request) {
        $credentials = $request->only('email', 'password');
        if (!$token = JWTAuth::attempt($credentials)){
            return response()->json(['error'=>'Invalid Credentials'], 401);
        }
        return response()->json(['token' => $token]);
    }
    
    public function register(Request $request) {
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);
            $token = JWTAuth::fromUser($user);
            return response()->json(['user' => $user, 'token' => $token], 201);
        } catch(\Exception $e){
            return response()->json(['message' => 'registrasi gagal', 'error'=>$e->getMessage()],500);
        }
    }


}
