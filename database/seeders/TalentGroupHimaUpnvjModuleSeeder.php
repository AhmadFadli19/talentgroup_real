<?php

namespace Database\Seeders;

use App\Models\Module;
use App\Models\ModuleCategory;
use Illuminate\Database\Seeder;

class TalentGroupHimaUpnvjModuleSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedProtectedModule(
            categorySlug: 'pertemuan-1-talentgroup-infinity-hima-informatika-upnvj',
            lessonSlug: 'materi-pertemuan-1-talentgroup-infinity-hima-informatika-upnvj',
            name: 'Pertemuan 1 TalentGroup.id x Infinity HIMA INFORMATIKA UPNVJ',
            description: 'Mengubah case SDG menjadi rancangan solusi digital: pengguna, masalah, solusi, user flow, fitur, dan rencana prototipe.',
            excerpt: 'Materi mentoring pertemuan pertama TalentGroup.id bersama Infinity HIMA Informatika UPNVJ.',
            icon: 'fas fa-people-group',
            color: '#0f5cc0',
            directory: 'modules/talentgroup-hima-upnvj/pertemuan-1',
            fileName: 'Materi Pertemuan 1 — Viewer Terproteksi',
            fileSize: 377319,
            pageCount: 15,
        );

        $this->seedProtectedModule(
            categorySlug: 'pertemuan-2-talentgroup-infinity-hima-informatika-upnvj',
            lessonSlug: 'materi-pertemuan-2-talentgroup-infinity-hima-informatika-upnvj',
            name: 'Pertemuan 2 TalentGroup.id x Infinity HIMA INFORMATIKA UPNVJ',
            description: 'Mengenal Figma, workspace, tools dasar, prototipe interaktif, Figma for Education, dan pemanfaatan AI yang relevan.',
            excerpt: 'Materi kelas Figma pertemuan kedua TalentGroup.id bersama Infinity HIMA Informatika UPNVJ.',
            icon: 'fab fa-figma',
            color: '#a259ff',
            directory: 'modules/talentgroup-hima-upnvj/pertemuan-2',
            fileName: 'Materi Pertemuan 2 — Viewer Terproteksi',
            fileSize: 4084201,
            pageCount: 14,
        );
    }

    private function seedProtectedModule(
        string $categorySlug,
        string $lessonSlug,
        string $name,
        string $description,
        string $excerpt,
        string $icon,
        string $color,
        string $directory,
        string $fileName,
        int $fileSize,
        int $pageCount,
    ): void {
        $existingCategory = ModuleCategory::where('slug', $categorySlug)->first();
        $order = $existingCategory?->order ?? ((int) ModuleCategory::max('order') + 1);

        $category = ModuleCategory::updateOrCreate(
            ['slug' => $categorySlug],
            [
                'name' => $name,
                'description' => $description,
                'is_public' => true,
                'referral_code' => null,
                'icon' => $icon,
                'color' => $color,
                'badge' => 'Materi Mentoring',
                'order' => $order,
                'is_active' => true,
                'enable_anti_screenshot' => true,
                'enable_anti_copy' => true,
            ]
        );

        Module::updateOrCreate(
            ['slug' => $lessonSlug],
            [
                'category_id' => $category->id,
                'section' => 'MATERI MENTORING',
                'title' => $name,
                'content_type' => 'protected_slides',
                'excerpt' => $excerpt,
                'content' => 'Materi ditampilkan sebagai slide terenkripsi yang hanya dapat dibaca melalui viewer TalentGroup.id.',
                'file_path' => $directory,
                'file_name' => $fileName,
                'file_size' => $fileSize,
                'page_count' => $pageCount,
                'order' => 1,
                'is_published' => true,
                'is_public' => true,
                'enable_protection' => true,
                'enable_anti_screenshot' => true,
                'enable_anti_copy' => true,
            ]
        );
    }
}
