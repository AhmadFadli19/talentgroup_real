<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Migrate story content
        DB::statement("
            INSERT INTO course_stories (course_id, title, content, `order`, created_at, updated_at)
            SELECT course_id, title, content, `order`, created_at, updated_at
            FROM course_contents
            WHERE type = 'story'
        ");

        // Migrate question content
        DB::statement("
            INSERT INTO course_questions (course_id, title, content, options, correct_answer, `order`, created_at, updated_at)
            SELECT course_id, title, content, options, correct_answer, `order`, created_at, updated_at
            FROM course_contents
            WHERE type = 'question'
        ");

        // Change current_content_id column type from integer to string
        Schema::table('user_courses', function (Blueprint $table) {
            $table->string('current_content_id')->default('')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert column type change
        Schema::table('user_courses', function (Blueprint $table) {
            $table->integer('current_content_id')->default(1)->change();
        });

        // Clear the new tables
        DB::table('course_stories')->truncate();
        DB::table('course_questions')->truncate();
    }
};
