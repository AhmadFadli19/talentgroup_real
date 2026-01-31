<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Pastikan tidak ada duplikasi jika kolom sudah ada sebelumnya
            if (!Schema::hasColumn('users', 'github_id')) {
                $table->string('github_id')->nullable()->after('google_id');
            }
            if (!Schema::hasColumn('users', 'github_username')) {
                $table->string('github_username')->nullable()->after('github_id');
            }
            // avatar column sudah ada dari Google implementation
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'github_id')) {
                $table->dropColumn('github_id');
            }
            if (Schema::hasColumn('users', 'github_username')) {
                $table->dropColumn('github_username');
            }
        });
    }
};