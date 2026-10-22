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
        Schema::table('modules', function (Blueprint $table) {
            $table->string('content_type')->default('markdown')->after('slug'); // 'markdown', 'pdf', 'word'
            $table->string('file_path')->nullable()->after('content');
            $table->string('file_name')->nullable()->after('file_path');
            $table->unsignedBigInteger('file_size')->nullable()->after('file_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('modules', function (Blueprint $table) {
            $table->dropColumn(['content_type', 'file_path', 'file_name', 'file_size']);
        });
    }
};
