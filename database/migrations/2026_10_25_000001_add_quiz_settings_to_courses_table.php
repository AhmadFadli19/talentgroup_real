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
        Schema::table('courses', function (Blueprint $table) {
            $table->string('quiz_answer_visibility')->default('end')->after('is_active');
            $table->string('quiz_navigation_mode')->default('free')->after('quiz_answer_visibility');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn(['quiz_answer_visibility', 'quiz_navigation_mode']);
        });
    }
};
