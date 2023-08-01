<?php
namespace App\Services;
use OpenAI\Laravel\Facades\OpenAI;

class OpenAIService {
    private $chatgptModel;

    public function __construct()
    {
        $this->chatgptModel = 'gpt-3.5-turbo';
    }


    public function getConnction(){

    }


    public function generate($text){
        $result = OpenAI::completions()->create([
            'model' => $this->chatgptModel,
            'prompt' => $text,
        ]);

        dd($result);
    }

}