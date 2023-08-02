<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sentiments extends Model
{
    use HasFactory;

    const SENTIMENT_TYPE_HATE = 'HATE';
    const SENTIMENT_TYPE_LOVE = 'LOVE';

    const AI_SOURCE_GOOGLE_NLP = 'GOOGLE NATURAL LANGUAGE';
    const AI_SOIRCE_OPENAI = 'OPEN AI';

    protected $table = 'sentiments';
    protected $fillable = ['user_id','type','api_response','comment_asked','ai_response','ai_source','sentiment_type','sentiment_score'];


    public function user(){
        return $this->hasOne(User::class);
    }

}
