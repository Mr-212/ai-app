<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sentiments extends Model
{
    use HasFactory;

    protected $table = 'sentiments';

    protected $fillables = ['user_id','type','api_response','comment_asked','ai_response','api_source','sentiment_type','sentiment_score']

}
