<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use JWTAuth;

class TokenContoller extends Controller
{
    public function auth (Request $request) {
        $credentials = $request->only('email','password');

        $validator = Validator::make($credentials, [
            'email'=> 'required|email',
            'password'=> 'required'
        ]);

        if($validator->fails()) {
            return response()->json([
                'code' => 1,
                'message' => 'Validation failed.',
                'errors' => $validator->errors()
            ], 422);
        }

        $token = JWTAuth::attempt($credentials);

        if($token) {
            return response()->json(['token' => $token]);
        } else {
            return response()->json(['code' => 2, 'message' => 'Invalid Token']);            
        }
    }
    
    public function refresh() {
        $token = JWTAuth::getToken();
        try {
            $token = JWTAuth::refresh($token);
            return response()->json(['token' => $token]);
        } catch (TokenExpiredException $e) {
            throw new HttpResponseException (
                Response::json(['msg' => "Need to Login Again"])
            );
        }
    }

    public function invalidate() {
        $token = JWTAuth::getToken();
        try {
            $token = JWTAuth::invalidate($token);
            return response()->json(['token' => $token]);
        } catch (Exception $e) {
            
        }
    }
}
