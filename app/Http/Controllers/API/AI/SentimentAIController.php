<?php

namespace App\Http\Controllers\API\AI;

use App\Http\Controllers\Controller;
use App\Models\Sentiments;
use App\Services\GoogleNLPService;
use App\Services\HuggingFaceService;
use App\Services\OpenAIService;
use Illuminate\Http\Request;

use App\Services\PHPTextAnalyzerService;



class SentimentAIController extends Controller
{
    //
    private $openAIService, $googleNLPService, $sentimentModel, $phpSentimentAnalyzer, $hugginfFaceService;


    public function __construct(Sentiments $sentiment)
    {
        $this->sentimentModel = $sentiment;
        $this->openAIService = new OpenAIService();
        $this->googleNLPService = new GoogleNLPService();
        // dd(env('HUGGING_FACE_API_KEY'));
        $this->hugginfFaceService = new HuggingFaceService('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');
        $this->phpSentimentAnalyzer = new PHPTextAnalyzerService();
        
    }


    public function generate(Request $request){
        // dd($request->all());
        
        if($request->has('text')){
            $sentiment = $this->phpSentimentAnalyzer($request->text);
            // dd($sentiment);
            // $record = $this->sentimentModel::create([
            //     'comment_asked' => $request->get('text'),
            //     'type' => $this->sentimentModel::SENTIMENT_TYPE_LOVE,
            //     'user_id' => 1,
            //     'ai_source' => $this->sentimentModel::AI_SOIRCE_OPENAI,
            //     'sentiment_score' => $sentiment['sentiment_score'],
            //     'sentiment_type' => $sentiment['sentiment_type'],
            // ]);

            // dd($record);
            // $response = $this->googleNLPService->generateSentiment($request->text);
            // $record->api_response = json_encode($response);
            $response = $this->openAIService->generateText($request->text);
            // $response = $this->hugginfFaceService->generateSentiment($request->text);
            // $response = $this->hugginfFaceService->generateText($request->text);


            dd($response);
        }
    }

}

