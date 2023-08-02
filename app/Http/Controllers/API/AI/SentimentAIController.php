<?php

namespace App\Http\Controllers\API\AI;

use App\Http\Controllers\Controller;
use App\Models\Sentiments;
use App\Services\GoogleNLPService;
use App\Services\HuggingFaceService;
use App\Services\OpenAIService;
use Illuminate\Http\Request;
Use Sentiment\Analyzer;



class SentimentAIController extends Controller
{
    //
    private $openAIService, $googleNLPService, $sentimentModel, $analyzer, $hugginfFaceService;


    public function __construct(Sentiments $sentiment)
    {
        $this->sentimentModel = $sentiment;
        $this->openAIService = new OpenAIService();
        $this->googleNLPService = new GoogleNLPService();
        // dd(env('HUGGING_FACE_API_KEY'));
        $this->hugginfFaceService = new HuggingFaceService('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');
        $this->analyzer = new Analyzer();

        
    }


    public function generate(Request $request){
        // dd($request->all());
        
        if($request->has('text')){
            $sentiment = $this->analyze($request->text);
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
            $response = $this->openAIService->generateSentiment($request->text);
            // $response = $this->hugginfFaceService->generateSentiment($request->text);
            // $response = $this->hugginfFaceService->generateText($request->text);


            dd($response);
        }
    }


    private function analyze(string $text): Array {

        $response = [];
        $sentiment = $this->analyzer->getSentiment($text);
        if($sentiment['neg'] < $sentiment['pos'] && ($sentiment['neu'] < $sentiment['pos'] || $sentiment['neu'] < $sentiment['neg'])){
            $response['sentiment_score'] = $sentiment['pos'];
            $response['sentiment_type']  = $this->sentimentModel::SENTIMENT_TYPE_LOVE;
        }else{
            $response['sentiment_score'] = $sentiment['neu'];
            $response['sentiment_type']  = $this->sentimentModel::SENTIMENT_TYPE_NEUTRAL;
        }

        return $response;

    }

}
