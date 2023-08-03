<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use Kambo\Huggingface\Huggingface;
use Kambo\Huggingface\Enums\Type;

class HuggingFaceService {
    private $chatgptModel, $client, $api_key;

    public function __construct($api_key)
    {
        //gpt2
        $this->api_key= $api_key;
        $this->client = Huggingface::client($api_key);
    }

    public function generateSentiment($text){
        $url = 'https://api-inference.huggingface.co/models/distilbert-base-uncased-finetuned-sst-2-english';

        $headers[] = "Authorization: Bearer $this->api_key";
        $headers[] = "Content-Type: application/x-www-form-urlencoded";

        $query = ["inputs" =>"{$text}"];
        $result =$this->curl_reequest($query, $url, $headers);
        // dd($result);
        $response = [];
        if(isset($result[0]) && !empty($result[0])){
            foreach($result[0] as $v) {
                $response[ 'sentiment_type' ]  = $v['label'];
                $response[ 'sentiment_score' ] = $v['score'];

            }
        }
        // dd($response);
        return $response;
      
    }

    public function generateText($text){
        $url = "https://api-inference.huggingface.co/models/gpt2";

        $headers[] = "Authorization: Bearer $this->api_key";
        $headers[] = "Content-Type: application/x-www-form-urlencoded";

        $query = ["inputs" =>"{$text}","max_length"=>1000];
        $result =$this->curl_reequest(json_encode($query,1), $url, $headers);
        dd($result);
        dd($result[0]['generated_text']);
      
    }

    public function generateText1($text){
        
        $response = $this->client->inference()->create([
            'model' => 'distilgpt2',
            'inputs' => "{$text}",
            'type' => Type::TEXT_GENERATION,
            'max_length' => 1000,
            'min_length' => 200
        ]);

        dd($response['generated_text']);
      
    }


    private function request($text){

        $query = ["inputs" =>"I like you. I love you"];
        $data = http_build_query($query);    
        $url = 'https://api-inference.huggingface.co/models/distilbert-base-uncased-finetuned-sst-2-english';

        $res = Http::withHeaders([
                "Authorization" => "Bearer $this->api_key", 
                "Content-Type" =>"application/x-www-form-urlencoded"
                ])->post($url, $query);
    
        return $res;
    }


    private function curl_reequest($query, $url, $headers){

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
            $headers = array();
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $result = curl_exec($ch);
            if (curl_errno($ch)) {
                echo "Error:" . curl_error($ch);
            }
            curl_close($ch);
            
            // dd($result);
            $result = json_decode($result,1);
            return $result;
     }

}