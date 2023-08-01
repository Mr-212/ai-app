<?php

namespace App\Http\Controllers\API\AI;

use App\Http\Controllers\Controller;
use App\Services\OpenAIService;
use Illuminate\Http\Request;
use OpenAI\Laravel\Facades\OpenAI;


class OpenAIController extends Controller
{
    //
    private $openAIService;


    public function __construct()
    {
        $this->openAIService = new OpenAIService();
        
    }


    public function generate(Request $request){
        // dd($request->all());
        
        if($request->has('text')){
            $this->openAIService->generate($request->text);
        }
    }

}
