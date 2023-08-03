<?php
namespace App\Services;
use OpenAI\Laravel\Facades\OpenAI;

class OpenAIService {

    private $chatgptModel;

    public function __construct()
    {
        $this->chatgptModel = 'ada';
    }

    public function generateText($text){

        $result = OpenAI::completions()->create([
            'model' => $this->chatgptModel,
            'prompt' => $text,
        ]);

        if(isset($result['choices'])){
            $string = $result['choices'][0]['text'];
            return $string;        }
    }

}