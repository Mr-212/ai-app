<?php
namespace App\Services;

class OpenAIService {
    private $client, $secret;

    public function __construct($client, $secret)
    {
        $this->client = $client;
        $this->secret = $secret;
    }


    public function getConnction(){
        
    }

}