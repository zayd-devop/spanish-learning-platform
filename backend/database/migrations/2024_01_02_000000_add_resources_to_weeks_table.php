<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('weeks', function (Blueprint $table) {
            $table->json('source_links')->nullable();
            $table->json('video_links')->nullable();
            $table->json('books')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('weeks', function (Blueprint $table) {
            $table->dropColumn(['source_links', 'video_links', 'books']);
        });
    }
};
