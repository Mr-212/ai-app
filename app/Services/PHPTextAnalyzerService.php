<?php
namespace App\Services;
Use Sentiment\Analyzer;
use App\Models\Sentiments;

class PHPTextAnalyzerService {

    private $analyzer;

    public function __construct()
    {
        $this->analyzer = new Analyzer();
        
    }

    public function generateSentiment($text){

        return $this->analyze($text);
    
      
    }

    private function analyze(string $text): Array {

        $response = [];
        $sentiment = $this->analyzer->getSentiment($text);
        if($sentiment['neg'] < $sentiment['pos'] && ($sentiment['neu'] < $sentiment['pos'] || $sentiment['neu'] < $sentiment['neg'])){
            // $response['sentiment_score'] = ;
            $response['sentiment_type']  = $sentiment['pos'];
        }else{
            // $response['sentiment_score'] = 
            $response[Sentiments::SENTIMENT_TYPE_HATE]  = $sentiment['neg'];
        }

        return $response;

    }

}