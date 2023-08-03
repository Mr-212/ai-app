<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sentiments extends Model
{
    use HasFactory;

    const REQUEST_TYPE_HATE = 'HATE';
    const REQUEST_TYPE_LOVE = 'LOVE';
    // const SENTIMENT_TYPE_NEUTRAL = 'NEUTRAL';


    const SENTIMENT_TYPE_HATE = 'NEGATIVE';
    const SENTIMENT_TYPE_LOVE = 'POSITIVE';
    const SENTIMENT_TYPE_NEUTRAL = 'NEUTRAL';


    const AI_SOURCE_GOOGLE_NLP = 'GOOGLE NATURAL LANGUAGE';
    const AI_SOIRCE_OPENAI = 'OPEN AI';

    protected $table = 'sentiments';
    protected $fillable = ['user_id','request_type','api_response','comment_asked','response_text','ai_source','sentiment_type','sentiment_score'];


    public function user(){
        return $this->hasOne(User::class);
    }

}
