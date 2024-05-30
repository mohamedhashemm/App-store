<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;

class AccessTokensController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            "email"=>"required|email|max:255",
            "password"=>"required|string|min:6",
            "device_name"=>"string|max:255"

        ]);
        $user= User::where('email',$request->email)->first();
        if($user && Hash::check($request->password,$user->password)){

            $device_name= $request->post('device_name',$request->userAgent());
            $token= $user->createToken($device_name);
            return response()->json([
                'code'=>1,
                'token'=>$token->plainTextToken,
                'user'=>$user

            ],201);

        }
        return response()->json([
            'code'=>0,
            'message'=>'Invalid credentials',
            

        ],401);

    }

    public function destroy($token= null){

        $user= Auth::guard('sanctum')->user();
        if(null === $token){
            $user->currentAccessToken()->delete();
            return;

        }

        $personelAccessToken = PersonalAccessToken::findToken($token);
        if(
            $user->id == $personelAccessToken->tokenable_id &&
            get_class($user) == $personelAccessToken->tokenable_type
        ){
            $personelAccessToken->delete();

        }
    }
}
