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
        Schema::create('chat_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('profile_id');
            $table->string('prompt_provider');
            $table->json('response');
            $table->boolean('is_error')->default(false);
            $table->unsignedInteger('usage_total_tokens')->default(0);
            $table->timestamps();

            $table->index('profile_id');
            $table->index(['profile_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chat_logs');
    }
};
