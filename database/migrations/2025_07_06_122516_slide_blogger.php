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
        Schema::create('slideblogger', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('image');
            $table->text('blog_author')->nullable();
            $table->text('description')->nullable();
            $table->string('create_view')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('slideblogger');
    }
};
