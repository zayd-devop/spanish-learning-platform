<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('weeks', function (Blueprint $table) {
            $table->dropUnique('weeks_week_number_unique');
            $table->string('path')->default('standard');
            $table->unique(['path', 'week_number']);
        });
    }

    public function down(): void
    {
        Schema::table('weeks', function (Blueprint $table) {
            $table->dropUnique(['path', 'week_number']);
            $table->dropColumn('path');
            $table->unique('week_number');
        });
    }
};
