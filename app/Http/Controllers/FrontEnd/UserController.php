<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Models\Sentiments;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class UserController extends Controller
{
    
   

    public function __construct( private Sentiments $sentimentModel)
    {
        
    }

    public function index(){

        $love_count =  Sentiments::where('sentiment_type', Sentiments::SENTIMENT_TYPE_LOVE)->count();
        $hate_count =  Sentiments::where('sentiment_type', Sentiments::SENTIMENT_TYPE_HATE)->count();

        return new JsonResponse(['titles' => 'User Home Page','love_count' => $love_count,'hate_count' => $hate_count]);
    }
}
