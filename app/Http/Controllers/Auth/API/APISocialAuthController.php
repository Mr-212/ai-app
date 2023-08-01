<?php

namespace App\Http\Controllers\Auth\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpFoundation\JsonResponse;

class APISocialAuthController extends Controller
{
    
    public function __construct()
    {
        
    }



    public function getProviderRedirect($provider){
        // dd($provider);
        return Socialite::driver($provider)->stateless()->redirect();

    }


    public function callback(Request $request, $provider){

        try{
        // dd($request->code);
            $code = $request->code;
            $user =  Socialite::driver($provider)->stateless()->user();
            dd($user);
            if($provider == User::SOCIAL_PROVIDER_GOOGLE && isset($user['email'])){
                $updatedUser = User::updateOrCreate(['email' =>   $user['email']],
                [ 
                    'name' => $user['name'], 
                    'provider_id' => $user['id'],
                    'image_url' => $user['picture'],
                    'is_social' => 1,

                    ]
                );
                if($updatedUser ){
                    $token = $updatedUser->createToken('password_grant_ai_app')->accessToken;
                    return new JsonResponse(['token' => $token->token]);
                }
            }

        }catch(Exception $e){
            // dd($e->getMessage());
            new JsonResponse(['error' => $e->getMessage(),'title' => 'Authentication Failed']);
        }
    }
}
