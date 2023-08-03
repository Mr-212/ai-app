<?php

namespace App\Http\Controllers\Auth\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\JsonResponse;

class APIAuthController extends Controller
{
    /* api user login
    params: email: string, password: string
    return @response
    */

    public function login(Request $request){

        try{
            if($request->has('email') && $request->has('password')){

                // $user = User::where(['email' =>  $request->email])->first();
                if(AUth::attempt($request->all())){
                    $user = Auth::user();
                    // dd($user);
                        $token = $user->createToken('AccessToken')->accessToken;
                        // dd($token);
                        return new JsonResponse(['token' => $token, 'title' =>'API Login', 'message' => $request->email. ' logged in successfully.']);
                }
                return new JsonResponse([ 'title' =>'API Login', 'message' => 'User not found or password mismatch']);
                
            }
        }catch(Exception $e){
            return new JsonResponse(['error' => $e->getMessage(), 'title' =>'Login authentication failed']);

        }
    }


    public function logout(){
        try{
            dd(Auth::user());
            if(Auth::user()){
                $user = Auth::user();
                $user->token()->revoke();
                return new JsonResponse(['message' => 'Logged out successfully']);
            }
        }catch(Exception $e){
            return new JsonResponse(['error' => $e->getMessage(), 'title' =>'Logout failed']);
        }
    }
}
