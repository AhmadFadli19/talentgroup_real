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
        Schema::table('module_categories', function (Blueprint $table) {
            if (!Schema::hasColumn('module_categories', 'image')) {
                $table->string('image')->nullable()->after('referral_code');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('module_categories', function (Blueprint $table) {
            if (Schema::hasColumn('module_categories', 'image')) {
                $table->dropColumn('image');
            }
        });
    }
};
