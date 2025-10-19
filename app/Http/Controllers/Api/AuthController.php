<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request) {
        $user = User::where('email', $request->email)->first();

        if (Hash::check($request->password, $user->password)) {
            $token = $user->createToken('auth-token');

            return response()->json([
                'user' => $user,
                'token' => $token
            ]);
        }

        return response()->json([
            'message' => 'email or password not correct'
        ]);
    }

    public function register(Request $request) {
        $validated = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        if($validated->fails()){
            return response()->json([
                'errors' => $validated->errors()
            ]);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        return response()->json([
            'user' => $user,
            'message' => 'you register successfully, now you can sign in'
        ]);
    }

    public function profile() {
        $user = auth()->user();

        return response()->json([
            'user' => $user
        ]);
    }

    public function logout(){
        $user = auth()->user();

        $user->tokens()->delete();

        return response()->json([
            'message' => 'you logout successfully'
        ]);
    }
}
