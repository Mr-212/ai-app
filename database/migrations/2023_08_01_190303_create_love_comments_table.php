<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sentiments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->enum('request_type',['LOVE','HATE']);
            $table->text('comment_asked')->nullable();
            $table->text('response_text')->nullable();
            $table->json('api_response')->nullable();
            $table->enum('sentiment_type',['POSITIVE','NEGATIVE', 'NEUTRAL']);
            $table->decimal('sentiment_score')->default(0.00);
            $table->string('ai_source')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('love_comments');
    }
};
