<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{

    public function getUser($id)
    {
        $user = User::where('id_user', $id)->first();

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        return response()->json([
         
            'firstname' => $user->firstname,
            'lastname' => $user->lastname,
            'username' => $user->username,
            'storename' => $user->storename,
            
        ]);
    }
    public function register(Request $request)
    {
        $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            
            'password' => ['required', Password::min(8)->mixedCase()->numbers()],
        ]);

        $user = new User();
  
        $user->id_user = Str::random(15);
        $user->firstname = $request->input('firstname');
        $user->lastname = $request->input('lastname');
        $user->username = $request->input('username');
        $user->email = $request->input('email');
        $user->password = $request->input('password');
        $user->save();

        return response()->json([
            'message' => 'User registered successfully',
        ]);
    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        $user = User::where('email', $request->input('email'))->first();
    
        if (!$user || !Hash::check($request->input('password'), $user->password)) {
            return response()->json([
                'message' => 'Invalid email or password',
            ], 401);
        }
    
        $token = $user->createToken('auth_token');
    
        return response()->json([
            'access_token' => $token->plainTextToken,
            'token_type' => 'Bearer',
            'current_user' => $user->username,
          
        ]);
    }
}