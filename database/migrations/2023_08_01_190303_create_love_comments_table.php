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
        Schema::create('comments_analysis', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id');
            $table->enum('type',['LOVE','HATE']);
            $table->text('comment_asked')->nullable();
            $table->text('ai_response')->nullable();
            $table->json('api_response')->nullable();
            $table->enum('sentiment',['POSITIVE','NEGETIVE', 'NEUTRAL']);
            $table->decimal('sentiment_score')->default(0.00);
            $table->string('api_source')->nullable();
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
