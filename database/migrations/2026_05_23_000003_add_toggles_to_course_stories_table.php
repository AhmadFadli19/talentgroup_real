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
        Schema::table('course_stories', function (Blueprint $table) {
            $table->boolean('use_image')->default(false)->after('video_url');
            $table->boolean('use_audio')->default(false)->after('use_image');
            $table->boolean('use_video')->default(false)->after('use_audio');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('course_stories', function (Blueprint $table) {
            $table->dropColumn(['use_image', 'use_audio', 'use_video']);
        });
    }
};
