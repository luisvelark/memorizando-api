<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->string('state_game')->nullable();
            $table->time('game_time')->nullable();
            $table->integer('hit_number')->nullable();
            $table->integer('num_attempt')->nullable();
            $table->integer('category_id')->nullable();
            $table->integer('level_id')->nullable();
            $table->integer('duration_id')->nullable();


            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};
