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
        Schema::table('transactions', function (Blueprint $table) {
            $table->unsignedBigInteger('processed_by')->nullable()->after('description');
            $table->timestamp('processed_at')->nullable()->after('processed_by');
            $table->text('bank_notes')->nullable()->after('processed_at');
            $table->text('failure_reason')->nullable()->after('bank_notes');
            $table->json('metadata')->nullable()->after('failure_reason');
            $table->string('reference_number')->nullable()->after('metadata');
            $table->decimal('fee_amount', 10, 2)->default(0)->after('reference_number');
            $table->decimal('net_amount', 10, 2)->nullable()->after('fee_amount');
            
            $table->foreign('processed_by')->references('id')->on('users')->onDelete('set null');
            $table->index(['status', 'type']);
            $table->index(['user_id', 'status']);
            $table->index(['processed_by']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign(['processed_by']);
            $table->dropIndex(['status', 'type']);
            $table->dropIndex(['user_id', 'status']);
            $table->dropIndex(['processed_by']);
            $table->dropColumn([
                'processed_by',
                'processed_at',
                'bank_notes',
                'failure_reason',
                'metadata',
                'reference_number',
                'fee_amount',
                'net_amount'
            ]);
        });
    }
};