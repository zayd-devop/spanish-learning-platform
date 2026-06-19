<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('week_id')->constrained()->onDelete('cascade');
            $table->text('text_answer')->nullable();
            $table->string('audio_path')->nullable();
            $table->integer('evaluation_score')->nullable();
            $table->text('evaluation_feedback')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('submissions');
    }
};
