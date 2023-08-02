<?php
namespace App\Services;
use OpenAI\Laravel\Facades\OpenAI;

class OpenAIService {
    private $chatgptModel;

    public function __construct()
    {
        $this->chatgptModel = 'gpt-3.5-turbo';
    }



    public function generateSentiment($text){
        $result = OpenAI::completions()->create([
            'model' => $this->chatgptModel,
            'prompt' => $text,
        ]);

        dd($result);

        if(isset($result['choices'])){
            $string = $result['choices'][0]['text'];
            return $string;
            // dd($result[]);
        }

      
    }

}