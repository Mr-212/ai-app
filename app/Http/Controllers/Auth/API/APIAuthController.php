<?php

namespace App\Http\Controllers\Auth\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\JsonResponse;

class APIAuthController extends Controller
{
    //

    public function login(Request $request){
        // dd($request->all());

        try{
            if($request->has('email') && $request->has('password')){

                $user = User::where(['email' =>  $request->email])->first();
                $auth = auth()->attempt($request->all());
                if($user && $auth){
                        $token = $user->createToken('auth_login_passport_token')->accessToken;
                        return new JsonResponse(['token' => $token->token, 'title' =>'API Login', 'message' => $request->email. ' logged in successfully.']);
                }
                return new JsonResponse([ 'title' =>'API Login', 'message' => 'User not found or password mismatch']);
                
            }
        }catch(Exception $e){
            return new JsonResponse(['error' => $e->getMessage(), 'title' =>'Login authentication failed']);

        }
    }
}
