<?php

namespace App\Http\Controllers\API\AI;

use App\Http\Controllers\Controller;
use App\Models\Sentiments;
use App\Services\GoogleNLPService;
use App\Services\HuggingFaceService;
use App\Services\OpenAIService;
use Illuminate\Http\Request;

use App\Services\PHPTextAnalyzerService;
use Illuminate\Http\JsonResponse;

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
            $sentiment = $this->phpSentimentAnalyzer->generateSentiment($request->text);
            $sentiment = $this->hugginfFaceService->generateSentiment($request->text);
            $responseText = $this->openAIService->generateText($request->text);
            // dd($responseText ,str_replace(array("\n","\r\n","\r"), '',$responseText));
            $record = $this->sentimentModel::create([
                'comment_asked' => $request->get('text'),
                'request_type' => $this->sentimentModel::REQUEST_TYPE_LOVE,
                'user_id' => 1,
                'ai_source' => $this->sentimentModel::AI_SOIRCE_OPENAI,
                'sentiment_score' => $sentiment['sentiment_score'],
                'sentiment_type' => $sentiment['sentiment_type'],
                'response_text' => $responseText
            ]);

            // dd($record);
            // $response = $this->googleNLPService->generateSentiment($request->text);
            // $record->api_response = json_encode($response);
            
            dd($record);
            // $response = $this->hugginfFaceService->generateText($request->text);
            return new JsonResponse(['titles' => 'AI Response' , 'responseText' => $responseText,'sentiment' => $record->sentiment_type]);
        }
    }

}

