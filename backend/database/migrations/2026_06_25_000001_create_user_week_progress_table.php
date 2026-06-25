<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_week_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('week_id')->constrained()->onDelete('cascade');
            $table->boolean('is_completed')->default(false);
            $table->json('task_progress')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'week_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_week_progress');
    }
};
