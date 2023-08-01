<?php

namespace App\Http\Controllers\API\AI;

use App\Http\Controllers\Controller;
// use App\Services\OpenAIService;
use Illuminate\Http\Request;
use OpenAI\Laravel\Facades\OpenAI;


class OpenAIController extends Controller
{
    //
    private $chatgptModel;

    public function __construct()
    {
        //$this->openAiService = new OpenAIService(env('OPENAI_CLIENT'), env('OPENAI_SECRET'));
        // $this->chatgptModel = 'gpt-3.5-turbo';
        // $this->chatgptModel = 'text-davinci-003';
        $this->chatgptModel = 'ada';


    }


    public function generate(Request $request){
        // dd($request->all());
        
        if($request->has('text')){
            $result = OpenAI::completions()->create([
                'model' => $this->chatgptModel,
                'prompt' => $request->text,
            ]);

            dd($result);
        }
    }

}
