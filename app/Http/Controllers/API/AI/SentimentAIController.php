<?php

namespace App\Http\Controllers\API\AI;

use App\Http\Controllers\Controller;
use App\Services\GoogleNLPService;
use App\Services\OpenAIService;
use Illuminate\Http\Request;



class SentimentAIController extends Controller
{
    //
    private $openAIService, $googleNLPService;


    public function __construct()
    {
        $this->openAIService = new OpenAIService();
        $this->googleNLPService = new GoogleNLPService();

        
    }


    public function generate(Request $request){
        // dd($request->all());
        
        if($request->has('text')){
            $response = $this->googleNLPService->generate($request->text);
            dd($response);
            $response = $this->openAIService->generate($request->text);
        }
    }

}
