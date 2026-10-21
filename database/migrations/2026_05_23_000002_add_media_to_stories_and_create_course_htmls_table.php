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
            $table->string('image_path')->nullable()->after('content');
            $table->string('audio_path')->nullable()->after('image_path');
            $table->string('video_url')->nullable()->after('audio_path');
        });

        Schema::create('course_htmls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('content')->nullable(); // Explanatory text description
            $table->text('html_code')->nullable();
            $table->text('css_code')->nullable();
            $table->text('js_code')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('course_stories', function (Blueprint $table) {
            $table->dropColumn(['image_path', 'audio_path', 'video_url']);
        });

        Schema::dropIfExists('course_htmls');
    }
};
