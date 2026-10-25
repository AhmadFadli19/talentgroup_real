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
        // Add granular security controls to module_categories
        Schema::table('module_categories', function (Blueprint $table) {
            $table->boolean('enable_anti_screenshot')->default(true)->after('is_active');
            $table->boolean('enable_anti_copy')->default(true)->after('enable_anti_screenshot');
        });

        // Add granular security controls to modules
        Schema::table('modules', function (Blueprint $table) {
            $table->boolean('enable_anti_screenshot')->default(true)->after('enable_protection');
            $table->boolean('enable_anti_copy')->default(true)->after('enable_anti_screenshot');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('modules', function (Blueprint $table) {
            $table->dropColumn(['enable_anti_screenshot', 'enable_anti_copy']);
        });

        Schema::table('module_categories', function (Blueprint $table) {
            $table->dropColumn(['enable_anti_screenshot', 'enable_anti_copy']);
        });
    }
};
