<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    private const COURSE_TITLE = 'Quiz dasar HTML dan CSS';

    public function up(): void
    {
        DB::table('courses')
            ->where('title', self::COURSE_TITLE)
            ->delete();
    }

    public function down(): void
    {
        // Data course dan relasinya tidak dapat direkonstruksi dengan aman.
    }
};
