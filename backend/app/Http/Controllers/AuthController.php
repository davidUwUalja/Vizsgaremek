<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name'=>$request['name'],
            'email'=>$request['email'],
            'password'=>Hash::make($request['password']),
        ]);
        return response()->json(['message' => 'Regisztráció sikeres', 'user' =>$user],201);
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('identifier','password');
        $user = User::where('email',$credentials['identifier'])   
                    ->orWhere('name',$credentials['identifier'])    
                    ->first();

        if(!$user){
            return response()->json(['message'=>'Felhasználó nem található'],404);
        }
        if(Hash::check($credentials['password'],$user->password)){
            $token = $user->createToken('auth_token')->plainTextToken;
            return response()->json(['message' =>'Sikeres bejelentkezés', 'token' =>$token],200);
        }
        return response()->json(['message'=>'Helytelen bejelentkezési adatok'],401);
    }
}
