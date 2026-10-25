<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\CourseStory;
use App\Models\CourseHtml;
use App\Models\CourseQuestion;
use App\Models\CourseVideo;
use App\Models\Module;
use App\Models\ModuleCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ComprehensiveWebDevCoursesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Nonaktifkan pemeriksaan foreign key sementara untuk truncate yang bersih
        Schema::disableForeignKeyConstraints();

        $this->command->info('Membersihkan data kursus, modul, dan soal lama...');
        CourseQuestion::truncate();
        CourseStory::truncate();
        CourseHtml::truncate();
        CourseVideo::truncate();
        Course::truncate();

        Module::truncate();
        ModuleCategory::truncate();

        Schema::enableForeignKeyConstraints();

        $this->command->info('Menjalankan Seeder Kursus HTML5 Komprehensif...');
        $this->call(HtmlCourseSeeder::class);

        $this->command->info('Menjalankan Seeder Kursus CSS3 Komprehensif...');
        $this->call(CssCourseSeeder::class);

        $this->command->info('Menjalankan Seeder Kursus JavaScript ES6+ Komprehensif...');
        $this->call(JsCourseSeeder::class);

        $this->command->info('Menjalankan Seeder Modul Dokumentasi Web Dev Lengkap...');
        $this->call(WebDevDocumentationModuleSeeder::class);

        $this->command->info('Seluruh Kurikulum Komprehensif Berhasil Diimpor!');
    }
}
