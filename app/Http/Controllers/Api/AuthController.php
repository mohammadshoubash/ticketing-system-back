<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request) {
        $validated = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        if($validated->fails()){
            response()->json([
                'errors' => $validated->errors()
            ]);
        }

        $user = User::where('email', $request->email)->first();

        if(!$user){
            return response()->json([
                'message' => 'user not found'
            ]);
        }

        if (Hash::check($request->password, $user->password)) {
            $token = $user->createToken('auth-token');

            return response()->json([
                'user' => $user,
                'token' => $token
            ]);
        } else {
            return response()->json([
                'message' => 'password not correct'
            ]);
        }

        return response()->json([
            'message' => 'something went wrong while signing in'
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

    public function removeTokens(){
        try {
            \Laravel\Sanctum\PersonalAccessToken::truncate();

            return response()->json([
                'message' => 'tokens deleted successfully'
            ]);
        } catch(\Exception $e) {
            response()->json([
                'message' => $e->getMessage()
            ]);
        }
    }
}
