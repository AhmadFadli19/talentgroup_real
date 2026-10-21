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
        // 1. Table for AI Agent & Hosting Configurations
        Schema::create('ai_settings', function (Blueprint $table) {
            $table->id();
            $table->string('active_provider', 50)->default('gemini'); // gemini, deepseek, qwen
            $table->text('gemini_api_key')->nullable();
            $table->string('gemini_model', 100)->default('gemini-2.5-flash');
            $table->text('deepseek_api_key')->nullable();
            $table->string('deepseek_model', 100)->default('deepseek-chat');
            $table->text('qwen_api_key')->nullable();
            $table->string('qwen_model', 100)->default('qwen-max');
            $table->integer('min_passing_score')->default(75);
            $table->boolean('check_seo')->default(true);
            $table->boolean('check_performance')->default(true);
            $table->boolean('check_code_errors')->default(true);
            $table->boolean('check_best_practices')->default(true);
            $table->boolean('check_security')->default(true);
            $table->text('custom_rules_prompt')->nullable();
            $table->timestamps();
        });

        // 2. Table for User Uploaded & Hosted Prototypes
        Schema::create('prototypes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('project_name', 150);
            $table->string('slug', 150)->unique();
            $table->enum('upload_type', ['manual_files', 'zip_archive'])->default('zip_archive');
            $table->string('storage_path', 255);
            $table->string('ai_provider_used', 100)->default('gemini');
            $table->integer('ai_score')->default(0);
            $table->json('ai_report_json')->nullable();
            $table->boolean('is_approved')->default(false);
            $table->boolean('is_hosted')->default(false);
            $table->boolean('is_active')->default(true); // Admin can suspend/activate
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prototypes');
        Schema::dropIfExists('ai_settings');
    }
};
