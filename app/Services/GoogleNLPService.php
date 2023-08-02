<?php
namespace App\Services;

use Exception;
use Google\Cloud\Language\LanguageClient;
// use JoggApp\NaturalLanguage\NaturalLanguageFacade;
// use JoggApp\NaturalLanguage\NaturalLanguage;
// use JoggApp\NaturalLanguage\NaturalLanguageClient;

use Illuminate\Support\Facades\Config;
use Google\Cloud\Core\ServiceBuilder;

// use JoggApp\NaturalLanguage\NaturalLanguage;

class GoogleNLPService {
    protected $nlp, $client;



    public function __construct()
    {
        // dd(Config::get('naturallanguage'));
        

        // $this->nlp = new NaturalLanguage(new NaturalLanguageClient(Config::get('naturallanguage')));
        // $this->client = new LanguageClient(['KeyFile' => Config::get('naturallanguage.keyfile'),'ProjectId' => Config::get('naturallanguage.project')]);
        $this->client = new ServiceBuilder(['keyFilePath' => Config::get('naturallanguage.keyfile'),'ProjectId' => Config::get('naturallanguage.project')]);


    }


    public function getConnction(){

    }


    public function sentiment($text){
        try{
        // $sentiment = $this->nlp->entitySentiment('AI is rocking');
        // $sentiment = NaturalLanguageFacade::sentiment($text);
        $language = $this->client->language();
        $sentiment =$language->analyzeSentiment($text);
        dd($sentiment);
        }catch(Exception $e){
            dd($e->getMessage());
        }
       
    }

}