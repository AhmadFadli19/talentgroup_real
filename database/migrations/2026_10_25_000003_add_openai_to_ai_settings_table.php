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
        if (Schema::hasTable('ai_settings')) {
            Schema::table('ai_settings', function (Blueprint $table) {
                if (!Schema::hasColumn('ai_settings', 'openai_api_key')) {
                    $table->text('openai_api_key')->nullable()->after('active_provider');
                }
                if (!Schema::hasColumn('ai_settings', 'openai_model')) {
                    $table->string('openai_model', 100)->default('gpt-4o-mini')->after('openai_api_key');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('ai_settings')) {
            Schema::table('ai_settings', function (Blueprint $table) {
                if (Schema::hasColumn('ai_settings', 'openai_api_key')) {
                    $table->dropColumn('openai_api_key');
                }
                if (Schema::hasColumn('ai_settings', 'openai_model')) {
                    $table->dropColumn('openai_model');
                }
            });
        }
    }
};
