<?php

namespace App\Http\Controllers\API\AI;

use App\Http\Controllers\Controller;
use App\Models\Sentiments;
use App\Services\GoogleNLPService;
use App\Services\OpenAIService;
use Illuminate\Http\Request;



class SentimentAIController extends Controller
{
    //
    private $openAIService, $googleNLPService, $sentimentModel;


    public function __construct(Sentiments $sentiment)
    {
        $this->sentimentModel = $sentiment;
        $this->openAIService = new OpenAIService();
        $this->googleNLPService = new GoogleNLPService();

        
    }


    public function generate(Request $request){
        // dd($request->all());
        
        if($request->has('text')){

            $record = $this->sentimentModel::create([
                'comment_asked' => $request->get('text'),
                'type' => $this->sentimentModel::SENTIMENT_TYPE_LOVE,
                'user_id' => 1,
                'ai_source' => $this->sentimentModel::AI_SOIRCE_OPENAI,
            ]);

            // $response = $this->googleNLPService->sentiment($request->text);
            // $record->api_response = json_encode($response);
            $response = $this->openAIService->sentiment($request->text);

            dd($response);
        }
    }

}
