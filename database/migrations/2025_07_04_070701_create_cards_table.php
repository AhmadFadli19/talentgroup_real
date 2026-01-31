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
        Schema::create('cards', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('price')->nullable();
            $table->string('create_view')->unique(); // ini pengganti buy_link
            $table->string('image');
            $table->boolean('best_seller')->default(false);
            $table->enum('certificate', ['ya', 'tidak'])->default('tidak');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cards');
    }
};
