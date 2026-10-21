<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('course_questions', function (Blueprint $table) {
            $table->string('question_type')->default('multiple_choice')->after('course_id');
            // Admin's solution code (the reference code)
            $table->text('admin_code')->nullable()->after('correct_answer');
            // Starter code template shown to user
            $table->text('starter_code')->nullable()->after('admin_code');
            // Expected console output (generated from admin's code)
            $table->text('expected_output')->nullable()->after('starter_code');
            // Rules: which constructs are ALLOWED (JSON array)
            $table->json('coding_rules')->nullable()->after('expected_output');
            // Test cases for validation (JSON array of input/output pairs)
            $table->json('test_cases')->nullable()->after('coding_rules');
            // Hint for the coding challenge
            $table->text('hint')->nullable()->after('test_cases');
            // Programming language (default: go)
            $table->string('language')->default('go')->after('hint');
        });

        // Add code_submitted column to user_answers for storing user's code
        Schema::table('user_answers', function (Blueprint $table) {
            $table->text('code_submitted')->nullable()->after('answer');
            $table->text('code_output')->nullable()->after('code_submitted');
            $table->json('rules_passed')->nullable()->after('code_output');
        });
    }

    public function down(): void
    {
        Schema::table('course_questions', function (Blueprint $table) {
            $table->dropColumn([
                'question_type', 'admin_code', 'starter_code',
                'expected_output', 'coding_rules', 'test_cases',
                'hint', 'language'
            ]);
        });

        Schema::table('user_answers', function (Blueprint $table) {
            $table->dropColumn(['code_submitted', 'code_output', 'rules_passed']);
        });
    }
};
