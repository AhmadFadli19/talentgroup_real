<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasColumn('user_answers', 'course_content_id')) {
            try {
                Schema::table('user_answers', function (Blueprint $table) {
                    $table->dropForeign(['course_content_id']);
                });
            } catch (Exception $e) {
                // Foreign key doesn't exist, continue
            }

            try {
                Schema::table('user_answers', function (Blueprint $table) {
                    $table->dropUnique(['user_id', 'course_content_id']);
                });
            } catch (Exception $e) {
                // Unique constraint doesn't exist, continue
            }

            Schema::table('user_answers', function (Blueprint $table) {
                $table->string('course_content_id')->change();
                $table->renameColumn('course_content_id', 'content_reference');
            });
        }

        Schema::table('user_answers', function (Blueprint $table) {
            if (!Schema::hasColumn('user_answers', 'content_type')) {
                $table->string('content_type')->after('content_reference')->nullable();
            }
            if (!Schema::hasColumn('user_answers', 'content_id')) {
                $table->unsignedBigInteger('content_id')->after('content_type')->nullable();
            }
        });

        try {
            Schema::table('user_answers', function (Blueprint $table) {
                $table->index(['content_type', 'content_id']);
                $table->index(['user_id', 'content_type', 'content_id']);
                $table->unique(['user_id', 'content_type', 'content_id']);
            });
        } catch (Exception $e) {
            // Indexes or unique constraint might already exist
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        try {
            Schema::table('user_answers', function (Blueprint $table) {
                $table->dropUnique(['user_id', 'content_type', 'content_id']);
            });
        } catch (Exception $e) {
            // Unique constraint doesn't exist, continue
        }

        try {
            Schema::table('user_answers', function (Blueprint $table) {
                $table->dropIndex(['content_type', 'content_id']);
                $table->dropIndex(['user_id', 'content_type', 'content_id']);
            });
        } catch (Exception $e) {
            // Indexes don't exist, continue
        }

        Schema::table('user_answers', function (Blueprint $table) {
            if (Schema::hasColumn('user_answers', 'content_type')) {
                $table->dropColumn('content_type');
            }
            if (Schema::hasColumn('user_answers', 'content_id')) {
                $table->dropColumn('content_id');
            }
        });

        if (Schema::hasColumn('user_answers', 'content_reference')) {
            Schema::table('user_answers', function (Blueprint $table) {
                $table->renameColumn('content_reference', 'course_content_id');
            });

            Schema::table('user_answers', function (Blueprint $table) {
                $table->unsignedBigInteger('course_content_id')->change();
            });

            try {
                Schema::table('user_answers', function (Blueprint $table) {
                    $table->foreign('course_content_id')->references('id')->on('course_contents')->onDelete('cascade');
                });
            } catch (Exception $e) {
                // Foreign key constraint failed, continue
            }
        }
    }
};