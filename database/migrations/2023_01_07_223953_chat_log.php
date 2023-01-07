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
        Schema::create('chat_log', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('profile_id');
            $table->string('provider_prompt');
            $table->string('response_id');
            $table->json('response');
            $table->unsignedInteger('usage_prompt_tokens');
            $table->unsignedInteger('usage_completion_tokens');
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
        Schema::dropIfExists('chat_log');
    }
};
