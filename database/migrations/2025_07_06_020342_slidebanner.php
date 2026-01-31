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
        Schema::create('slidebanner', function (Blueprint $table) {
            $table->id();
            $table->string('judul')->nullable();
            $table->string('topic')->nullable();
            $table->string('image');
            $table->string('url_kelas')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('slidebanner');
    }
};
