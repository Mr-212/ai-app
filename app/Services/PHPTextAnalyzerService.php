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
            $response['sentiment_score'] = $sentiment['pos'];
            $response['sentiment_type']  = Sentiments::SENTIMENT_TYPE_LOVE;
        }else{
            $response['sentiment_score'] = $sentiment['neu'];
            $response['sentiment_type']  = Sentiments::SENTIMENT_TYPE_HATE;
        }

        return $response;

    }

}