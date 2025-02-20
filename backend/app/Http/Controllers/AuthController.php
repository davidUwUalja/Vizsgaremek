<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function authenticate(LoginRequest $request){
        $cred = $request->validated();

        if(Auth::attempt($cred)) {
            $token = $request->user()->createToken('app');

            return response()->json([
                "data" => [
                    "token" => $token->plainTextToken
                ]
            ]);
        }
        else {
            return response()->json([
                "data" => [
                    "message" => "Sikertelen belépés"
                ]
            ], 401);
        }
    }

    public function store(StoreUserRequest $request){
        $data = $request->validated();

        $user = User::create($data);

        return response()->json([
            "data" => [
                "message" => "A(z) $user->email sikeresen regisztrált."
            ]
        ]);
    }
    /*
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => 'Validation Error',
                'message' => $validator->errors()
            ], 422);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'error' => 'Unauthorized',
                'message' => 'Invalid credentials'
            ], 401);
        }

        $token = $user->createToken('regisegek')->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'token' => $token
        ]);
    }
        
    
    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('regisegek')->plainTextToken;

        return response()->json([
            'message' => 'Registration successful',
            'token' => $token
        ], 201);
    }  
    
    */



}
