<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('course_questions', function (Blueprint $table) {
            $table->string('difficulty', 20)->default('beginner')->after('question_type');
            $table->index(['course_id', 'difficulty', 'order'], 'course_questions_level_order_index');
        });
    }

    public function down(): void
    {
        Schema::table('course_questions', function (Blueprint $table) {
            $table->dropIndex('course_questions_level_order_index');
            $table->dropColumn('difficulty');
        });
    }
};
