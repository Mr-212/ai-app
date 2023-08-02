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
        $query = ["inputs" =>"{$text}"];
        $result =$this->curl_reequest($query, $url);
        // dd($result);
        $response = [];
        if(isset($result[0]) && !empty($result[0])){
            foreach($result[0] as $v) {
                $response[ $v["label"] ] = $v['score'];
            }
        }
        // dd($response);
        return $response;
      
    }

    public function generateText($text){
       $url = "https://api-inference.huggingface.co/models/gpt2";
       $query = ["inputs" =>"{$text}",];
        // $result =  $result->toArray();
        $result =$this->curl_reequest($query, $url);

        dd($result[0]['generated_text']);

        // if(isset($result['choices'])){
        //     $string = $result['choices'][0]['text'];
        //     return $string;
        //     // dd($result[]);
        // }

      
    }


    private function request($text){

        $query = ["inputs" =>"I like you. I love you"];
        $data = http_build_query($query);    
        $url = 'https://api-inference.huggingface.co/models/distilbert-base-uncased-finetuned-sst-2-english';
        $req = Http::withHeaders(
            ["Authorization" => "Bearer $this->api_key", "Content-Type" =>"application/x-www-form-urlencoded"])->post($url, 
            $query
        );
    
        return $req;
    }


    private function curl_reequest($query, $url){
            $ch = curl_init();
            // $query = ["inputs" =>"{$text}"];
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $query);

            $headers = array();
            $headers[] = "Authorization: Bearer $this->api_key";
            // $headers[] = "Content-Type: application/x-www-form-urlencoded";
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $result = curl_exec($ch);
            if (curl_errno($ch)) {
                echo "Error:" . curl_error($ch);
            }
            curl_close($ch);

            $result = json_decode($result,1);
            return $result;
     }

}