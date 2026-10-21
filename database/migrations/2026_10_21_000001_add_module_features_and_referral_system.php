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
        // 1. Add fields to module_categories
        Schema::table('module_categories', function (Blueprint $table) {
            $table->boolean('is_public')->default(true)->after('description');
            $table->string('referral_code')->nullable()->after('is_public');
            $table->string('icon')->nullable()->default('fas fa-book')->after('referral_code');
            $table->string('color')->nullable()->default('#38bdf8')->after('icon');
            $table->string('badge')->nullable()->after('color');
        });

        // 2. Add fields to modules
        Schema::table('modules', function (Blueprint $table) {
            $table->boolean('is_public')->default(true)->after('is_published');
            $table->string('referral_code')->nullable()->after('is_public');
        });

        // 3. Create user_module_access table (for private module manual & referral unlock)
        Schema::create('user_module_access', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('category_id')->nullable()->constrained('module_categories')->onDelete('cascade');
            $table->foreignId('module_id')->nullable()->constrained('modules')->onDelete('cascade');
            $table->string('access_method')->default('admin_manual'); // admin_manual, referral_code
            $table->string('referral_code')->nullable();
            $table->foreignId('granted_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();

            $table->unique(['user_id', 'category_id', 'module_id']);
        });

        // 4. Create referral_codes table
        Schema::create('referral_codes', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('description')->nullable();
            $table->enum('discount_type', ['free', 'percentage', 'fixed'])->default('free'); // free = 100% off
            $table->decimal('discount_value', 10, 2)->default(0); // 100 for percentage/free, or nominal value
            $table->enum('target_type', ['all', 'course', 'module'])->default('all');
            $table->unsignedBigInteger('target_id')->nullable(); // course_id or category_id
            $table->integer('max_uses')->nullable(); // null = unlimited
            $table->integer('used_count')->default(0);
            $table->boolean('is_active')->default(true);
            $table->dateTime('expires_at')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });

        // 5. Create referral_code_usages table
        Schema::create('referral_code_usages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('referral_code_id')->constrained('referral_codes')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->unsignedBigInteger('course_id')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('referral_code_usages');
        Schema::dropIfExists('referral_codes');
        Schema::dropIfExists('user_module_access');

        Schema::table('modules', function (Blueprint $table) {
            $table->dropColumn(['is_public', 'referral_code']);
        });

        Schema::table('module_categories', function (Blueprint $table) {
            $table->dropColumn(['is_public', 'referral_code', 'icon', 'color', 'badge']);
        });
    }
};
