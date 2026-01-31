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
        Schema::create('card_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('card_id')->constrained()->onDelete('cascade');
            $table->string('image')->nullable();
            $table->string('judul');
            $table->text('topic')->nullable();
            $table->string('url_kelas')->nullable();
            $table->string('jam_kelas')->nullable();
            $table->string('judul_description')->nullable();
            $table->text('description_kelas')->nullable();
            $table->text('target')->nullable();
            $table->text('sasaran')->nullable();
            $table->text('metode_pembelajaran')->nullable();
            $table->string('materi_pembelajaran')->nullable();
            $table->string('persiapan_pembelajaran')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('card_details');
    }
};
