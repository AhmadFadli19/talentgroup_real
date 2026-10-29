<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Hapus pendaftaran lama yang menunjuk ke course yang sudah tidak ada.
        DB::table('user_courses')
            ->whereNotExists(function ($query) {
                $query->selectRaw('1')
                    ->from('courses')
                    ->whereColumn('courses.id', 'user_courses.course_id');
            })
            ->delete();
    }

    public function down(): void
    {
        // Relasi yatim tidak dapat dipulihkan tanpa data course asalnya.
    }
};
