<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    //

    public function __construct()
    {
        
    }



    public function getProviderRedirect($provider){

        // dd($provider);

        return Socialite::driver($provider)->redirect();

    }
}
